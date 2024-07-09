@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')
    
    <div class="mt-4">
        @can('create')
            <a href="{{ route('traspasos.create') }}" class="btn__primary">Nuevo traspaso</a>
        @endcan
        <div class="d-flex justify-content-between mt-lg-4 me-lg-4 mt-2 me-2">
            <h1>Traspasos</h1>

            <div class="col-lg-4 col-md-6 col-8 mt-lg-2 ms-2">
                <input type="text" id="search" class="form-control" placeholder="Buscar por glosa">
                <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
            </div>
        </div>

        <table class="table table-hover" style="font-size: 12px;">
            <thead class="table-head">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Glosa</th>
                    <th scope="col">Almacen Origen</th>
                    <th scope="col">Almacen Destino</th>
                    <th scope="col">Fecha de traspaso</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody id="mytable">
                @foreach ($traspasos as $traspaso)
                    <tr>
                        <td>{{ $traspaso->id }}</td>
                        <td>{{ $traspaso->glosa }}</td>
                        <td>{{ $traspaso->almacenOrigen->nombre }}</td>
                        <td>{{ $traspaso->almacenDestino->nombre }}</td>
                        <td>{{ $traspaso->fecha }}</td>
                        <td>{{ $traspaso->estado == 1 ? "Activo" : "Inactivo"}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mb-3 me-3 d-flex justify-content-end">
            {{ $traspasos->links() }}
        </div>
    </div>
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
                "traspasos/buscar",
                {
                "query": query
                }
            )
            .then(res => res.json())
            .then(data => {
                    // console.log(data); return;
                    var startIndex = (currentPage - 1) * resultsPerPage;
                    var endIndex = startIndex + resultsPerPage;
                    var currentPageResults = data.slice(startIndex, endIndex);
                    displayResults(currentPageResults);
            })
            .catch(error => console.error('Error al realizar la búsqueda:', error));
        }
    }

    function displayResults(traspasos) {
        var mytable = document.getElementById('mytable');
        mytable.innerHTML = ''; // Limpiar los resultados anteriores

        traspasos.forEach(traspaso => {
            var row = document.createElement('tr');
            row.innerHTML = `
                <td>${traspaso.id}</td>
                <td>${traspaso.glosa}</td>
                <td>${traspaso.almacen_origen.nombre}</td>
                <td>${traspaso.almacen_destino.nombre}</td>
                <td>${traspaso.fecha}</td>
                <td>${traspaso.estado == 1 ? 'Activo' : 'Inactivo'}</td>
            `;
            mytable.appendChild(row);
        });
    }
</script>
@endsection