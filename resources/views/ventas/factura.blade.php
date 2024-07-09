@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')
    
    <div>
        <div class="d-flex">
            <h5 class="fw-bold pe-2">Venta:</h5>
            <span>{{ $venta->glosa }}</span>
        </div>

        <div class="d-flex">
            <h5 class="fw-bold pe-2">Estado:</h5>
            @if ($venta->estado == 0)
                <span 
                    class="bg-warning text-dark p-1 rounded-pill"
                    >
                    Pendiente
                </span>
            @elseif ($venta->estado == 1)
                <span 
                    class="bg-success text-light p-1 rounded-pill"
                    >
                    Procesado
                </span>
            @else
                <span 
                    class="bg-danger text-light p-1 rounded-pill"
                    >
                    Anulado
                </span>
            @endif
        </div>

        <a href="{{ route("ventas.index" )}}" class="btn__secondary">Volver</a>
    </div>
    
    <div class="mt-4">
        <a href="{{ route("ventas.generatePdf", $venta->id) }}" id="btn-pdf" class="btn btn-outline-danger">
            <i class="bi bi-file-pdf fs-4"></i>
        </a>
    </div>

    <div class="mt-2 d-flex justify-content-between">
        <div class="w-100 card p-2" id="report-container">
            <div class="d-flex justify-content-between">
                <div>
                    <h2>MundiToys SRL</h2>
                    <p>Comercial Chiriguano. 3er Anillo</p>
                </div>
            </div>
        
            <div class="mt-2 mb-2" style="height: 2px; background-color: var(--primary-color);"></div>
            
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="fs-5"><strong>Facturar a</strong></h3>
                    <span class="d-flex">
                        <h4 class="fs-6 fw-bold pe-2">Nombre: </h4>
                        {{ $venta->cliente->nombre .' '.$venta->cliente->apellido }}
                    </span>
                    <span class="d-flex">
                        <h4 class="fs-6 fw-bold pe-2">Dirección: </h4>{{ $venta->cliente->direccion }}
                    </span>
                </div>
                
                <div>
                    <span class="d-flex justify-content-between"><h4 class="fs-6 fw-bold pe-2">
                        Fecha: </h4>{{ $venta->fecha_registro }}
                    </span>
                    <span class="d-flex justify-content-between">
                        <h4 class="fs-6 fw-bold pe-2">Nro Pedido: </h4>
                        <span id="idVenta">{{ $venta->id }}</span>
                    </span>
                </div>
            </div>
        
            <table class="table mt-4">
                <thead class="table-head">
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detalleVentas as $detalleVenta)
                        <tr>
                            <td>{{ $detalleVenta->producto->nombre }}</td>
                            <td>{{ $detalleVenta->cantidad }}</td>
                            <td>{{ $detalleVenta->producto->precio }}</td>
                            <td>{{ $detalleVenta->precioTotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <h5 style="text-align: right;">Total de la Factura: Bs {{ $venta->precioTotal }}</h5>
        </div>

        @if ($venta->estado == 0)
            @can('metodo-pago')
                <div class="card p-2" style="width: auto; height: auto;">
                    <form 
                        action="{{ route('ventas.destroy', $venta->id) }}" 
                        method="post"
                        onclick="return confirm('¿Estás seguro de anular esta factura?')"
                        >
                        @csrf
                        @method("delete")
                        <button type="submit" class="btn__option_delete">Anular factura</button>
                    </form>

                    <label for="pagoSelect" class="fw-bold">Métodos de pagos:</label>
                    <select class="form-select" name="id_pago" id="pagoSelect">
                            <option class="fs-5" value="pagoFacil1">
                                PagoFacil
                            </option>
                            <option class="fs-5" value="efectivo1">
                                Efectivo
                            </option>
                            <option class="fs-5" value="-1">
                                ---
                            </option>
                    </select>
                    <div>
                        @include('ventas.pagos.pagofacil')
                        @include('ventas.pagos.efectivo')
                    </div>
                </div>
            @endcan
        @endif
    </div>

    @if (session("info"))
        <x-alert
            icon="bi bi-check-circle-fill"
            color="#4caf50"
            message="{{session('info')}}"
        />
    @endif

    <div id="containerAlert"></div>
@endsection

@section('js')
    <script>
        const pagoSelect = document.getElementById("pagoSelect");
        const containerPagoFacil = document.getElementById("containerPagoFacil");
        const containerEfectivo = document.getElementById("containerEfectivo");

        pagoSelect.addEventListener("change", function() {
            clearContainerTiposPagos();

            if(pagoSelect.value == "pagoFacil1"){
                containerPagoFacil.style.display = "block";
            }else if (pagoSelect.value == "efectivo1"){
                containerEfectivo.style.display = "block";
            }
        });

        function clearContainerTiposPagos(){
            containerPagoFacil.style.display = "none";
            containerEfectivo.style.display = "none";
        }

        function showAlertError(message){
            const alertError = `
                    <x-alert
                        icon="bi bi-check-circle-fill"
                        color="crimson"
                        message="${message}"
                    />
                `;
            return alertError;
        }
    </script>
@endsection