<div id="containerEfectivo" style="display: none;">
    <form
        action="{{ route("ventas.pagoEfectivo", $venta->id)}}"
        method="post"
        onclick="return confirm('¿Confirmar pago?')">
        @csrf
        <h5 class="fw-bold fs-6">Pago en efectivo</h5>
        <button
            type="submit"
            class="btn__primary mt-2"
            style="font-size: 14px;"
            >Confirmar pago
        </button>
    </form>
</div>