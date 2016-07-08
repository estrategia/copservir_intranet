<?php
use yii\helpers\Html;
?>
<div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
  <h2 class="normal">
    Contraseña reestablecida con éxito
  </h2>
  <p>
    Ahora puedes ingresar con tu nueva contraseña al portal de la intranet.
    <?= Html::a('ir a la Intranet', yii::$app->urlManager->createAbsoluteUrl('intranet/usuario/autenticar'),
       array('style' => "font-size:13px;", 'class'=>'btn btn-primary'));
    ?>.
  </p>
</div>
