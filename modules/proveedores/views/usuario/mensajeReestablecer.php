<?php
use yii\helpers\Html;
?>
<div class="container">
  <div class="row">
    <h2 class="normal">
      Contraseña reestablecida con éxito
    </h2>
    <p>
      Ahora puedes ingresar con tu nueva contraseña al portal colaborativo. Para ingresar dar clic <?= Html::a('aqu&iacute;', yii::$app->urlManager->createAbsoluteUrl('proveedores/usuario/autenticar'), ['style' => "font-size:13px;"]);?>
    </p>
  </div>
</div>
