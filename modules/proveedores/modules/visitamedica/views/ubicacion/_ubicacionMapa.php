<div class="modal animated bounceIn map" id="modal-ubicacion-map">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title center">Ubica en el mapa el lugar donde deseas que entreguemos el pedido</h1>
                <div class="space-1"></div>
                <div id="select-ubicacion-content" style="width: 50%;" class="center-div">
                    <div id="select-ubicacion-psubsector" style="width: 49%;" class="center-div">
                        <select class="form-control ciudades" data-role="ciudad-despacho-map" style="width: 100%">
                            <option value="">Seleccione ciudad ...</option>
                            <?php foreach ($ciudades as $ciudad): ?>
                                <option data-latitud="<?php echo $ciudad->latitudGoogle  ?>" data-longitud="<?php echo $ciudad->longitudGoogle  ?>" value="<?php echo $ciudad->codigoCiudad ?>-0"><?php echo $ciudad->nombreCiudad ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
            </div>  
            <div class="modal-body">
                <div class="map-content" id="map"></div>
            </div>
            <div class="modal-footer center">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="ubicarSeleccion()">Confirmar ubicaci&oacute;n</button>
            </div>
        </div>
    </div>
</div>