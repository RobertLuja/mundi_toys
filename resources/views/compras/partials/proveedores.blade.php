<div class="">
    <div>
        <label for="search" class="fs-5">Proveedor</label>
        <input 
            class="form-control @error('ci') is-invalid 
            @enderror" 
            type="number"
            id="searchProveedor"
            name="ci"
            placeholder="Buscar ci"
        >
        @error('ci')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
    </div>
    <div class="mt-2" id="displayProveedor"></div>
</div>

<script>
    var searchProveedor = document.getElementById('searchProveedor');

    searchProveedor.addEventListener('keyup', function() {
        if (searchProveedor.value) {
            searchProveedorM();
        };
    });

    function searchProveedorM() {
        var query = searchProveedor.value;
        if (query.length >= 2) { // Realizar la búsqueda solo si se han ingresado al menos 2 caracteres

            sendData(
                "../users/proveedores",
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
        displayProveedor.innerHTML = ''; // Limpiar los resultados anteriores

        usuarios.forEach(usuario => {
            var usuarioUl = document.createElement('ul');
            var pNombre = document.createElement('p');
            var liNombre = document.createElement('li');

            pNombre.innerHTML = `Nombre: ${usuario.nombre} ${usuario.apellido} | CI: ${usuario.ci}`;
            
            liNombre.appendChild(pNombre);

            usuarioUl.appendChild(liNombre);
            
            displayProveedor.appendChild(usuarioUl);
        });
    }
</script>