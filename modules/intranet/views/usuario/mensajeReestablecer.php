<?php
use yii\helpers\Html;
?>
<div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
  <h2 class="normal">
    Contraseña reestablecida con éxito
  </h2>
  <p>
    Ahora puedes ingresar con tu nueva contraseña a la <?= Html::a('Intranet', yii::$app->urlManager->createAbsoluteUrl('intranet/usuario/autenticar'), ['style' => "font-size:13px;"]);?>. Para ingresar dar clic <?= Html::a('aqu&iacute;', yii::$app->urlManager->createAbsoluteUrl('intranet/usuario/autenticar'), ['style' => "font-size:13px;"]);?>
  </p>
</div>
