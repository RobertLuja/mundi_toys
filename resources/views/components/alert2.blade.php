<div 
    class="alert__v2 alert alert-dismissible fade show m-2 p-0"
    role="alert">
    
    <div class="d-flex justify-content-center w-100">
        <i 
        class="{{ $icon }}"
        style="color: {{ $color }}; font-size: 60px;">
        </i>
    </div>

    <div class="p-1" style="width: 100%;">
        <div class="title text-center">
        <small>
            <strong>{{ $title }}</strong>
        </small>
        </div>
        <div class="content text-center">
        <small>{{ $description }}</small>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <button type="button" 
            class="btn__ok__alert__v2 m-2"
            style="background-color: {{ $color }};"
            data-bs-dismiss="alert"
            aria-label="Close">
            Close
        </button>
    </div>
</div>