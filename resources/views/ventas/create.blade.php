@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/ventas.css')}}">
@endsection

@section('content')
    <div id="containerCreateCarrito">
        <div
            id="navheader"
            style="background-color: var(--secondary-color); border-radius: 5px; color: var(--white-color);">
            <div>
                @include('ventas.partials.almacenes')
                <div class="d-flex flex-column justify-content-center col-lg-6 col-md-8 ms-lg-2 ms-md-2 m-0 mt-lg-auto">
                    <input 
                        type="text" 
                        class="form-control"
                        id="inputSearchProduct" 
                        placeholder="Buscar producto" class="">
                </div>
                <div class="m-2">
                    <button
                        class="btn__cart position-relative"
                        id="btn__cart"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver carrito"
                        >
                        <i class="bi bi-cart4 text-light fs-2"></i>
                        <span
                            class="cantidadCarrito mt-2 position-absolute start-0 translate-middle badge rounded-pill bg-danger">0
                        </span>
                    </button>
                </div>
            </div>
            <div class="mt-lg-2">
                <span>
                    <input type="text" name="id_cliente" id="idCliente" value="{{ $cliente->id }}" hidden="true">
                    <strong>Cliente: </strong> {{ $cliente->nombre. ' '.$cliente->apellido  }}
                </span>
            </div>
        </div>

        <div id="mainContainer">
            <div id="mainContainerLeft">
                
            </div>

            <div id="mainContainerRight">
                <div id="containerCarrito">
                    <div class="containercarrito-header d-flex justify-content-between">
                        <div>
                            <h3 class="text-success">Carrito</h3>
                            <div class="d-flex justify-content-between">
                                <strong class="text-success">Total: </strong>
                                <p class="text-success" id="totalPrecioCarrito">0</p>
                            </div>
                        </div>
                        <span
                            class="cantidadCarrito me-0 mt-2 m-auto badge rounded-pill bg-success"
                            style="font-size: 16px;">0
                        </span>
                    </div>
                    <div class="containercarrito-body w-auto" id="containerCarritoBody">
                        
                    </div>

                    <div class="d-flex justify-content-center m-2">
                        <button
                            class="btn btn-primary p-1 ps-3 pe-3"
                            id="btnPagarCarrito">
                            Pagar
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
            <span class="text-center mt-2">Generando factura...</span>
        </div>
    </div>

    <div id="containerAlert"> 
        
    </div>

@endsection

@section('js')
    <script src="{{asset('js/templatesStringHtml.js')}}"></script>
    <script>
        const mainContainerLeft = document.getElementById("mainContainerLeft");
        const btnPagarCarrito = document.getElementById("btnPagarCarrito");
        const containerAlert = document.getElementById("containerAlert");

        /*Variables para buscar productos*/
        let typingTimer;
        let inputSearchProduct = document.getElementById('inputSearchProduct');
        let currentPage = 1; // Página actual para la búsqueda
        let resultsPerPage = 5; // Cantidad de resultados por página
        /*-----------------------------------------------*/
        
        document.getElementById("btn__cart")?.addEventListener("click", () => {

            const mainContainerRight = document.getElementById("mainContainerRight");

            const displayMainContainerRight = getComputedStyle(mainContainerRight).display;
            if(displayMainContainerRight == "block")
                mainContainerRight.style.display = "none";
            else
                mainContainerRight.style.display = "block";
        });

        //Enviar productos para revisar el pago
        btnPagarCarrito.addEventListener("click", () => {
            // console.log(productsInCart);
            const containerCircular =  document.getElementById("containerCircular");
            containerCircular.style.display = "block";
            const containerCreateCarrito = document.getElementById("containerCreateCarrito");
            containerCreateCarrito.style.display = "none";

            sendData(
                "../ventas/pagarCarrito",
                {
                "id_cliente": parseInt(document.getElementById("idCliente").value), 
                "detalleCarrito": productsInCart
                }
            )
            .then(res => res.json())
            .then(result => {
                console.log(result);
                if(result.status == 400){
                    containerCircular.style.display = "none";
                    containerAlert.innerHTML = showAlertError("Ventas", result.message);
                    containerCreateCarrito.style.display = "block";
                }else if(result.status == 201){
                    window.location.href = `/ventas/${result.data.id}`
                }

            })
            .catch(error => console.error('Error al realizar la búsqueda:', error));
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

        inputSearchProduct.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            if (inputSearchProduct.value) {
                typingTimer = setTimeout(search, 100);
            };
        });

        function search() {
            var query = inputSearchProduct.value;
            if (query.length >= 2) { // Realizar la búsqueda solo si se han ingresado al menos 2 caracteres

                // console.log("id almacen: ", almacenSelect.value);

                sendData(
                    "../productos/buscarByName",
                    {
                    "query": query,
                    "id_almacen": parseInt(almacenSelect.value)
                    }
                )
                .then(res => res.json())
                .then(data => {

                        var startIndex = (currentPage - 1) * resultsPerPage;
                        var endIndex = startIndex + resultsPerPage;
                        var currentPageResults = data.slice(startIndex, endIndex);

                        mainContainerLeft.innerHTML = "";
                        renderProductosToHTML(currentPageResults);
                })
                .catch(error => console.error('Error al realizar la búsqueda:', error));
                
            }
        }

    </script>
@endsection