<div class="form-group mb-4 mb-lg-0">
    <label for="almacenOrigenSelect" class="fw-bold">Almacen (Origen):</label>
    <select class="form-select" name="id_almacen_origen" id="almacenOrigenSelect">
        @foreach ($almacenesOrigen as $almacen)
            <option class="fs-5" value="{{ $almacen->id }}">
                {{ $almacen->nombre }}
            </option>
        @endforeach
            <option class="fs-5" value="-1">
                ---
            </option>
    </select>

    <div class="mt-3" id="infoAlmacenOrigen" style="display: none;">
        
        <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
        
        <div class="card">
            <h3 class="text-center">Origen</h3>
            <div class="card-body row row-cols-1">
                <div class="form-group">
                    <label class="form-input-label" for="nombre">Nombre:</label>
                    <div class="form-input" id="nombreAlmacenOrigen">Mi nombre</div>
                </div>
                <div class="form-group">
                    <label class="form-input-label" for="descripcion">Descripción:</label>
                    <div class="form-input" id="descripcionAlmacenOrigen">Mi descripcion</div>
                </div>
                <hr>
                <div>
                    @include('traspasos.partials.productos')
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const almacenOrigenSelect = document.getElementById('almacenOrigenSelect');

    almacenOrigenSelect.addEventListener('change', function() {

        var almacenId = almacenOrigenSelect.value;

        if(almacenId == -1) {
            document.getElementById("infoAlmacenOrigen").style.display = "none";
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
            const almacen = data.almacen;
            const productos = data.productos;
            // console.log(data); return;
            document.getElementById("infoAlmacenOrigen").style.display = "block";

            document.getElementById("nombreAlmacenOrigen").textContent = almacen.nombre;
            document.getElementById("descripcionAlmacenOrigen").textContent = 
                                                        almacen.descripcion == null
                                                        ? "Sin descripción"
                                                        : almacen.descripcion;

            const productoSelect = document.getElementById('productoSelect');
            
            infoProducto.style.display = "none";
            productoSelect.innerHTML = '';

            data.productos.forEach(producto => {
                const option = document.createElement('option');
                option.value = producto.id;
                option.text = producto.nombre;

                productoSelect.appendChild(option);
            });
            const option = document.createElement('option');
            option.value = -1;
            option.text = "---";
            productoSelect.appendChild(option);
        })
        .catch(error => console.error('Error al realizar la búsqueda:', error));
    });
</script>