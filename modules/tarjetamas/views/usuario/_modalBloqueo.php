


<div class="modal fade" id="modal-bloqueo" tabindex="-1"  role="dialog">

    <div class="modal-dialog" role="document" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Bloquear tarjeta </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body" id='comentarios_contenido'>
                <!-- listado de me gusta's -->
                ¿Está seguro que desea bloquear la tarjeta con numero <?= $dataTarjeta ?>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-role='bloquear-tarjeta' data-tarjeta='<?= $dataTarjeta?>' >Aceptar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>
