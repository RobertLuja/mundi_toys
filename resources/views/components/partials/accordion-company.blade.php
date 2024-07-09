<div class="accordion__item accordion accordion-flush" id="accordionCompany">
    <div class="bg-transparent accordion-item m-2">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#flush-collapseCompany"
            aria-expanded="false"
            aria-controls="flush-collapseCompany">
            <i class="bi bi-building-fill me-2 text-primary"></i>
            Mi empresa
        </button>

        <div
            id="flush-collapseCompany"
            class="accordion-collapse collapse"
            aria-labelledby="flush-headingOne"
            data-bs-parent="#accordionCompany">
            <div
                class="btn-group-vertical m-2 ms-4"
                style="width: 90%;"
                role="group"
            >
                <a 
                    href="{{ route('sucursals.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Sucursales
                </a>
                <a 
                    href="{{ route('almacenes.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Almacenes
                </a>
                <a 
                    href="{{ route('categorias.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Categorías
                </a>
                <a 
                    href="{{ route('productos.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Productos
                </a>
            </div>
        </div>
    </div>
</div>