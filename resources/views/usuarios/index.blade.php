@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')
    
    <div class="mt-4">
        
        @can('create')
            <a href="{{ route('users.create') }}" class="btn__primary">Nuevo Usuario</a>
        @endcan

        <div class="d-flex justify-content-between mt-lg-4 me-lg-4 mt-2 me-2">
            <h1>Usuarios</h1>

            <div class="col-lg-4 col-md-6 col-8 mt-lg-2 ms-2">
                <input type="text" id="search" class="form-control" placeholder="Buscar por nombres o apellidos">
                <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
            </div>
        </div>

        <table class="table" style="font-size: 12px;">
            <thead class="table-head">
                <tr>
                    <th scope="col">NIT</th>
                    <th scope="col">CI</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Email</th>
                    <th scope="col">Genero</th>
                    <th scope="col">Role</th>
                    <th scope="col">Estado Activo</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="mytable">
                @foreach ($users as $user)
                    <tr>
                        <td scope="row" class="fw-normal">{{$user->nit}}</td>
                        <td>{{$user->ci}}</td>
                        <td>{{$user->nombre}}</td>
                        <td>{{$user->apellido}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->genero == 'M' ? "Masculino" : "Femenino"}}</td>
                        <td>
                            <ul>
                                @foreach ($user->roles as $role)
                                    <li>{{ $role->nombre }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{$user->estado == 1 ? "Activo" : "Inactivo"}}</td>
                        <td>
                            <div class="d-block d-lg-inline-flex justify-content-lg-between">
                                @can ('view')
                                    <div class="me-lg-2 mb-2 d-flex d-lg-block">
                                        <a 
                                            href="{{ route('users.show', $user->id) }}" class="btn__option_show">Ver más
                                        </a>
                                    </div>
                                @endcan

                                @can('update')
                                    <div class="me-lg-2 mb-2  d-flex d-lg-block">
                                        <a 
                                            href="{{ route('users.edit', $user->id) }}" class="btn__option_edit">Editar
                                        </a>
                                    </div>
                                @endcan

                                @can('delete')
                                    <form 
                                        action="{{ route('users.destroy', $user->id) }}" 
                                        method="post"
                                        onclick="return confirm('¿Estás seguro de eliminar este usuario?')"
                                        class="d-flex d-lg-block">
                                        @csrf
                                        @method("delete")
                                        <button type="submit" class="btn__option_delete">Eliminar</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mb-3 me-3 d-flex justify-content-end">
            {{ $users->links() }}
        </div>
    </div>
    
    @if (session("info"))
        <x-alert
            icon="bi bi-check-circle-fill"
            color="#4caf50"
            message="{{session('info')}}"
        />
    @endif
@endsection

@section('js')
<script>
    var typingTimer;
    var doneTypingInterval = 100;
    var searchInput = document.getElementById('search');
    var mytable = document.getElementById('mytable');

    var currentPage = 1; // Página actual para la búsqueda
    var resultsPerPage = 10; // Cantidad de resultados por página

    searchInput.addEventListener('keyup', function() {
        clearTimeout(typingTimer);
        if (searchInput.value) {
            typingTimer = setTimeout(search, doneTypingInterval);
        };
    });

    function search() {
        var query = searchInput.value;
        if (query.length >= 2) { // Realizar la búsqueda solo si se han ingresado al menos 2 caracteres

            sendData(
                "users/buscar",
                {
                "query": query
                }
            )
            .then(res => res.json())
            .then(data => {
                    var startIndex = (currentPage - 1) * resultsPerPage;
                    var endIndex = startIndex + resultsPerPage;
                    var currentPageResults = data.slice(startIndex, endIndex);
                    displayResults(currentPageResults);
            })
            .catch(error => console.error('Error al realizar la búsqueda:', error));
        }
    }

    function displayResults(users) {
        var mytable = document.getElementById('mytable');
        mytable.innerHTML = ''; // Limpiar los resultados anteriores

        users.forEach(user => {
            var row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.nit}</td>
                <td>${user.ci}</td>
                <td>${user.nombre}</td>
                <td>${user.apellido}</td>
                <td>${user.email}</td>
                <td>${user.genero == 'M' ? 'Masculino' : 'Femenino'}</td>
                <td>${user.rol}</td>
                <td>${user.estado == 1 ? 'Activo' : 'Inactivo'}</td>
                <td>
                    <div class="d-block d-lg-inline-flex justify-content-lg-between">
                        <div class="me-lg-2 mb-2 d-flex d-lg-block">
                            <a 
                                href="{{ route('users.show', '__user_id__') }}" class="btn__option_show">Ver más
                            </a>
                        </div>

                        <div class="me-lg-2 mb-2  d-flex d-lg-block">
                            <a 
                                href="{{ route('users.edit', '__user_id__') }}" class="btn__option_edit">Editar
                            </a>
                        </div>

                        <form 
                            action="{{ route('users.destroy', '__user_id__') }}" 
                            method="post"
                            onclick="return confirm('¿Estás seguro de eliminar este usuario?')"
                            class="d-flex d-lg-block">
                            @csrf
                            @method("delete")
                            <button type="submit" class="btn__option_delete">Eliminar</button>
                        </form>
                    </div>
                </td>
            `;
            row.innerHTML = row.innerHTML.replace(/__user_id__/g, user.id);
            mytable.appendChild(row);
        });
    }
</script>
@endsection