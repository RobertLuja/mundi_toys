@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')
    
    <div class="mt-4">
        
        @can('create')
            <a href="{{ route('roles.create') }}" class="btn__primary">Nuevo Rol</a>
        @endcan

        <div class="d-flex justify-content-between mt-2">
            <h1>Roles</h1>
        </div>

        <table class="table" style="font-size: 12px;">
            <thead class="table-head">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="mytable">
                @foreach ($roles as $role)
                    <tr>
                        <td scope="row" class="fw-normal">{{$role->id}}</td>
                        <td>{{$role->nombre}}</td>
                        <td>{{$role->descripcion == null ? "Sin descripción": $role->descripcion}}</td>
                        <td>
                            <div class="d-block d-lg-inline-flex justify-content-lg-between">

                                @can('view')
                                    <div class="me-lg-2 mb-2 d-flex d-lg-block">
                                        <a 
                                            href="{{ route('roles.show', $role->id) }}" class="btn__option_show">Ver más
                                        </a>
                                    </div>
                                @endcan

                                @can('update')
                                    <div class="me-lg-2 mb-2  d-flex d-lg-block">
                                        <a 
                                            href="{{ route('roles.edit', $role->id) }}" class="btn__option_edit">Editar
                                        </a>
                                    </div>
                                @endcan

                                @can('delete')
                                    <form 
                                        action="{{ route('roles.destroy', $role->id) }}" 
                                        method="post"
                                        onclick="return confirm('¿Estás seguro de eliminar este rol?')"
                                        class="d-flex d-lg-block"
                                    >
                                        @csrf
                                        @method("delete")
                                        <button type="submit" class="btn__option_delete">Eliminar</button>
                                    </form>
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