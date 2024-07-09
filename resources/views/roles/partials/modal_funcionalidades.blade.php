<div
    class="modal fade" 
    id="staticFuncionalidades"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticFuncionalidadesLabel"
    aria-hidden="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="staticFuncionalidadesLabel">Funcionalidades</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route("roles.guardarNuevasFuncionalidades") }}" method="post" id="myform">
                    @csrf
                    <input type="text" value="{{ $role->id }}" name="id_role" hidden>
                    <table class="table" style="font-size: 12px;">
                        <thead class="table-head">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Ruta</th>
                            </tr>
                        </thead>
                        <tbody id="mytable">
                            @foreach ($nuevasFuncionalidades as $nuevaFuncionalidad)
                                <tr>
                                    <td>
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value="{{ $nuevaFuncionalidad->id }}"
                                            name="id_funcionalidades[]">
                                    </td>
                                    <td>{{$nuevaFuncionalidad->nombre}}</td>
                                    <td>{{$nuevaFuncionalidad->descripcion}}</td>
                                    <td>/{{$nuevaFuncionalidad->ruta}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn__primary" form="myform">Guardar</button>
            </div>
        </div>
    </div>
</div>