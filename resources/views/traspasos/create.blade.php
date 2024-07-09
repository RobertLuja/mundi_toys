@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/show-data.css')}}">
@endsection

@section('content')
    
    <div class="p-lg-4" id="containerTraspaso">
        <h2>Traspaso</h2>
        <form method="POST">
            @csrf
            <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
            
            <div class="row row-cols-lg-3 row-cols-md-2  row-cols-1">
                <div class="form-group">
                    <label for="glosa">Glosa:</label>
                    <textarea class="form-control" id="glosa">{{ old('glosa') }}</textarea>
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="cantidad">Cantidad:</label>
                    <input 
                        type="number"
                        class="form-control" 
                        id="cantidad" 
                        value="{{ old('cantidad') }}" 
                        required
                    >
                </div>
            </div>

            {{-- Almacenes --}}

            <div class="row row-cols-lg-2 row-cols-md-2  row-cols-1">
                @include('traspasos.partials.almacenes_origen')
                @include('traspasos.partials.almacenes_destino')
            </div>

            {{-- Buttons --}}
            <div 
                class="row 
                        row-cols-lg-4 
                        row-cols-md-4 
                        row-cols-sm-2 
                        row-cols-1 
                        mt-4 ms-lg-2 ms-md-2 ms-sm-2 ms-2 me-2">
                
                <button
                    type="button"
                    class="btn__danger me-lg-2 me-md-2 me-sm-2 mb-lg-0 mb-md-0 mb-2"
                    data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Al confirmar los almacenes no se podrá modificar los almacenes de origen y destino"
                    id="btnConfirmarAlmacenes"
                    >Confirmar Almacenes
                </button>

                <button
                    type="button"
                    class="btn__primary me-lg-2 me-md-2 me-sm-2 mb-lg-0 mb-md-0 mb-2"
                    style="display: none;"
                    id="btnDetalleTraspaso"
                    >Agregar detalle
                </button>
                
                <button 
                    type="button"
                    class="btn__secondary"
                    style="display: none;"
                    id="btnFinalizarTraspaso"
                    >Finalizar Traspaso
                </button>
            </div>

            <span class="mt-4"></span>
            <hr>

            {{-- Detalles --}}
            @include('traspasos.partials.detalle_traspaso')
        </form>
    </div>

    {{-- Message --}}
    <div
        style="position: absolute; top: 45%; right: 45%; display: none;"
        id="containerCircular">
        <div class="d-flex flex-column">
            <div
                class="spinner-border"
                role="status"
                style="margin: auto; width: 4rem; height: 4rem;" 
                role="status">
            </div>
            <span class="text-center mt-2">Guardando...</span>
        </div>
    </div>

    {{-- Alert --}}
    <div id="containerAlert"></div>


@endsection

@section('js')
    <script>        
        const glosa = document.getElementById('glosa');
        glosa.textContent = "";
        
        const containerAlert = document.getElementById("containerAlert");
        const btnDetalleTraspaso = document.getElementById("btnDetalleTraspaso");
        const btnFinalizarTraspaso = document.getElementById("btnFinalizarTraspaso");
        const btnConfirmarAlmacenes = document.getElementById("btnConfirmarAlmacenes");

        var detallesTraspasos = [];

        btnConfirmarAlmacenes.addEventListener("click", () => {
            var almacenOrigenId = almacenOrigenSelect.value;
            var almacenDestinoId = almacenDestinoSelect.value;

            if(almacenOrigenId == -1 || almacenDestinoId == -1) {
                containerAlert.innerHTML = showAlertError("Almacen","Por favor seleccione los almacenes");
                return;
            }

            if(almacenOrigenId == almacenDestinoId) {
                containerAlert.innerHTML = showAlertError("Almacen","Los almacenes deben ser diferentes");
                return;
            }

            almacenOrigenSelect.setAttribute("disabled", "");
            almacenDestinoSelect.setAttribute("disabled", "");
            btnConfirmarAlmacenes.setAttribute("disabled", "");
            btnDetalleTraspaso.style.display = "block";
            btnFinalizarTraspaso.style.display = "block";

        });

        btnDetalleTraspaso.addEventListener("click", () => {

            var productoId = productoSelect.value;
            var productoName = productoSelect.options[productoSelect.selectedIndex].text;

            if(productoId == -1) {
                containerAlert.innerHTML = showAlertError("Producto", "Por favor seleccione un producto");
                return;
            }

            if(cantidad.value == 0) {
                containerAlert.innerHTML = showAlertError("Cantidad", "Ingrese una cantidad mayor o igual a 1");
                cantidad.value = 1;
                return;
            }

            sendData(
                "../traspasos/detalleTraspaso",
                { 
                    "almacenOrigenId": almacenOrigenSelect.value,
                    "productoId": productoId,
                    "cantidad": cantidad.value 
                }
            )
            .then(res => res.json())
            .then(data => {
                // console.log(data); return;
                if(data.status == 400){
                    containerAlert.innerHTML = showAlertError("Stock", data.message);
                }else{
                    var detalleTraspaso = {
                        "producto": {
                            "id": productoId,
                            "nombre": productoName
                        },
                        "cantidad": document.getElementById("cantidad").value,
                        "id": idIncrement
                    }
                    const existeDetalleTraspaso = detallesTraspasos.filter( 
                        detTraspaso => detTraspaso.producto.id == detalleTraspaso.producto.id );
                    
                    if(existeDetalleTraspaso.length == 0){
                        detallesTraspasos.push(detalleTraspaso);
                        createItemTr(detalleTraspaso);
                    }else{
                        containerAlert.innerHTML = showAlertError("Stock", "El producto a agregar ya existe, considera eliminar del detalle si desea cambiar la cantidad de traspaso");
                    }
                }
            })
            .catch(error => {
                console.error('Error al realizar la búsqueda:', error);
                alert("Error, revise los logs");
            });
        });

        btnFinalizarTraspaso.addEventListener("click", () => {

            btnDetalleTraspaso.setAttribute("disabled", "");
            btnFinalizarTraspaso.setAttribute("disabled", "");
            containerCircular.style.display = "block";

            const miTraspaso = {
                "glosa": glosa.value,
                "almacenOrigenId": almacenOrigenSelect.value,
                "almacenDestinoId": almacenDestinoSelect.value,
                "detalle": detallesTraspasos
            }
            
            sendData(
                "../traspasos/guardarTraspaso",
                miTraspaso
            )
            .then(res => res.json())
            .then(data => {
                    // console.log(data); return;
                    if(data.status == 400){
                        containerAlert.innerHTML = showAlertError("Stock", data.message);
                        containerCircular.style.display = "none";
                        btnDetalleTraspaso.removeAttribute("disabled", "");
                        btnFinalizarTraspaso.removeAttribute("disabled", "");
                    }else { //Datos guardados, mostrar 
                        containerCircular.style.display = "none";
                        containerAlert.innerHTML = showAlertSuccess("Traspaso satisfactorio", `${data.message}, redirigiendo en 2 segundos`);
                        setTimeout(() => {
                            btnDetalleTraspaso.removeAttribute("disabled", "");
                            btnFinalizarTraspaso.removeAttribute("disabled", "");
                            window.location.href = '../traspasos';
                        }, 2000);
                    }
            })
            .catch(error => {
                containerCircular.style.display = "none";
                btnDetalleTraspaso.removeAttribute("disabled", "");
                btnFinalizarTraspaso.removeAttribute("disabled", "");
                console.error('Error al realizar la búsqueda:', error);
                alert("Error, revise los logs");
            });
        });

        function showAlertError(title, message){
            const alertError = `
                            <x-alert2
                                icon="bi bi-exclamation-circle"
                                color="crimson"
                                title="${title}"
                                description="${message}"
                            />
                            `;
            return alertError;
        }

        function showAlertSuccess(title, message){
            const alertSuccess = `
                            <x-alert2
                                icon="bi bi-check-circle-fill"
                                color="#4caf50"
                                title="${title}"
                                description="${message}"
                            />
                            `;
            return alertSuccess;
        }
    </script>
@endsection