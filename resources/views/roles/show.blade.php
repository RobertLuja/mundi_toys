@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/show-data.css')}}">
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')

    <div class="p-4">
        <div class="d-flex">
            <a 
                href="{{ route('roles.index') }}" 
                class="btn__primary mb-auto me-2">Volver
            </a>
            <h2>Role</h2>
        </div>
        <div class="card">
            <div class="card-body">

                <div class="row row-cols-lg-2 row-cols-md-2  row-cols-1">
                    <div class="form-group">
                        <label class="form-input-label" for="ci">Nombre:</label>
                        <div class="form-input">{{ $role->nombre }}</div>
                    </div>
    
                    <div class="form-group">
                        <label class="form-input-label" for="ci">Descripción:</label>
                        <div class="form-input">{{ $role->descripcion }}</div>
                    </div>
                </div>

                <span class="mt-4"></span>
                {{-- New Row --}}
                
                <div class="mt-4">

                    {{-- Agregar nueva funcionalidad a este rol Role-Funcionalidad--}}
                    <div class="m-2 d-flex">
                        <h4>Role-Funcionalidades</h4>
                        @can('create')
                            <button
                                data-bs-toggle="modal"
                                data-bs-target="#staticFuncionalidades"
                                class="btn__secondary ms-2"
                                >Nueva funcionalidad
                            </button>
                            @include('roles.partials.modal_funcionalidades') 
                        @endcan
                    </div>

                    <table class="table" style="font-size: 12px;">
                        <thead class="table-head">
                            <tr>
                                <th scope="col">Estado</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Ruta</th>
                                <th scope="col">Permisos</th>
                            </tr>
                        </thead>
                        <tbody id="mytable">
                            @foreach ($role->roleFuncionalidades as $roleFuncionalidad)
                                <tr>
                                    <td>
                                        @if ($roleFuncionalidad->estado == 0)
                                            <span 
                                                class="bg-danger text-light p-1 rounded-pill"
                                                >
                                                Inactivo
                                            </span>
                                        @else
                                            <span 
                                                class="bg-success text-light p-1 rounded-pill"
                                                >
                                                Activo
                                            </span>
                                        @endif    
                                    </td>
                                    <td>{{$roleFuncionalidad->funcionalidad->nombre}}</td>
                                    <td>{{$roleFuncionalidad->funcionalidad->descripcion}}</td>
                                    <td>/{{$roleFuncionalidad->funcionalidad->ruta}}</td>
                                    <td>
                                        <div class="d-block d-lg-inline-flex justify-content-lg-between">

                                            @can('view')
                                                <div class="me-lg-2 mb-2 d-flex d-lg-block">
                                                    <a
                                                        href="{{ route("roleFuncionalidades.show", $roleFuncionalidad->id) }}"
                                                        class="btn__option_show">Ver
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('update')
                                                <div class="me-lg-2 mb-2  d-flex d-lg-block">
                                                    <a 
                                                        href="{{ route('roleFuncionalidades.edit', $roleFuncionalidad->id) }}" class="btn__option_edit">Editar
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
            </div>
        </div>
    </div>
    
    @if (session("success"))
        <x-alert
            icon="bi bi-check-circle-fill"
            color="#4caf50"
            message="{{session('success')}}"
        />
    @endif

    @if (session("error"))
        <x-alert
            icon="bi bi-check-circle-fill"
            color="crimson"
            message="{{session('error')}}"
        />
    @endif
@endsection