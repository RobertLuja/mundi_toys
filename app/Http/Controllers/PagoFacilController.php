<?php

namespace App\Http\Controllers;

use App\Http\Enums\EstadoEnum;
use App\Models\PagoFacil;
use App\Models\Venta;
use Carbon\Carbon;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;

class PagoFacilController extends Controller
{
    

    public function generarQR(Request $request) {
        $idVenta = $request->input("id_venta");
        
        $venta = Venta::customDetalleVentas($idVenta);

        if($venta->estado == EstadoEnum::Procesado->value){
            return response()->json([
                "status" => 400,
                "message" => "Esta factura ya fue procesado!" 
            ]);
        }

        if($venta->estado == EstadoEnum::Anulado->value){
            return response()->json([
                "status" => 400,
                "message" => "Esta factura está anulada!" 
            ]);
        }

        if($venta->pagoFacil != null){
            if($this->verificarFechaLimiteTransaccion($venta->pagoFacil->expiracion)){
                return response()->json([
                    "status" => 400,
                    "message" => "QR ya generado"
                ]);
            }else{
                $this->actualizarEstadoTransaccion($venta->pagoFacil->id, $venta->pagoFacil->name_image);
            }
        }

        if($venta->cantidadTransaccion >= 3){
            return response()->json([
                "status" => 400,
                'message' => "Cantidad de transacción no disponible"
            ]);
        }
        
        try {
            $laPedidoDetalleVenta = [];
            foreach($venta->detalleVentas as $detalleVenta) {
                array_push($laPedidoDetalleVenta,
                    [
                        "Serial" => $detalleVenta->id,
                        "Producto" => $detalleVenta->producto->nombre,
                        "Cantidad" => $detalleVenta->cantidad,
                        "Precio" => $detalleVenta->producto->precio,
                        "Descuento" => "0",
                        "Total" => $detalleVenta->precioTotal,
                    ]
                );
            }

            $loClient = new Client();
            $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            $laHeader = [
                'Accept' => 'application/json'
            ];
            $laBody   = [
                "tcCommerceID"          => "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c",
                "tnMoneda"              => 2,
                "tnTelefono"            => "78048365",
                'tcNombreUsuario'       => $venta->cliente->nombre.' '.$venta->cliente->apellido,
                'tnCiNit'               => $venta->cliente->ci,
                'tcNroPago'             => 'fact-mundi-'.$venta->id,
                "tnMontoClienteEmpresa" => $venta->precioTotal,
                "tcCorreo"              => $venta->cliente->email,
                'tcUrlCallBack'         => "http://localhost/",
                "tcUrlReturn"           => "http://localhost/",
                'taPedidoDetalle'       => $laPedidoDetalleVenta
            ];

            $loResponse = $loClient->post(
                $lcUrl,
                [
                    'headers' => $laHeader,
                    'json' => $laBody
                ]
            );

            $laResult = json_decode($loResponse->getBody()->getContents()); //Obtener el resultado del generarQR

            if($laResult->error == 1){ //Verificar si hay error en la petición
                return response()->json([
                    "status" => 400,
                    "message" => "QR ya generado ó, " . $laResult->messageSistema
                ]);
            }


            $laValuesArray = explode(";", $laResult->values);
            $idTransaccionPago = $laValuesArray[0]; //Recuperar el id de transacción
            $resultQR = json_decode($laValuesArray[1]); //Recuperar la imagen QR en formato json

            $laQrImage = "data:image/png;base64,".$resultQR->qrImage;

            /** --------------------------Guardando la imagen */
            $resultImage = $this->guardarImagen($laQrImage);
            if( $resultImage->status == 400 ){
                return response()->json([
                    "status" => 400,
                    "message" => "Imagen no guardado, consulte con el admin"
                ]);
            }

            /** -----------------Guardando la transacción----------------- */
            $pagoFacil = $this->guardarPagoFacilTransaccion(
                $idTransaccionPago,
                $resultImage->result->fileName,
                $resultImage->result->url[0],
                $resultQR->expirationDate,
                $venta->id
            );

            return response()->json([
                "status" => 201,
                'data' => [
                    "url_qr" => $pagoFacil->url_qr,
                    "expiracion" => $pagoFacil->expiracion,
                    "cantidadTransaccion" => $venta->cantidadTransaccion + 1
                ]
            ]);
            //echo '<img src="' . $laQrImage . '" alt="Imagen base64">';
        } catch (\Throwable $th) {

            return $th->getMessage() . " - " . $th->getLine();
        }
    }

    private function guardarPagoFacilTransaccion($id_transaccion, $name_image, $url_qr, $expiracion, $id_venta){
        $pagoFacil = new PagoFacil();
        $pagoFacil->id_transaccion = $id_transaccion;
        $pagoFacil->name_image = $name_image;
        $pagoFacil->url_qr = $url_qr;
        $pagoFacil->expiracion = $expiracion;
        $pagoFacil->id_venta = $id_venta;
        $pagoFacil->fecha_registro = Carbon::now();
        $pagoFacil->save();

        return $pagoFacil;
    }

    private function verificarFechaLimiteTransaccion($expiracion) {
        $fechaLimite = new DateTime(strval($expiracion));
        $fechaActual = new DateTime('now');

        if($fechaLimite >= $fechaActual)
            return true;
        return false;
    }

    public function actualizarEstadoTransaccion($idPagoFacil, $nameImage) {
        //-----------Actualizar el estado a 0 de la transacción actual
        $pagoFacilCurrentUpdate = PagoFacil::find($idPagoFacil);
        $pagoFacilCurrentUpdate->estado = 0;
        $pagoFacilCurrentUpdate->save();

        //------------Eliminar la imagen del qr
        $imageDeleted = $this->eliminarImagen($nameImage);
        if($imageDeleted == 404){
            // Guardar logs para el admin de este error de imagen no encontrado u otro error
        }
    }

    private function guardarImagen(string $imageBase64) {
        $client = new Client();
        $response = $client->post(
            "http://localhost:3000/api/images/upload/base64",
            [
                "multipart" => [
                    [
                        'name' => 'image',
                        'contents' => $imageBase64,
                    ],
                ],
            ]
        );
        $result = json_decode($response->getBody()->getContents());
        return $result;
    }

    private function eliminarImagen(string $nameImage) {
        try{ //Se resuelve con un status code 204
            $client = new Client();
            $response = $client->delete("http://localhost:3000/api/images/$nameImage");
            $status = $response->getStatusCode();
            return $status;
        }catch (RequestException $e){ //Se resuelve con un status code 404 u otro
            $response = $e->getResponse();
            if ($response) {
                return $response->getStatusCode();
            }
            return 500;
        }
    }

    public function consultarEstado(Request $request) {

        $idVenta = $request->input("id_venta");
        
        $venta = Venta::customDetalleVentas($idVenta);

        if($venta->estado == EstadoEnum::Procesado->value){
            return response()->json([
                "status" => 400,
                "message" => "Esta factura ya fue procesado!" 
            ]);
        }

        if($venta->estado == EstadoEnum::Anulado->value){
            return response()->json([
                "status" => 400,
                "message" => "Esta factura está anulada!" 
            ]);
        }

        try{
            $client = new Client();
            $response = $client->post(
                "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion",
                [
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'json' => [
                        "TransaccionDePago" => $venta->pagoFacil->id_transaccion
                    ]
                ]
            );
            $resultEstadoTransaccion = json_decode($response->getBody()->getContents());
            if($response->getStatusCode() == 200){
                if(strpos($resultEstadoTransaccion->values->messageEstado, "COMPLETADO - PROCESADO") !== false){
                    //Realizar que la venta sea como procesado, finalizar la compra
                    //Enviar correo de confirmación
                    //Otras acciones
                }
                return response()->json([
                    "status" => 200,
                    "data" => $resultEstadoTransaccion
                ]);
            }
        }catch(RequestException $e){
            // Hacer algo cuando haya algún error
        }
    }
}
