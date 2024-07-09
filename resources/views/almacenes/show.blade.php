@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/show-data.css')}}">
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')

    <div class="p-4">
        <h2>'{{ $title }}'</h2>

        <div class="card p-2">
            <h2>Sucursal <span>'{{ $almacen->sucursal->nombre }}'</span></h2>
            <div class="card-body row row-cols-lg-2 row-cols-md-2  row-cols-1 ms-lg-1 mt-lg-2">
                <div class="form-group">
                    <label class="form-input-label" for="direccionSucursal">Dirección:</label>
                    <div 
                        class="form-input"
                        id="direccionSucursal">
                        {{ $almacen->sucursal->direccion }}
                    </div>
                </div>
            </div>
        </div>

        @include('almacenes.partials.productos')

        <hr class="mt-lg-2 mb-lg-0">

        <a 
            href="{{ route('almacenes.index') }}" 
            class="btn__primary mt-lg-4 mb-lg-4 col-lg-2 col-md-4 text-center">Volver
        </a>
    </div>
    
@endsection