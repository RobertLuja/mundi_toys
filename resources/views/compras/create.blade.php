@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/show-data.css')}}">
@endsection

@section('content')
    
    <div class="p-lg-4" id="containerCompra">
        <h2>Compra</h2>
        <form method="POST">
            @csrf
            <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
            
            <div class="row row-cols-lg-3 row-cols-md-2  row-cols-1">
                <div class="form-group">
                    <label for="glosa">Glosa:</label>
                    <textarea
                        class="form-control 
                        @error('glosa') is-invalid 
                        @enderror" 
                        id="glosa"
                        name="glosa"
                    >{{ old('glosa') }}
                    </textarea>
                    @error('glosa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="cantidad">Cantidad:</label>
                    <input 
                        type="number"
                        class="form-control @error('cantidad') is-invalid @enderror" 
                        id="cantidad" 
                        name="cantidad" 
                        value="{{ old('cantidad') }}" 
                        required
                    >
                    @error('cantidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @include('compras.partials.proveedores')
            </div>

            <div class="row row-cols-lg-2 row-cols-md-2  row-cols-1">
                @include('compras.partials.almacenes')
                @include('compras.partials.productos')
            </div>

            <div 
                class="row 
                        row-cols-lg-5 
                        row-cols-md-3 
                        row-cols-sm-2 
                        row-cols-1 
                        mt-4 ms-lg-2 ms-md-2 ms-sm-2 ms-2 me-2">
                <button
                    type="button"
                    class="btn__primary me-lg-2 me-md-2 me-sm-2 mb-lg-0 mb-md-0 mb-2"
                    id="btnDetalleCompra"
                    >Agregar detalle
                </button>
                
                <button 
                    type="button"
                    class="btn__secondary"
                    id="btnFinalizarCompra"
                    >Finalizar compra
                </button>
            </div>

            <span class="mt-4"></span>
            <hr>

            @include('compras.partials.detalle_compra')
        </form>
    </div>

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


@endsection

@section('js')
    <script>        
        const glosa = document.getElementById('glosa');
        glosa.textContent = "";
        
        const containerCompra = document.getElementById("containerCompra");
        const btnDetalleCompra = document.getElementById("btnDetalleCompra");
        const btnFinalizarCompra = document.getElementById("btnFinalizarCompra");

        var detallesCompras = [];

        btnDetalleCompra.addEventListener("click", () => {

            var almacenId = almacenSelect.value;
            var almacenName = almacenSelect.options[almacenSelect.selectedIndex].text;

            var productoId = productoSelect.value;
            var productoName = productoSelect.options[productoSelect.selectedIndex].text;

            if(almacenId == -1) {
                alert("Por favor seleccione un almacen");
                return;
            }

            if(productoId == -1) {
                alert("Por favor seleccione un producto");
                return;
            }

            if(cantidad.value == 0) {
                alert("Ingrese una cantidad mayor o igual a 1");
                cantidad.value = 1;
                return;
            }

            var detalleCompra = {
                "almacen": {
                    "id": almacenId,
                    "nombre": almacenName
                },
                "producto": {
                    "id": productoId,
                    "nombre": productoName
                },
                "cantidad": document.getElementById("cantidad").value,
                "id": idIncrement
            }
            detallesCompras.push(detalleCompra);
            createItemTr(detalleCompra)
        });

        btnFinalizarCompra.addEventListener("click", () => {

            containerCompra.style.opacity = "0.4";
            btnDetalleCompra.setAttribute("disabled", "");
            btnFinalizarCompra.setAttribute("disabled", "");
            containerCircular.style.display = "block";

            const miCompra = {
                "glosa": glosa.value,
                "ci_proveedor": document.getElementById("searchProveedor").value,
                "detalle": detallesCompras
            }
            
            sendData(
                "../compras/guardarCompra",
                miCompra
            )
            .then(res => res.json())
            .then(data => {
                    if(data.status == 400){
                        alert(data.message);
                        containerCircular.style.display = "none";
                        containerCompra.style.opacity = "1";
                        btnDetalleCompra.removeAttribute("disabled", "");
                        btnFinalizarCompra.removeAttribute("disabled", "");
                    }else { //Datos guardados, mostrar 
                        containerCircular.style.display = "none";
                        containerCompra.style.opacity = "1";
                        
                        const alert = `<x-alert icon='bi bi-check-circle-fill' color='#4caf50' message='${data.message} Redirigiendo en 2 Segundos'/>`;
                        containerCompra.innerHTML = containerCompra.innerHTML + alert;
                        setTimeout(() => {
                            btnDetalleCompra.removeAttribute("disabled", "");
                            btnFinalizarCompra.removeAttribute("disabled", "");
                            window.location.href = '../compras';
                        }, 2000);
                    }
            })
            .catch(error => {
                containerCircular.style.display = "none";
                containerCompra.style.opacity = "1";
                btnDetalleCompra.removeAttribute("disabled", "");
                btnFinalizarCompra.removeAttribute("disabled", "");
                console.error('Error al realizar la búsqueda:', error);
                alert("Error, revise los logs");
            });
        })
    </script>
@endsection