<div class="">
    <div>
        <label for="search" class="fs-5">Proveedor</label>
        <input 
            class="form-control @error('ci') is-invalid 
            @enderror" 
            type="number"
            id="searchEmpleado"
            name="ci"
            placeholder="Buscar ci"
        >
        @error('ci')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
    </div>
    <div class="mt-2" id="displayEmpleado"></div>
</div>

<script>
    var searchEmpleado = document.getElementById('searchEmpleado');

    searchEmpleado.addEventListener('keyup', function() {
        if (searchEmpleado.value) {
            searchProveedorM();
        };
    });

    function searchProveedorM() {
        var query = searchEmpleado.value;
        if (query.length >= 2) { // Realizar la búsqueda solo si se han ingresado al menos 2 caracteres

            sendData(
                "../users/empleados",
                {
                "query": query
                }
            )
            .then(res => res.json())
            .then(data => {           
                displayResultsProveedor(data);
            })
            .catch(error => console.error('Error al realizar la búsqueda:', error));
        }
    }

    function displayResultsProveedor(usuarios) {
        displayEmpleado.innerHTML = ''; // Limpiar los resultados anteriores

        usuarios.forEach(usuario => {
            var usuarioUl = document.createElement('ul');
            var pNombre = document.createElement('p');
            var liNombre = document.createElement('li');

            pNombre.innerHTML = `Nombre: ${usuario.nombre} ${usuario.apellido} | CI: ${usuario.ci}`;
            
            liNombre.appendChild(pNombre);

            usuarioUl.appendChild(liNombre);
            
            displayEmpleado.appendChild(usuarioUl);
        });
    }
</script>