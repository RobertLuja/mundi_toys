function renderProducto(containerElement, producto) {
    const productoHTML = `
        <div class="card p-2 m-lg-3 m-md-2 mb-4 m-0 bg-light" id="cardProducts">
            <div class="card-body" id="cardContainerDescriptions">
                <h5 class="card-title">${producto.nombre}</h5>
                <p class="card-text">Descripción del producto: ${producto.nombre}</p>
            </div>
            <hr>
            <div class="card-body p-0">

                <div class="ms-2 mb-2">
                    <span id="stock" style="font-size: 16px;">
                        <strong>Precio: </strong>BS ${producto.precio}
                    </span>
                </div>
                
                <div class="ms-2 mb-2">
                    <span id="stock" style="font-size: 16px;">
                        <strong>Stock: </strong>${producto.stock}
                    </span>
                </div>
                
                <div 
                    class="cardButtonsAddAndQuit d-flex justify-content-between" id="cardContainerButtonsAddAndQuit">
                    
                    <div class="ms-2 m-auto">
                        <span class="cantidadProductAdded" style="font-size: 20px;">0</span>
                    </div>
                    
                    <div>
                        <button class="btnQuitProduct">
                            <i class="bi bi-dash-circle-fill text-danger" style="font-size: 30px;"></i>
                        </button>
                        <button class="btnAddProduct">
                            <i class="bi bi-plus-circle-fill text-success" style="font-size: 30px;"></i>
                        </button>
                    </div>    
                </div>

                <div class="d-flex mt-2" id="cardContainerAddToCart">
                    <button
                        class="btnAddToCart bg-success">
                        <span class="text-light">Agregar al carrito</span>
                        <i class="bi bi-cart4 text-light fs-5"></i>
                    </button>
                </div>
            </div>
        </div>
    `;

    containerElement.innerHTML += productoHTML;
}

function renderProductInCartHtml(productCart) {
    
    const containerCarritoBody = document.getElementById("containerCarritoBody");
    
    const productInCart = document.createElement("div");
    productInCart.classList.add("productInCart", "card", "p-2", "m-3", "bg-light");
    productInCart.setAttribute("id", `productInCart${productCart.product.id}`);

    const cardHtml = `
        <div class="card-body">
            <h5 class="card-title">${productCart.product.nombre}</h5>
        </div>
        <hr>
        <div class="card-body p-0">

            <div class="ms-2 mb-2">
                <span class="d-flex justify-content-between" style="font-size: 14px;">
                    <strong class="text-success">Cantidad: </strong>${productCart.cantidad}
                </span>
                <span class="d-flex justify-content-between" style="font-size: 14px;">
                    <strong class="text-success">Precio Unitario: </strong>BS ${productCart.product.precio}
                </span>
                <span class="d-flex justify-content-between" style="font-size: 14px;">
                    <strong class="text-success">Precio Total: </strong>BS ${productCart.precioTotal}
                </span>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                <button
                    class="btnQuitarProductoCarrito btn btn-danger p-0 ps-3 pe-3"
                    id="btnQuitarProductoCarrito${productCart.product.id}">
                    <small class="fw-bold">Quitar</small>
                </button>
            </div>
        </div>
    `;
    productInCart.innerHTML = cardHtml;
    containerCarritoBody.appendChild(productInCart);
}