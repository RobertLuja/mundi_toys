<div class="form-group mb-4 mb-lg-0">
    <label for="almacenSelect" class="fw-bold">Almacenes:</label>
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

    <div class="mt-3" id="infoAlmacen" style="display: none;">
        
        <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
        
        <div class="card">
            <div class="card-body row row-cols-lg-2">
                <div>
                    <h3>Almacen</h3>
                    <div class="form-group">
                        <label class="form-input-label" for="nombre">Nombre:</label>
                        <div class="form-input" id="nombreAlmacen">Mi nombre</div>
                    </div>
                    <div class="form-group">
                        <label class="form-input-label" for="descripcion">Descripción:</label>
                        <div class="form-input" id="descripcionAlmacen">Mi descripcion</div>
                    </div>
                </div>

                {{-- <hr> --}}

                <div>
                    <h3>Sucursal</h3>
                    <div class="form-group">
                        <label class="form-input-label" for="nombreSucursal">Nombre:</label>
                        <div class="form-input" id="nombreSucursal">Mi nombre sucursal</div>
                    </div>
                    <div class="form-group">
                        <label class="form-input-label" for="direccionSucursal">Dirección:</label>
                        <div class="form-input" id="direccionSucursal">Mi direccion sucursal</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const almacenSelect = document.getElementById('almacenSelect');

    almacenSelect.addEventListener('change', function() {

        var almacenId = almacenSelect.value;

        if(almacenId == -1) {
            document.getElementById("infoAlmacen").style.display = "none";
            return;
        }
        sendData(
            "../almacenes/buscarById",
            {
            "query": almacenId
            }
        )
        .then(res => res.json())
        .then(data => {
                const almacen = data;
                document.getElementById("infoAlmacen").style.display = "block";

                document.getElementById("nombreAlmacen").textContent = almacen.nombre;
                document.getElementById("descripcionAlmacen").textContent = 
                                                            almacen.descripcion == null
                                                            ? "Sin descripción"
                                                            : almacen.descripcion;
                document.getElementById("nombreSucursal").textContent = almacen.sucursal.nombre;
                document.getElementById("direccionSucursal").textContent = almacen.sucursal.direccion;
        })
        .catch(error => console.error('Error al realizar la búsqueda:', error));
    });
</script>