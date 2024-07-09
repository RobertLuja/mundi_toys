<div class="accordion__item accordion accordion-flush" id="accordionTransaction">
    <div class="bg-transparent accordion-item m-2">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#flush-collapseTransaction"
            aria-expanded="false"
            aria-controls="flush-collapseTransaction">
            <i class="bi bi-bank2 me-2 text-success"></i>
            Transacciones
        </button>

        <div
            id="flush-collapseTransaction"
            class="accordion-collapse collapse"
            aria-labelledby="flush-headingOne"
            data-bs-parent="#accordionTransaction">
            <div
                class="btn-group-vertical m-2 ms-4"
                style="width: 90%;"
                role="group"
            >
                <a
                    href="{{ route('compras.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Compras
                </a>
                <a
                    href="{{ route('movimientos.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Bitacora
                </a>
                <a
                    href="{{ route('traspasos.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Traspaso
                </a>
                <a
                    href="{{ route('ventas.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Ventas
                </a>
            </div>
        </div>
    </div>
</div>