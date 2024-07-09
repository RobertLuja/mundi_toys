<div class="form-group mb-4 mb-lg-0">
    <label for="almacenDestinoSelect" class="fw-bold">Almacen (Destino):</label>
    <select class="form-select" name="id_almacen_destino" id="almacenDestinoSelect">
        @foreach ($almacenesDestino as $almacen)
            <option class="fs-5" value="{{ $almacen->id }}">
                {{ $almacen->nombre }}
            </option>
        @endforeach
            <option class="fs-5" value="-1">
                ---
            </option>
    </select>

    <div class="mt-3" id="infoAlmacenDestino" style="display: none;">
        
        <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
        
        <div class="card">
            <h3 class="text-center">Destino</h3>
            <div class="card-body row row-cols-1">
                <div class="form-group">
                    <label class="form-input-label" for="nombre">Nombre:</label>
                    <div class="form-input" id="nombreAlmacenDestino">Mi nombre</div>
                </div>
                <div class="form-group">
                    <label class="form-input-label" for="descripcion">Descripción:</label>
                    <div class="form-input" id="descripcionAlmacenDestino">Mi descripcion</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const almacenDestinoSelect = document.getElementById('almacenDestinoSelect');

    almacenDestinoSelect.addEventListener('change', function() {

        var almacenId = almacenDestinoSelect.value;

        if(almacenId == -1) {
            document.getElementById("infoAlmacenDestino").style.display = "none";
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
                document.getElementById("infoAlmacenDestino").style.display = "block";

                document.getElementById("nombreAlmacenDestino").textContent = almacen.nombre;
                document.getElementById("descripcionAlmacenDestino").textContent = 
                                                            almacen.descripcion == null
                                                            ? "Sin descripción"
                                                            : almacen.descripcion;
        })
        .catch(error => console.error('Error al realizar la búsqueda:', error));
    });
</script>