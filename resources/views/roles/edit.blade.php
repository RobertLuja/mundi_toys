@extends('layout')

@section('content')
    
    <div class="p-lg-4">
        <h2>Editar role</h2>
        <form 
            action="{{route('roles.update', $role)}}"
            method="POST" 
            class="row"
        >
            @csrf
            @method("PUT")
            <div class="row row-cols-1">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ $role->nombre }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <span class="mt-4"></span>

                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea 
                        class="form-control 
                        @error('descripcion') is-invalid 
                        @enderror" 
                        id="descripcion" 
                        name="descripcion"
                    >{{ $role->descripcion }}
                    </textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <h4>Funcionalidades</h4>
                <table class="table" style="font-size: 12px;">
                    <thead class="table-head">
                        <tr>
                            <th scope="col">Estado</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Ruta</th>
                        </tr>
                    </thead>
                    <tbody id="mytable">
                        @foreach ($role->roleFuncionalidades as $roleFuncionalidad)
                            <tr>
                                <td>
                                    <input 
                                        class="form-check-input"
                                        type="checkbox"
                                        value="{{ $roleFuncionalidad->id }}"
                                        name="id_funcionalidades[]"
                                        {{ $roleFuncionalidad->estado == 1 ? 'checked' : "" }}>
                                </td>
                                <td>{{$roleFuncionalidad->funcionalidad->nombre}}</td>
                                <td>{{$roleFuncionalidad->funcionalidad->descripcion}}</td>
                                <td>/{{$roleFuncionalidad->funcionalidad->ruta}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <span class="mt-4"></span>
            <hr>

            <span class=""></span>
            <button type="submit" class="btn__primary ms-3 col-lg-2 col-10">Actualizar</button>
        </form>
    </div>

@endsection

@section('js')
    <script>
        var textarea = document.getElementById('descripcion');
        textarea.textContent = textarea.textContent.trim();
    </script>
@endsection