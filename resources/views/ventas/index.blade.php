@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')
    
    <div class="mt-4">
        
        @can('create')
            <a href="{{ route('ventas.create') }}" class="btn__primary">Realizar venta</a>
        @endcan

        <div class="d-flex justify-content-between mt-lg-4 me-lg-4 mt-2 me-2">
            <h1>Detalle Ventas</h1>

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
                    <th scope="col">Cliente</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="mytable">
                @foreach ($ventas as $venta)
                    <tr>
                        <td scope="row" class="fw-normal">{{$venta->id}}</td>
                        <td>{{$venta->glosa}}</td>
                        <td>{{$venta->cliente->nombre. ' '. $venta->cliente->apellido}}</td>
                        <td>{{$venta->usuario->nombre. ' '. $venta->usuario->apellido}}</td>
                        <td>
                            @if ($venta->estado == 0)
                                <span 
                                    class="bg-warning text-dark p-1 rounded-pill"
                                    >
                                    Pendiente
                                </span>
                            @elseif ($venta->estado == 1)
                                <span 
                                    class="bg-success text-light p-1 rounded-pill"
                                    >
                                    Procesado
                                </span>
                            @else
                                <span 
                                    class="bg-danger text-light p-1 rounded-pill"
                                    >
                                    Anulado
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-block d-lg-inline-flex justify-content-lg-between">
                                
                                @can('view')
                                    <div class="me-lg-2 mb-2 d-flex d-lg-block">
                                        <a 
                                            href="{{ route('ventas.show', $venta->id) }}" class="btn__option_show">Ver detalles
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
            {{ $ventas->links() }}
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
                "ventas/buscar",
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

    function displayResults(ventas) {
        var mytable = document.getElementById('mytable');
        mytable.innerHTML = ''; // Limpiar los resultados anteriores

        ventas.forEach(venta => {
            var row = document.createElement('tr');
            let estadoText;
            let estadoClass;
            if( venta.estado == 0 ){
                estadoText = "Pendiente";
                estadoClass = "bg-warning text-dark";
            }else if ( venta.estado == 1 ){
                estadoText = "Procesado";
                estadoClass = "bg-success text-light";
            }else {
                estadoText = "Anulado";
                estadoClass = "bg-danger text-light";
            }
            row.innerHTML = `
                <td>${venta.id}</td>
                <td>${venta.glosa}</td>
                <td>
                    <span 
                        class="${estadoClass} p-1 rounded-pill"
                        >
                        ${ estadoText }
                    </span>
                </td>
                <td>
                    <div class="d-block d-lg-inline-flex justify-content-lg-between">

                        <div class="me-lg-2 mb-2 d-flex d-lg-block">
                            <a 
                                href="{{ route('ventas.show', '__venta_id__') }}" class="btn__option_show">Ver más
                            </a>
                        </div>
                    </div>
                </td>
            `;
            row.innerHTML = row.innerHTML.replace(/__venta_id__/g, venta.id);
            mytable.appendChild(row);
        });
    }
</script>
@endsection