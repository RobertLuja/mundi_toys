<footer id="footer">
    <div
        class="cantidad_visitas me-2"
        style="cursor: default;"
        data-bs-toggle="tooltip"
        data-bs-placement="left"
        title="Cantidad de visitas">
        <span class="p-1 badge rounded-pill bg-danger fs-6">
            {{ App\Models\Visita::where('ruta', request()->getPathInfo())->value('cantidad') }}
        </span>
    </div>
    Derechos reservados {{ date("Y") }}
</footer>