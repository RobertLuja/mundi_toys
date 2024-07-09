@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')
    
    <div class="mt-4">

        <div class="d-flex justify-content-between mt-lg-4 me-lg-4 mt-2 me-2">
            <h1>Bitacora</h1>

            <div class="col-lg-4 col-md-6 col-8 mt-lg-2 ms-2">
                <input type="text" id="search" class="form-control" placeholder="Buscar por tipo u origen">
                <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
            </div>
        </div>

        <table class="table table-hover" style="font-size: 12px;">
            <thead class="table-head">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Registro</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Origen</th>
                    <th scope="col">Almacen</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody id="mytable">
                @foreach ($movimientos as $movimiento)
                    <tr>
                        <td>{{ $movimiento->id }}</td>
                        <td>{{ $movimiento->fecha_registro }}</td>
                        <td>{{ $movimiento->tipo }}</td>
                        <td>{{ $movimiento->origen }}</td>
                        <td>{{ $movimiento->almacen->nombre }}</td>
                        <td>{{ $movimiento->producto->nombre }}</td>
                        <td>{{ $movimiento->stock }}</td>
                        <td>
                            @if ($movimiento->estado == 0)
                                <span 
                                    class="bg-warning text-dark p-1 rounded-pill"
                                    >
                                    Inactivo
                                </span>
                            @elseif ($movimiento->estado == 1)
                                <span 
                                    class="bg-success text-light p-1 rounded-pill"
                                    >
                                    Activo
                                </span>
                            @else
                                <span 
                                    class="bg-danger text-light p-1 rounded-pill"
                                    >
                                    Anulado
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mb-3 me-3 d-flex justify-content-end">
            {{ $movimientos->links() }}
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
                "movimientos/buscar",
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

    function displayResults(movimientos) {
        var mytable = document.getElementById('mytable');
        mytable.innerHTML = ''; // Limpiar los resultados anteriores

        movimientos.forEach(movimiento => {
            var row = document.createElement('tr');

            let estadoText;
            let estadoClass;
            if( movimiento.estado == 0 ){
                estadoText = "Pendiente";
                estadoClass = "bg-warning text-dark";
            }else if ( movimiento.estado == 1 ){
                estadoText = "Procesado";
                estadoClass = "bg-success text-light";
            }else {
                estadoText = "Anulado";
                estadoClass = "bg-danger text-light";
            }
            row.innerHTML = `
                <td>${movimiento.id}</td>
                <td>${movimiento.fecha_registro}</td>
                <td>${movimiento.tipo}</td>
                <td>${movimiento.origen}</td>
                <td>${movimiento.almacen.nombre}</td>
                <td>${movimiento.producto.nombre}</td>
                <td>${movimiento.stock}</td>
                <td>
                    <span 
                        class="${estadoClass} p-1 rounded-pill"
                        >
                        ${ estadoText }
                    </span>    
                </td>
            `;
            mytable.appendChild(row);
        });
    }
</script>
@endsection