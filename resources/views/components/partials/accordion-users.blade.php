<div class="accordion__item accordion accordion-flush" id="accordionUsers">
    <div class="bg-transparent accordion-item m-2">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#flush-collapseUser"
            aria-expanded="false"
            aria-controls="flush-collapseUser">
            <i class="bi bi-person-fill me-2 text-primary"></i>
            Usuarios
        </button>

        <div
            id="flush-collapseUser"
            class="accordion-collapse collapse"
            aria-labelledby="flush-headingOne"
            data-bs-parent="#accordionUsers">
            <div
                class="btn-group-vertical m-2 ms-4"
                style="width: 90%;"
                role="group"
            >
                <a href="{{ route('users.index') }}" type="button" class="sidenav__btn__subitem">Usuarios</a>

                {{-- <a href="{{ route("clientes.index") }}" type="button" class="sidenav__btn__subitem">Clientes</a> --}}

                <a href="{{ route('roles.index') }}" type="button" class="sidenav__btn__subitem">Roles</a>
            </div>
        </div>
    </div>
</div>