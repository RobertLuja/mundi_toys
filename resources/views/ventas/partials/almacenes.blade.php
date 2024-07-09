<div class="form-group mb-4 mb-lg-0 d-flex flex-column justify-content-center  mt-auto">
    <label for="almacenSelect" class="fw-bold">Almacenes:</label>
    <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
    <select class="form-select" name="id_almacen" id="almacenSelect">
        @foreach ($almacenes as $almacen)
            <option class="fs-5" value="{{ $almacen->id }}">
                {{ $almacen->nombre }}
            </option>
        @endforeach
            <option class="fs-5" value="-1">
                ---
            </option>
    </select>
</div>

<script>
    const almacenSelect = document.getElementById('almacenSelect');
    let almacenId = -1;
    let productsInCart = [];

    almacenSelect.addEventListener('change', function() {

        almacenId = almacenSelect.value

        // console.log(almacenId);
        if(almacenId == -1) {
            return;
        }
        sendData(
            "../almacenes/buscarAlmacenProductos",
            {
            "query": almacenId
            }
        )
        .then(res => res.json())
        .then(data => {
                products = data.productos;
                mainContainerLeft.innerHTML = "";
                renderProductosToHTML(products);
                // console.log(products);
        })
        .catch(error => console.error('Error al realizar la búsqueda:', error));
    });

    function renderProductosToHTML(products) {
        products.forEach(product => {
            renderProducto(mainContainerLeft, product);
        });
        increaseAndReduceQuantity(products);
    }

    function changeValueToCantidad( cantidadElement, valueAdd ) {
        let currentValue = parseInt(cantidadElement.textContent);
    
        if(currentValue == 0 && valueAdd < 0) {
            return;
        }
        cantidadElement.textContent =  (currentValue + valueAdd).toString();
    }

    function increaseAndReduceQuantity(products) {
        const cantidadProductAdded = document.getElementsByClassName("cantidadProductAdded");
        
        const btnQuitProduct = document.getElementsByClassName("btnQuitProduct");
        
        const btnAddProduct = document.getElementsByClassName("btnAddProduct");
        
        const btnAddToCart = document.getElementsByClassName("btnAddToCart");

        for(let index = 0; index < cantidadProductAdded.length; index++){
            
            const cantidadProductAddedSelected = cantidadProductAdded[index];

            const btnAddProductSelected = btnAddProduct[index];

            const btnQuitProductSelected = btnQuitProduct[index];

            const btnAddToCartSelected = btnAddToCart[index];

            //Event Increase Quantity To Product
            btnAddProductSelected.addEventListener("click", () => {
                changeValueToCantidad(cantidadProductAddedSelected, +1);
            });
            
            //Event Reduce Quantity To Product
            btnQuitProductSelected.addEventListener("click", () => {
                changeValueToCantidad(cantidadProductAddedSelected, -1);
            });

            //Event Add Product To Cart
            btnAddToCartSelected.addEventListener("click", () => {
                addProductToCart(products[index], parseInt(cantidadProductAddedSelected.textContent))
                cantidadProductAddedSelected.textContent = '0';
            })
        }
    }

    function addProductToCart(product, cantidad) {

        const findProduct = productsInCart.filter( prod => prod.product.id == product.id);
        if(findProduct.length > 0){
            containerAlert.innerHTML = showAlertError("Producto en carrito", "Producto ya agregado al carrito, para readicionar eliminar producto del carrito");
            // console.log("Producto ya agregado al carrito, para readicionar eliminar producto del carrito");
            return;
        }

        if(cantidad == 0){
            containerAlert.innerHTML = showAlertError("Producto en carrito", "Al menos se requiere un producto");
            // console.log("Al menos se requiere un producto");
            return;
        }

        if(cantidad > product.stock){
            containerAlert.innerHTML = showAlertError("Producto en carrito", "La cantidad de productos a agregar excede el stock");
            // console.log("La cantidad de productos a agregar excede el stock");
            return;
        }

        const productCart = {
            product,
            cantidad,
            "id_almacen": parseInt(almacenId),
            "precioTotal": product.precio * cantidad
        };

        // console.log(productCart);
        renderProductInCartHtml(productCart);
        changeQuantityToCart(productCart.precioTotal, "INCREASE");
        productsInCart.push(productCart);
        removeProductOfCart(productCart);
    }

    function removeProductOfCart(productCart) {

        const btnQuitarProductoCarrito = document.getElementById(`btnQuitarProductoCarrito${productCart.product.id}`);

        btnQuitarProductoCarrito.addEventListener("click", () => {
            productsInCart = productsInCart.filter(
                prodCart => prodCart.product.id != productCart.product.id
            );
            changeQuantityToCart(productCart.precioTotal, "DECREASE");

            document.getElementById("containerCarritoBody")
                    .removeChild(
                        document.getElementById(`productInCart${productCart.product.id}`)
                    );
        });
    }

    function changeQuantityToCart(totalPrecioProducto, typeQuatityToCart) {
        const cantidadCarritos = document.getElementsByClassName("cantidadCarrito");
        
        const totalPrecioCarrito = document.getElementById("totalPrecioCarrito");
        let cantidadTotal = 0;

        if(cantidadCarritos.length > 0) {
            switch(typeQuatityToCart){
                case "INCREASE":
                    totalPrecioCarrito.textContent = (parseFloat(totalPrecioCarrito.textContent) + totalPrecioProducto).toString();
                    cantidadTotal = parseInt(cantidadCarritos[0].textContent) + 1;
                break;
                case "DECREASE":
                    totalPrecioCarrito.textContent = (parseFloat(totalPrecioCarrito.textContent) - totalPrecioProducto).toString();
                    cantidadTotal = parseInt(cantidadCarritos[0].textContent) - 1;
                break;
                default:
                    console.log("Tipo no encontrado");
            }
        }
        
        for(let i = 0; i < cantidadCarritos.length; i++){
            cantidadCarritos[i].textContent = cantidadTotal.toString();
        }
    }
    
</script>