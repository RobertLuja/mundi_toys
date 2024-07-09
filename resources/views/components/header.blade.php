<header id="header" class="d-flex align-items-center justify-content-between p-3">
    <div>
        <button id="toggleButton" type="button" class="btn btn-header"></button>
        <span class="name__user">MundiToys</span>
    </div>

    <form
        class="col-lg-6 col-md-6 col-4 d-flex" style="height: 30px;" 
        action=""
        method="GET">
        <input 
            class="form-control me-2"
            id="searchFuncionalidad"
            style="height: 100%;"
            type="text"
            placeholder="Buscar funcionalidad por nombre"
        >
        <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
        <button type="submit" id="btnBuscar" class="btn__primary">Buscar</button>
    </form>

    <div class="d-flex">
        {{-- <span>{{ "Joaquin Chumacero" }}</span> --}}
        
        {{-- <button href="{{ route('login.logout') }}" id="btnLogout" type="button" class="btn btn-header"></button> --}}

        <span class="name__user m-auto">{{ App\Models\Role::find(Auth::user()->rol)->nombre }}</span>

        <div class="dropdown__profile" style="cursor: pointer;">
            <i
                class="bi bi-person-fill fs-2 me-2"
                id="dropdownProfile"
                data-bs-toggle="dropdown"
                aria-expanded="false">
            </i>

            <ul class="dropdown-menu" aria-labelledby="dropdownProfile">
                <li class="d-flex justify-content-start p-1">
                    <a 
                        class="dropdown__item ps-2 pe-2 pt-1 pb-1" 
                        href="{{ route('login.profile') }}">Mis datos
                    </a>
                </li>

                <li class="d-flex justify-content-start p-1">
                    <form 
                        action="{{ route("login.logout") }}"
                        method="POST"
                        class="d-flex w-100"
                    >
                        @csrf
                        <button 
                            type="submit"
                            class="dropdown__item ps-2 pe-2 pt-1 pb-1 d-flex justify-content-start"
                            >Salir
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        {{-- Revisar los estilos de este button --}}
        {{-- <a href="#" id="btnLogout" type="button" class="btn btn-header"></a> --}}
    </div>
</header>

<script>
    const btnBuscar = document.getElementById("btnBuscar");
    let searchFuncionalidad = document.getElementById("searchFuncionalidad");
    
    btnBuscar.addEventListener("click", function() {
        if(searchFuncionalidad.value == ""){
            alert("Campo vacío");
            return;
        }
        sendData(
            "/funcionalidades/buscarByName",
            {
            "nombre": searchFuncionalidad.value
            }
        )
        .then(res => res.json())
        .then(result => {
                if(result.status == 404){
                    alert("Funcionalidad no encontrado");
                }else if(result.status == 200){
                    window.location.href = `/${result.data.ruta}`
                }else{
                    console.log(result);
                }
        })
        .catch(error => console.error('Error al realizar la búsqueda:', error));
    });
</script>