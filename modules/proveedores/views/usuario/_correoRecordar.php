<?php
use yii\helpers\Html;
?>
<div style="height: 20px;"></div>
<p>
    <span style="font-size:15pt; color:#b10000;text-align:left;">¡Hola!</span>
    <br/>
    <span style="font-size:15pt;color:#b10000;"><?= $infoUsuario->nombre . ' ' . $infoUsuario->primerApellido . ' ' . $infoUsuario->segundoApellido; ?></span>
</p>
<div style="height: 20px;"></div>
<p>Restablece tu contraseña haciendo clic <?= Html::a("aqu&iacute;", $enlace, array('style' => "font-size:13px; color:#BDBDBD"));?> o copiando el siguiente enlace en tu navegador:</p>

<p><?= $enlace ?></p>

<p>
    Ten en cuenta que este vínculo solo estará activo durante <?= \Yii::$app->params['usuario']['tiempoRecuperarClave']*24 ?> horas desde el momento de su creación.
    Una vez que este límite de tiempo finalice, el enlace caducará y deberás volver a enviar la solicitud de cambio de contraseña desde el
    <?= Html::a('Portal colaborativo', yii::$app->urlManager->createAbsoluteUrl('proveedores/usuario/autenticar'), array('target' => '_blank', 'style' => "font-size:13px; color:#BDBDBD"));?>.
</p>
