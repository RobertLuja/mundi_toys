<nav id="sidenav">
    <div class="m-3">          
        <div class="d-flex justify-content-center">
            <div>
                <a href="{{route("dashboard.index")}}">
                    <div class="img__logo" id="img__logo">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="150">
                    </div>
                </a>
            </div>
        </div>            
    </div>
    
    @php
        $role = App\Models\Role::find(Auth::user()->rol);

        $roleFuncionalidades = $role->roleFuncionalidades;
        //dd($roleFuncionalidades[0]->funcionalidad->modulo);
        $moduloFuncionalidades = [];
        
        foreach($roleFuncionalidades as $roleFuncionalidad) {
            if($roleFuncionalidad->estado == 1) {
                $funcionalidad = $roleFuncionalidad->funcionalidad;
                $idModulo = $funcionalidad->modulo->id;
                
                $moduloExistente = array_filter($moduloFuncionalidades, 
                                                function ($moduloFuncionalidade) use ($idModulo) {
                                                    return $moduloFuncionalidade["id_modulo"] == $idModulo;
                                                });
                
                if(empty($moduloExistente)) {
                    $moduloFuncionalidades[] = 
                        [
                            "modulo" => $funcionalidad->modulo,
                            "funcionalidades" => [ $funcionalidad ],
                            "id_modulo" => $funcionalidad->modulo->id
                        ];
                }else {
                    $position = key($moduloExistente);
                    $moduloFuncionalidades[$position]["funcionalidades"] = 
                    array_merge(
                        $moduloFuncionalidades[$position]["funcionalidades"],
                        [ $funcionalidad ]
                    );
                }
            }
        }

        $moduloFuncionalidades = json_decode(json_encode($moduloFuncionalidades));

        //dd($moduloFuncionalidades);
        
    @endphp

    @foreach ( $moduloFuncionalidades as $moduloFuncionalidad )
        <div class="accordion__item accordion accordion-flush" id="accordionConfig">
            <div class="bg-transparent accordion-item m-2">
                <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#flush-collapse{{ $moduloFuncionalidad->modulo->id }}"
                    aria-expanded="false"
                    aria-controls="flush-collapse{{ $moduloFuncionalidad->modulo->id }}">
                    <i class="{{ $moduloFuncionalidad->modulo->icono }} me-2" style="color: {{ $moduloFuncionalidad->modulo->color }}"></i>
                    {{ $moduloFuncionalidad->modulo->nombre }}
                </button>
        
                <div
                    id="flush-collapse{{ $moduloFuncionalidad->modulo->id }}"
                    class="accordion-collapse collapse"
                    aria-labelledby="flush-headingOne"
                    data-bs-parent="#accordionConfig">
                    <div
                        class="btn-group-vertical m-2 ms-4"
                        style="width: 90%;"
                        role="group"
                    >
                        @foreach ($moduloFuncionalidad->funcionalidades as $funcionalidad)
                            <a
                                href="{{ route($funcionalidad->ruta.'.index') }}"
                                type="button"
                                class="sidenav__btn__subitem"
                                >{{ $funcionalidad->nombre }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- @include('components.partials.accordion-users')

    @include('components.partials.accordion-company')

    @include('components.partials.accordion-transaction')
    
    @include('components.partials.accordion-config') --}}
    
</nav>