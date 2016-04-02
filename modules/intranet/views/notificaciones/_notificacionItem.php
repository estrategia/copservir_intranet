<?php use app\modules\intranet\models\Notificaciones; ?>
<div class="notification-messages <?= $objNotificacion->estadoNotificacion==Notificaciones::ESTADO_CREADA ? Yii::$app->params['notificaciones']['claseColor'][2] : Yii::$app->params['notificaciones']['claseColor'][$idx % 2] ?>">
    <?php if (!empty($objNotificacion->objUsuarioDirige->imagenPerfil)): ?>
        <div class="user-profile"> 
            <img width="35" height="35" alt="" src="<?= Yii::$app->homeUrl . 'img/fotosperfil/' . $objNotificacion->objUsuarioDirige->imagenPerfil ?>"> 
        </div>
    <?php endif; ?>
    <div class="message-wrapper">
        <div class="heading">
            <?= ($objNotificacion->objUsuarioDirige == null ? "APP" : $objNotificacion->objUsuarioDirige->alias) ?> - <?= $objNotificacion->descripcion ?>
        </div>
        <div class="description"> 
            <?= (empty($objNotificacion->objContenido->titulo) ? "Sin t&iacute;tulo" : $objNotificacion->objContenido->titulo) ?>
        </div>
    </div>
    <div class="date pull-right">
        <?php $tiempo = $objNotificacion->consultarTiempo(); ?> <?= $tiempo[0] ?> horas <?= $tiempo[1] ?> minutos
    </div>
    <div class="clearfix"></div>
</div>