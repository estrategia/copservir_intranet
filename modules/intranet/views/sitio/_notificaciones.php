<div style="width:300px">
    <?php foreach ($listNotificaciones as $objNotificacion): ?>
        <div class="notification-messages info">
            <div class="message-wrapper">
                <div class="heading">
                    <?= $objNotificacion->descripcion ?>
                </div>
                <div class="date pull-left">
                    <?php $tiempo = $objNotificacion->consultarTiempo(); ?>
                    <?= $tiempo[0] ?> horas <?= $tiempo[1] ?> minutos 
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endforeach; ?>
</div>




