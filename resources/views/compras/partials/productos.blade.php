<div class="form-group mb-4 mb-lg-0">
    <label for="productoSelect" class="fw-bold">Productos:</label>
    <select class="form-select" name="id_producto" id="productoSelect">
        @foreach ($productos as $producto)
            <option class="fs-5" value="{{ $producto->id }}">
                {{ $producto->nombre }}
            </option>
        @endforeach
            <option class="fs-5" value="-1">
                ---
            </option>
    </select>

    <div class="mt-3" id="infoProducto" style="display: none;">
        
        <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
        
        <div class="card">
            <div class="card-body">
                <div class="form-group col-12">
                    <label class="form-input-label" for="nombre">Nombre:</label>
                    <div class="form-input" id="nombreProducto">Mi nombre</div>
                </div>
                <div class="form-group col-12">
                    <label class="form-input-label" for="precio">Precio:</label>
                    <div class="form-input" id="precioProducto">Mi precio</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const productoSelect = document.getElementById('productoSelect');

    productoSelect.addEventListener('change', function() {

        var productoId = productoSelect.value;
        
        if(productoId == -1) {
            document.getElementById("infoProducto").style.display = "none";
            return;
        };
        sendData(
            "../productos/buscarById",
            {
            "query": productoId
            }
        )
        .then(res => res.json())
        .then(data => {
                const producto = data;
                document.getElementById("infoProducto").style.display = "block";

                document.getElementById("nombreProducto").textContent = producto.nombre;
                document.getElementById("precioProducto").textContent = producto.precio;
        })
        .catch(error => console.error('Error al realizar la búsqueda:', error));
    });
</script>