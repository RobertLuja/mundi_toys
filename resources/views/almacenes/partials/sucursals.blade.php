<div class="form-group mb-4 mb-lg-0">
    <label for="sucursalSelect" class="fw-bold">Sucursales:</label>
    <select class="form-select" name="id_sucursal" id="sucursalSelect">
        @foreach ($sucursals as $sucursal)
            <option class="fs-5" value="{{ $sucursal->id }}">
                {{ $sucursal->nombre }}
            </option>
        @endforeach
    </select>

    <div class="mt-3" id="infoSucursal" style="display: none;">
        
        <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
        
        <div class="card">
            <div class="card-body">
                <div class="form-group col-12">
                    <label class="form-input-label" for="nombre">Nombre:</label>
                    <div class="form-input" id="nombreSucursal">Mi nombre</div>
                </div>
                <div class="form-group col-12">
                    <label class="form-input-label" for="direccion">Dirección:</label>
                    <div class="form-input" id="direccionSucursal">Mi direccion</div>
                </div>
            </div>
        </div>
    </div>
</div>