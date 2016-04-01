<div style="width:300px">
    <?php if (empty($listNotificaciones)): ?>
        <div class="notification-messages info">
            <div class="message-wrapper">
                <div class="heading">
                    Sin notificaciones
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php else: ?>
        <?php foreach ($listNotificaciones as $objNotificacion): ?>
            <div class="notification-messages info">
                <div class="message-wrapper">
                    <div class="heading">
                        <?= ($objNotificacion->objUsuarioDirige == null ? "APP" : $objNotificacion->objUsuarioDirige->alias) ?> - <?= $objNotificacion->descripcion ?>
                    </div>
                    <div class="description">
                        <?= (empty($objNotificacion->objContenido->titulo) ? "Sin t&iacute;tulo" : $objNotificacion->objContenido->titulo) ?>
                    </div>
                    <div class="date pull-left">
                        <?php $tiempo = $objNotificacion->consultarTiempo(); ?>
                        <?= $tiempo[0] ?> horas <?= $tiempo[1] ?> minutos 
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>




