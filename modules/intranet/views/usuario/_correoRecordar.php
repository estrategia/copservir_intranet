<?php
use yii\helpers\Html;
?>
<div style="height: 20px;"></div>
<p>
   <span style="font-size:15pt; color:#b10000;text-align:left;">¡Hola!</span>
   <br/>
   <span style="font-size:15pt;color:#b10000;"><?= $infoUsuario['Nombres'].' '.$infoUsuario['PrimerApellido'].' '.$infoUsuario['SegundoApellido']; ?></span>
</p>
<div style="height: 20px;"></div>
<p>Restablece tu contraseña dando clic en el siguiente enlace:
  <br>
  <?= $enlace?>
</p>
<p>
   Ten en cuenta que este vínculo solo estará activo durante 24 horas desde el momento de su creación.
   Una vez que este límite de tiempo finalice, el enlace caducará y deberás volver a enviar la solicitud de cambio de contraseña desde
   <?= Html::a('Intranet', yii::$app->urlManager->createAbsoluteUrl('intranet/usuario/autenticar'), 
      array('target' => '_blank', 'style' => "font-size:13px; color:#BDBDBD")); ?>.
</p>
