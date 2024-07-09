
<div 
    style="width: 20%; height: auto; position: fixed; top: 8%; right: 2%; background-color: #EBDBC5;"
    class="alert alert-dismissible fade show d-flex p-0"
    role="alert">

    <div style="width: 92%;" class="d-flex">
        <div style="width: 4%; height: 100%; background-color: {{ $color }}; border-radius: 10px; position: absolute; top: 0; left: 0;"></div>

        <div style="width: 20%; color: {{ $color }}" class="m-auto ps-2">
            <i class="{{ $icon }}" style="font-size: 40px;"></i>
        </div>

        <div style="width: 76%;" class="p-1 d-flex flex-column justify-content-center">
            <small>{{ $message }}</small>
        </div>
    </div>

    <button 
        type="button"
        style="width: 8%; border: none; font-size: 20px; background: transparent; color: {{ $color }}; position: absolute; right: 3%;"
        data-bs-dismiss="alert"
        aria-label="Close">
        <i class="bi bi-x-lg fs-4"></i>
    </button>
</div>