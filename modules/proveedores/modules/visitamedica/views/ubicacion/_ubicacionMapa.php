<div id="modal-ubicacion-map" class="modal map animated bounceIn" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center">Ubica en el mapa el lugar donde deseas consultar los productos</h3>
                <div class="selects">
                    <div style="margin-right: 1px; width: 50%" id="select-ubicacion-psubsector">
                        <select class="" id='ciudad-selector' data-role="ciudad-despacho-map" style="width: 100%">
                            <option value="">Seleccione ciudad ...</option>
                            <?php foreach ($ciudades as $ciudad): ?>
                                <option data-latitud="<?php echo $ciudad->latitudGoogle  ?>" data-longitud="<?php echo $ciudad->longitudGoogle  ?>" value="<?php echo $ciudad->codigoCiudad ?>"><?php echo $ciudad->nombreCiudad ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="select-ubicacion-sector" style="margin-left: 1px; width: 50%" hidden="hidden">
                        
                    </div>
                </div>
            </div>  
            <div class="modal-body">
                <div class="map-content" id="map"></div>
            </div>
            <div class="modal-footer">
                <div class="buttons">
                    <button type="button" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="ubicarSeleccion()">Confirmar ubicaci&oacute;n</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#ciudad-selector').select2();
</script>
