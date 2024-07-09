@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/table.css')}}">
@endsection

@section('content')
    
    <div class="mt-4">
        
       <div class="d-flex justify-content-between mt-2">
            <h1>Permisos</h1>
        </div>

        <table class="table" style="font-size: 12px;">
            <thead class="table-head">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                </tr>
            </thead>
            <tbody id="mytable">
                @foreach ($permisos as $permiso)
                    <tr>
                        <td>{{$permiso->nombre}}</td>
                        <td>{{$permiso->descripcion}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection