<div class="d-flex justify-content-between mt-lg-4 me-lg-4 mt-2 me-2">
    <h3>Productos</h3>
</div>

<table class="table table-bordered" style="font-size: 12px;">
    <thead class="table-head">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Precio</th>
            <th scope="col">Stock</th>
            <th scope="col">Estado Activo</th>
        </tr>
    </thead>
    <tbody id="mytable">
        @foreach ($productos as $producto)
            <tr>
                <td>{{$producto->nombre}}</td>
                <td>{{$producto->precio}}</td>
                <td>{{$producto->stock}}</td>
                <td>{{$producto->estado == 1 ? "Activo" : "Inactivo"}}</td>
            </tr>
        @endforeach
    </tbody>
</table>