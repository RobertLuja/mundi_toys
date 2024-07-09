<div
    class="modal fade" 
    id="staticPermisos"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticPermisosLabel"
    aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="staticFuncionalidadesLabel">Permisos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form 
                    action="{{ route("roleFuncionalidades.guardarNuevosPermisos") }}"
                    method="post" id="myForm">
                    @csrf
                    <input type="text" value="{{ $roleFuncionalidad->id }}" name="id_role_funcionalidad" hidden>
                    <table class="table" style="font-size: 12px;">
                        <thead class="table-head">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                            </tr>
                        </thead>
                        <tbody id="mytable">
                            @foreach ($nuevosPermisos as $nuevoPermiso)
                                <tr>
                                    <td>
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value="{{ $nuevoPermiso->id }}"
                                            name="id_permisos[]">
                                    </td>
                                    <td>{{$nuevoPermiso->nombre}}</td>
                                    <td>{{$nuevoPermiso->descripcion}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn__primary" form="myForm">Guardar</button>
            </div>
        </div>
    </div>
</div>