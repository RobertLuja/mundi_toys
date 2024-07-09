<div id="containerPagoFacil" style="display: none;">
    <h5 class="fw-bold fs-6">Pago por QR</h5>
    <div
        class="text-center d-flex flex-column justify-content-center"
        style="border: 2px solid var(--primary-color); border-radius: 10px;">
        <span id="qrImgPagoFacilLoad"></span>
        <img src="" alt="no-image" srcset="" id="qrImgPagoFacilLoaded">
        <input 
            type="text"
            id="urlImageQR"
            value="{{ $venta->pagoFacil != null ? $venta->pagoFacil->url_qr : '-1' }}"
            hidden="true"
        >
        {{-- Generando QR... --}}
        {{-- <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label> --}}
    </div>
    <div class="d-flex justify-content-between">
        <button
            id="btnGenerarQr"
            class="btn__secondary mt-2"
            style="font-size: 12px;"
            >Generar QR
        </button>
        <button
            id="btnVerificarPago"
            class="btn__primary mt-2"
            style="font-size: 12px; display: none;"
            >Verificar pago
        </button>
    </div>

    <div class="mt-2">
        <div style="font-size: 12px;">
            <strong>Expiración QR:</strong>
            <div>
                <span id="displayHora" class="fs-5">0</span>
                <strong class="fs-5">:</strong>
                <span id="displayMinuto" class="fs-5">0</span>
                <strong class="fs-5">:</strong>
                <span id="displaySegundo" class="fs-5">0</span>
            </div>
            <input 
                type="text"
                id="ventaExpiracion"
                value="{{ $venta->pagoFacil != null ? $venta->pagoFacil->expiracion : '-1' }}"
                hidden="true"
            >
        </div>
        
        <span
            style="font-size: 12px; cursor: default;"
            data-toggle="tooltip"
            data-placement="top"
            title="Cumplida cantidad de QR generado, se procedera a anular la factura.">
            <strong>QR Generado:</strong>
            <span id="cantidadTransaccion">{{ $venta->cantidadTransaccion }} veces</span>
        </span>
    </div>
</div>

<script>
    const idVenta = document.getElementById("idVenta");
    const btnGenerarQr = document.getElementById("btnGenerarQr");
    const btnVerificarPago = document.getElementById("btnVerificarPago");
    const ventaExpiracion = document.getElementById("ventaExpiracion");

    const qrImgPagoFacilLoad = document.getElementById("qrImgPagoFacilLoad"); //Esperando respuesta
    const qrImgPagoFacilLoaded = document.getElementById("qrImgPagoFacilLoaded"); //Imagen cargada

    if(document.getElementById("urlImageQR").value != -1){
        qrImgPagoFacilLoaded.src = document.getElementById("urlImageQR").value;
        btnVerificarPago.style.display = "block";
    }

    btnGenerarQr.addEventListener("click", function() {
        const valueIdVenta = parseInt(idVenta.textContent);
        
        qrImgPagoFacilLoad.textContent = "Generando QR...";
        sendData(
            "/pagofacil/generarQR",
            {
                "id_venta": valueIdVenta
            }
        )
        .then(res => res.json())
        .then(result => {
            document.getElementById("containerAlert").innerHTML = "";
            if(result.status == 400){
                document.getElementById("containerAlert").innerHTML = showAlertError(result.message);
                qrImgPagoFacilLoad.textContent = "";
            }else if(result.status == 201){
                qrImgPagoFacilLoad.textContent = "";
                qrImgPagoFacilLoaded.src = result.data.url_qr;

                ventaExpiracion.value = result.data.expiracion;
                document.getElementById("cantidadTransaccion").textContent = `${result.data.cantidadTransaccion} veces`;
                btnVerificarPago.style.display = "block";
                actualizarTimeout();
            }

        })
        .catch(error => 
            {
                console.error('Error al realizar la búsqueda:', error)
                qrImgPagoFacilLoad.textContent = "Error del servidor";
            }
        );
    });

    btnVerificarPago.addEventListener("click", function() {
        const valueIdVenta = parseInt(idVenta.textContent);
        sendData(
            "/pagofacil/consultarEstado",
            {
                "id_venta": valueIdVenta
            }
        )
        .then(res => res.json())
        .then(result => {
            document.getElementById("containerAlert").innerHTML = "";
            if(result.status == 400){
                console.log(result);
            }else if(result.status == 200){
                document.getElementById("containerAlert").innerHTML = showAlertError(result.data.values.messageEstado);
            }

        })
        .catch(error => 
            {
                console.error('Error al realizar la búsqueda:', error)
                qrImgPagoFacilLoad.textContent = "Error del servidor";
            }
        );
    });

    function actualizarTimeout() {

        const idIntervalo = setInterval(() => {
            if(ventaExpiracion.value == -1){
                clearInterval(idIntervalo);
                //console.log("Sin transaccion");
                return;
            }
            const dateFormatter = ventaExpiracion.value.trim().replace(" ", "T");
            let fechaLimite = new Date(dateFormatter);
            let fechaActual = new Date();

            if(fechaActual >= fechaLimite){
                console.log("Tiempo finalizado");
                qrImgPagoFacilLoaded.src = "";
                qrImgPagoFacilLoad.textContent = "QR Expirado";
                btnVerificarPago.style.display = "none";
                clearInterval(idIntervalo); //Finalizar el intervalo
            }else{
                // Calcular la diferencia de tiempo en milisegundos
                let diferenciaTiempo = fechaLimite - fechaActual;

                let horasRestantes = Math.floor((diferenciaTiempo % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutosRestantes = Math.floor((diferenciaTiempo % (1000 * 60 * 60)) / (1000 * 60));
                let segundosRestantes = Math.floor((diferenciaTiempo % (1000 * 60)) / 1000);
                
                document.getElementById("displayHora").textContent = horasRestantes;
                document.getElementById("displayMinuto").textContent = minutosRestantes;
                document.getElementById("displaySegundo").textContent = segundosRestantes;
            }
        }, 1000);
    }
    actualizarTimeout();
    
</script>