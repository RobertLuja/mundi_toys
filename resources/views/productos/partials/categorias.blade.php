<div class="">
    <label for="precio" class="fw-bold">Categoría:</label>
    <select class="form-select" name="id_categoria" id="categoriaSelect">
        @foreach ($categorias as $categoria)
            <option class="fs-5" value="{{ $categoria->id }}"> 
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
</div>