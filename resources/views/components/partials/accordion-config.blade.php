<div class="accordion__item accordion accordion-flush" id="accordionConfig">
    <div class="bg-transparent accordion-item m-2">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#flush-collapseConfig"
            aria-expanded="false"
            aria-controls="flush-collapseConfig">
            <i class="bi bi-gear-fill me-2 text-info"></i>
            Configuraciones
        </button>

        <div
            id="flush-collapseConfig"
            class="accordion-collapse collapse"
            aria-labelledby="flush-headingOne"
            data-bs-parent="#accordionConfig">
            <div
                class="btn-group-vertical m-2 ms-4"
                style="width: 90%;"
                role="group"
            >
                <a
                    href="{{ route('temas.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Temas
                </a>
                <a
                    href="{{ route('modulos.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Modulos
                </a>
                <a
                    href="{{ route('funcionalidades.index') }}"
                    type="button"
                    class="sidenav__btn__subitem"
                    >Funcionalidades
                </a>
            </div>
        </div>
    </div>
</div>