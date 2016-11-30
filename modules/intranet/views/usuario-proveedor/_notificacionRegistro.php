<?php use yii\helpers\Html; ?>
<pre style="font-family: Arial; font-color:black!important;">
Señor <?php echo $nombreUsuario; ?>

<?php echo $laboratorio; ?>


Desde este momento ha sido creado como administrador de la cuenta a nombre de <strong><?php echo $laboratorio; ?></strong> de la cual usted es el representante legal.

Esta calidad le permite crear nuevos accesos al personal que tiene relación con el  modelo comercial de Copservir Ltda. Cargos y perfiles como Gerentes de Cuenta, Representantes de Ventas y/o Visitadores Médicos tendrán la posibilidad de acceder a información importante, actualizada y  disponible las 24 horas sobre su compañía y los convenios comerciales con Copservir Ltda.

Los usuarios creados en su cuenta tendrán la facultad de visualizar servicios  los cuales podrán ser habilitados o deshabilitados por su cuenta de administrador, además también podrá activar o inactivar usuarios, ejemplo si el usuario ya no trabaja en la compañía usted podrá inactivarlo.

<strong>Los servicios que tenemos disponibles por el momento son:</strong>
  1. Información general 
  2. Visita médica
  3. Actividades Comerciales
  4. Certificados Tributarios
  5. Mis productos
  6. Informe de Ventas
  7. Citas Entrega de Mercancía

SRecuerde que la cuenta de administrador esta asignada a su perfil y es la única que cuenta con la opción de crear otros usuarios asociados a su compañía, es importante que tenga presente los siguientes datos de acceso:

<strong>Usuario:</strong> <?php echo $infoUsuario['usuario']; ?>

<strong>Contraseña:</strong> <?php echo $infoUsuario['password']; ?>

<strong>Link de acceso: </strong> <?= Html::a('Portal colaborativo', yii::$app->urlManager->createAbsoluteUrl('proveedores/usuario/autenticar'), array('target' => '_blank'));?>.
</pre>