@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')

    <div class="p-4">
        <h2>{{ $compra->glosa }}</h2>

        <a 
            href="{{ route('compras.index') }}" 
            class="btn__primary m-lg-4 col-lg-2 col-md-4 text-center">Volver
        </a>
        
        <table class="table table-bordered table-hover mt-3">
            <thead class="table-head">
                <tr>
                    <th>Producto</th>
                    <th>Almacen</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody style="transition: 2s;">
                @foreach ($compra->detalleCompras as $detalleCompra)
                    <tr>
                        <td>{{ $detalleCompra->movimiento->producto->nombre }}</td>
                        <td>{{ $detalleCompra->movimiento->almacen->nombre }}</td>
                        <td>{{ $detalleCompra->cantidad }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
@endsection