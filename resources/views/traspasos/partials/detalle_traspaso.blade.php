<div class="row row-cols-lg-2 row-cols-md-3 mt-lg-0 mt-3">
    <div>
        <strong class="fs-5">Fecha: </strong>
        <small class="fs-5 ps-1" id="date">
            <?php $date = getdate();
                    echo $date["mday"]."/".$date["month"]."/".$date["year"];
            ?>
        </small>
    </div>                                

    <div>
        <strong class="fs-5">Cantidad Total: </strong>
        <small class="fs-5 ps-1" id="cantidadTotal">0</small>
    </div>                           
</div>

<table class="table table-bordered table-hover mt-3">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th class="text-center">
                <button type="button" class="btn btn-danger" id="btnQuitAll">
                    <small class="fw-bold">X</small>
                </button>
            </th>
        </tr>
    </thead>
    <tbody id="tBodyDetalleTraspaso" name="tBodyDetalleTraspaso" style="transition: 2s;">
        
    </tbody>
</table>

<script>
    const btnQuitAll = document.getElementById("btnQuitAll");
    const tBodyDetalleTraspaso = document.getElementById("tBodyDetalleTraspaso");

    btnQuitAll.addEventListener("click", () => {
        while(tBodyDetalleTraspaso.hasChildNodes()){
            tBodyDetalleTraspaso.firstChild.remove();
        }
        document.getElementById("cantidadTotal").textContent = "0";
        detallesTraspasos  = [];
    });

    let idIncrement = 0;
    function createItemTr(detallesTraspaso) {
        let trBody = document.createElement("tr");
        trBody.id = "trBodyDetalleTraspaso" + idIncrement;

        //---------------Producto--------------------
        tdNombreProducto = document.createElement("td");
        tdNombreProducto.textContent = detallesTraspaso.producto.nombre;
        //---------------End Producto--------------------

        //---------------Cantidad--------------------
        tdCantidadUnitaria = document.createElement("td");
        tdCantidadUnitaria.appendChild(
            createSmall(
                "cantidadUnitariaAdd", 
                detallesTraspaso.cantidad, 
                "cantidadUnitariaAdd" + idIncrement
            ),
        );
        //Actualizar cantidad total
        document.getElementById("cantidadTotal").textContent =
                                parseInt(document.getElementById("cantidadTotal").textContent) + 
                                parseInt(detallesTraspaso.cantidad);
        //---------------End Cantidad--------------------

        trBody.append(
            tdNombreProducto,
            tdCantidadUnitaria, 
            createButtonQuit( idIncrement ) 
        );

        idIncrement ++;

        tBodyDetalleTraspaso.appendChild(trBody);
    }

    function createSmall(clss, textContent, id){
        let small = document.createElement("small");
        small.classList = `${clss} fs-6`;
        if(id != undefined) small.id = id;
        small.textContent = textContent;
        return small;
    }

    function createButtonQuit(id) {

        let tdQuit = document.createElement("td");

        let buttonDel = document.createElement("button");
        buttonDel.type = "button";
        buttonDel.classList = "btn btn-warning";

        let smallIcon = document.createElement("small");
        smallIcon.classList = "fw-bold";
        smallIcon.textContent = "Quitar";

        buttonDel.appendChild(smallIcon);

        buttonDel.addEventListener("click", () => {

            document.getElementById("cantidadTotal").textContent = 
                        parseInt(document.getElementById("cantidadTotal").textContent) - parseInt(document.getElementById("cantidadUnitariaAdd" + id).textContent);

            tBodyDetalleTraspaso.removeChild( 
                        document.getElementById("trBodyDetalleTraspaso" + id)
                    );

            detallesTraspasos = detallesTraspasos
                                .filter(detalleCompra => detalleCompra.id != id)
            
        });

        tdQuit.classList = "text-center";

        tdQuit.appendChild(buttonDel);

        return tdQuit;
    }
</script>