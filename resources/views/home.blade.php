@extends('layout')

@section('content')
    <h1>Bienvenido a la plataforma de <strong>MundiToys</strong></h1>

    <div style="width: 400px; height: 400px;">
        {{-- <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label> --}}
        <canvas id="myChartDoughnut"></canvas>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        
        sendData(
            '/categorias/cantidadProductos',
            {
                data: "true"
            }
        )
        .then( response => response.json() )
        .then( result => {
            if(result.status == 200){
                const categorias = result.data;
                displayChart(categorias);
            }
        })
        .catch( error => {
            console.log("Error en realizar la consulta", error);
        });


        function displayChart(categorias) {
            const myChartDoughnut = document.getElementById('myChartDoughnut');
            let delayed;

            const nombres = categorias.map(categoria => categoria.nombre);
            const cantidades = categorias.map(categoria => categoria.cantidad);

            const data = {
                labels: nombres,
                datasets: [
                    {
                        label: '% Vendidos: ',
                        data: cantidades,
                        //backgroundColor: Object.values(["#fc2403", "#fc5603", "#fca503", "#21802c", "#1952b5"])
                    }
                ]
            };

            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Categoría de productos'
                        }
                    },
                    animation: {
                        onComplete: () => {
                            delayed = true;
                        },
                        delay: (context) => {
                            let delay = 0;
                            if (context.type === 'data' && context.mode === 'default' && !delayed) {
                                delay = context.dataIndex * 300 + context.datasetIndex * 100;
                            }
                            return delay;
                        },
                    },
                },
            };

            new Chart(myChartDoughnut, config);
        }
    </script>
@endsection