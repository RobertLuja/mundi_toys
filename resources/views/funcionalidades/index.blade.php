@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')
    
    <div class="mt-4">
        
       <div class="d-flex justify-content-between mt-2">
            <h1>Funcionalidades</h1>
        </div>

        <table class="table" style="font-size: 12px;">
            <thead class="table-head">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Ruta</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="mytable">
                @foreach ($funcionalidades as $funcionalidad)
                    <tr>
                        <td>{{$funcionalidad->nombre}}</td>
                        <td>{{$funcionalidad->descripcion}}</td>
                        <td>/{{$funcionalidad->ruta}}</td>
                        <td>{{$funcionalidad->estado == 1 ? "Activo": "Inactivo"}}</td>
                        <td>
                            <div class="d-block d-lg-inline-flex justify-content-lg-between">

                                @can('update')
                                    <div class="me-lg-2 mb-2  d-flex d-lg-block">
                                        <a 
                                            href="{{ route('funcionalidades.edit', $funcionalidad->id) }}" class="btn__option_edit">Editar
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if (session("info"))
        <x-alert
            icon="bi bi-check-circle-fill"
            color="#4caf50"
            message="{{session('info')}}"
        />
    @endif
@endsection