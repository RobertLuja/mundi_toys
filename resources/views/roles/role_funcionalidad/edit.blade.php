@extends('layout')

@section('content')
    
    <div class="p-lg-4">
        <h2>Editar permiso</h2>
        <form 
            action="{{route('roleFuncionalidades.update', $roleFuncionalidad)}}"
            method="POST" 
            class="row"
        >
            @csrf
            @method("PUT")
            
            <div class="mt-4">
                <h4>Permisos</h4>
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
                                    <input 
                                        class="form-check-input"
                                        type="checkbox"
                                        value="{{ $permiso->id }}"
                                        name="id_permisos[]"
                                        {{ $permiso->pivot->estado == 1 ? 'checked' : "" }}>
                                </td>
                                <td>{{$permiso->nombre}}</td>
                                <td>{{$permiso->descripcion}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>

            <span class=""></span>
            <button type="submit" class="btn__primary ms-3 col-lg-2 col-10">Actualizar</button>
        </form>
    </div>

@endsection