@extends('layout')

@section('content')
    <h1>Bienvenido a temas</h1>
    <p>Aquí podras escoger temas</p>

    <div>
        <button type="button" id="btnDefaultTheme" class="btn__primary">Tema default</button>
        <button type="button" id="btnChildTheme" class="btn__primary">Tema niño</button>
        <button type="button" id="btnOldTheme" class="btn__primary">Tema adulto</button>
        <button type="button" id="btnDark" class="btn__primary">Tema oscuro</button>
    </div>
@endsection