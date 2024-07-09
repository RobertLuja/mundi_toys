@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/show-data.css')}}">
@endsection

@section('content')

    <div class="p-4">
        <h2>{{ $title }}</h2>
        <div class="card">
            <div class="card-body">

                <div class="row row-cols-lg-4 row-cols-md-2  row-cols-1">
                    <div class="form-group">
                        <label class="form-input-label" for="nombre">Nombre:</label>
                        <div class="form-input">{{ $producto->nombre }}</div>
                    </div>
    
                    <div class="form-group">
                        <label class="form-input-label" for="descripcion">Precio:</label>
                        <div class="form-input">{{ $producto->precio }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-input-label" for="estado">Estado activo:</label>
                        <div class="form-input">{{ $producto->estado == 1 ? "Activo" : "Inactivo" }}</div>
                    </div>
    
                </div>

                <span class="mt-4"></span>
                {{-- New Row --}}
                
                <div class="row row-cols-lg-3 row-cols-md-2  row-cols-1 ms-lg-1 mt-lg-2">
                    <div class="card p-2">
                        <h2>Categoría</h2>
                        <div class="card-body">
                            <div class="form-group col-12">
                                <label class="form-input-label" for="nombreCategoria">Nombre:</label>
                                <div 
                                    class="form-input"
                                    id="nombreCategoria">
                                    {{ $producto->categoria->nombre }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mt-lg-2 mb-lg-0">

                <a 
                    href="{{ route('productos.index') }}" 
                    class="btn__primary m-lg-4 col-lg-2 col-md-4 text-center">Volver
                </a>
            </div>
        </div>
    </div>
    
@endsection