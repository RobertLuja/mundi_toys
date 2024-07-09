<style>
    h1, h2, h3, h4, h5 {
        color: #333;
    }

    .title {
        color: #2d444f;
        font-weight: bold;
        font-size: 18px;
    }

    .separator {
        height: 2px; 
        background-color: #2d444f;
        margin 5px 0;
        
    }

    table {
        width: 100%;
        margin-top: 10px;
        text-align: center;
        border-collapse: collapse;
    }

    th, td {
        border-bottom: 1px solid #bec4c0;
        box-shadow: 0 0 1px #bec4c0;
        padding: 5px;
    }
</style>

<div>
    <div style="display: flex; justify-content: space-between;">
        <div>
            <h2>MundiToys SRL</h2>
            <p>Comercial Chiriguano. 3er Anillo</p>
        </div>
    </div>

    <div class="separator"></div>
    
    <div style="display: flex; justify-content: space-between;">
        <div>
            <h3><strong>Facturar a</strong></h3>
            
            <div style="display: flex;">
                <span class="title">Nombre: </span>
                <span style="margin: auto 5px;">
                    {{ $venta->cliente->nombre .' '.$venta->cliente->apellido }}
                </span>
            </div>
            <div style="display: flex;">
                <span class="title">Direccion: </span>
                <span style="margin: auto 5px;">
                    {{ $venta->cliente->direccion }}
                </span>
            </div>
        </div>
        
        <div>
            <h3></h3>
            <div style="display: flex;">
                <span class="title">Fecha: </span>
                <span style="margin: auto 5px;">
                    {{ $venta->fecha_registro }}
                </span>
            </div>
            <div style="display: flex;">
                <span class="title">Nro Pedido: </span>
                <span style="margin: auto 5px;">{{ $venta->id }}</span>
            </div>
        </div>
    </div>

    <table>
        <thead style="background-color: rgba(51, 78, 92, 0.5);">
            <tr style="color: #2d444f;">
                <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->detalleVentas as $detalleVenta)
                <tr>
                    <td>{{ $detalleVenta->producto->nombre }}</td>
                    <td>{{ $detalleVenta->cantidad }}</td>
                    <td>{{ $detalleVenta->producto->precio }}</td>
                    <td>{{ $detalleVenta->precioTotal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <h5 style="text-align: right;">Total de la Factura: Bs {{ $venta->precioTotal }}</h5>
</div>