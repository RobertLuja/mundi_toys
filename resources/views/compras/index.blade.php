@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')
    
    <div class="mt-4">
        
        @can('create')
            <a href="{{ route('compras.create') }}" class="btn__primary">Realizar compra</a>
        @endcan

        <div class="d-flex justify-content-between mt-lg-4 me-lg-4 mt-2 me-2">
            <h1>Detalle Compras</h1>

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
                    <th scope="col">Estado Activo</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="mytable">
                @foreach ($compras as $compra)
                    <tr>
                        <td scope="row" class="fw-normal">{{$compra->id}}</td>
                        <td>{{$compra->glosa}}</td>
                        <td>{{$compra->estado == 1 ? "Activo" : "Inactivo"}}</td>
                        <td>
                            <div class="d-block d-lg-inline-flex justify-content-lg-between">
                                
                                @can('view')
                                    <div class="me-lg-2 mb-2 d-flex d-lg-block">
                                        <a 
                                            href="{{ route('compras.show', $compra->id) }}" class="btn__option_show">Ver detalles
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mb-3 me-3 d-flex justify-content-end">
            {{ $compras->links() }}
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
    var resultsPerPage = 5; // Cantidad de resultados por página

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
                "compras/buscar",
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

    function displayResults(compras) {
        var mytable = document.getElementById('mytable');
        mytable.innerHTML = ''; // Limpiar los resultados anteriores

        compras.forEach(compra => {
            var row = document.createElement('tr');
            row.innerHTML = `
                <td>${compra.id}</td>
                <td>${compra.glosa}</td>
                <td>${compra.estado == 1 ? 'Activo' : 'Inactivo'}</td>
                <td>
                    <div class="d-block d-lg-inline-flex justify-content-lg-between">

                        <div class="me-lg-2 mb-2 d-flex d-lg-block">
                            <a 
                                href="{{ route('compras.show', '__compra_id__') }}" class="btn__option_show">Ver más
                            </a>
                        </div>
                    </div>
                </td>
            `;
            row.innerHTML = row.innerHTML.replace(/__compra_id__/g, compra.id);
            mytable.appendChild(row);
        });
    }
</script>
@endsection