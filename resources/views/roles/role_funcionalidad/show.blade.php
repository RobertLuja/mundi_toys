@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/show-data.css')}}">
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')

    <div class="p-4">
        <div class="d-flex">
            <a 
                href="{{ route('roles.show', $roleFuncionalidad->role->id) }}" 
                class="btn__primary mb-auto me-2">Volver
            </a>
            <h2>Role-Funcionalidad</h2>
        </div>
        <div class="card">
            <div class="card-body">

                <h4>Funcionalidad</h4>
                <div class="row row-cols-lg-4 row-cols-md-2  row-cols-1">
                    <div class="form-group">
                        <label class="form-input-label" for="ci">Estado:</label>
                        <div class="form-input">{{ $roleFuncionalidad->estado == 1 ? 'Activo' : 'Inactivo' }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-input-label" for="ci">Nombre:</label>
                        <div class="form-input">{{ $roleFuncionalidad->funcionalidad->nombre }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-input-label" for="ci">Descripción:</label>
                        <div class="form-input">{{ $roleFuncionalidad->funcionalidad->descripcion }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-input-label" for="ci">Ruta:</label>
                        <div class="form-input">/{{ $roleFuncionalidad->funcionalidad->ruta }}</div>
                    </div>
                </div>

                <span class="mt-4"></span>
                {{-- New Row --}}
                
                <div>

                    {{-- Agregar nuevo permiso a este role-funcionalidad --}}
                    <div class="m-2 d-flex">
                        <h4>Permisos</h4>
                        <button
                            data-bs-toggle="modal"
                            data-bs-target="#staticPermisos"
                            class="btn__secondary ms-2"
                            >Nuevo Permiso
                        </button>
                        @include('roles.role_funcionalidad.partials.modal_permisos')
                    </div>

                    <table class="table" style="font-size: 12px;">
                        <thead class="table-head">
                            <tr>
                                <th scope="col">Estado</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                            </tr>
                        </thead>
                        <tbody id="mytable">
                            @foreach ($roleFuncionalidad->permisos as $permiso)
                                <tr>
                                    <td>
                                        @if ($permiso->pivot->estado == 0)
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
                                    <td>{{$permiso->nombre}}</td>
                                    <td>{{$permiso->descripcion}}</td>
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