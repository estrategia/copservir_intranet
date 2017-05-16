<?php

use app\modules\intranet\models\Notificaciones;
use yii\helpers\Url;
?>
<div class="notification-messages <?= $objNotificacion->estadoNotificacion == Notificaciones::ESTADO_CREADA ? Yii::$app->params['notificaciones']['claseColor'][2] : Yii::$app->params['notificaciones']['claseColor'][$idx % 2] ?>">
    <div class="user-profile">
      <a href="<?= Url::to(['contenido/detalle-contenido', 'idNoticia' => $objNotificacion->objContenido->idContenido]) ?>">
        <img width="35" height="35" alt="" src="<?= Yii::$app->homeUrl . 'img/fotosperfil/' . $objNotificacion->objUsuarioDirige->getImagenPerfil() ?>">
      </a>
    </div>
  <div class="message-wrapper">
    <div class="heading">
      <a href="<?= Url::to(['contenido/detalle-contenido', 'idNoticia' => $objNotificacion->objContenido->idContenido]) ?>">
        <?= ($objNotificacion->objUsuarioDirige == null ? "APP" : $objNotificacion->objUsuarioDirige->alias) ?> - <?= $objNotificacion->descripcion ?>
      </a>
    </div>
    <div class="description">
      <a href="<?= Url::to(['contenido/detalle-contenido', 'idNoticia' => $objNotificacion->objContenido->idContenido]) ?>">
        <?= (empty($objNotificacion->objContenido->titulo) ? "Sin t&iacute;tulo" : $objNotificacion->objContenido->titulo) ?>
      </a>
    </div>
  </div>
  <div class="date pull-right">
    <time class="timeago" datetime="<?= $objNotificacion->fechaRegistro ?>"></time>
  </div>
  <div class="clearfix"></div>
</div>
