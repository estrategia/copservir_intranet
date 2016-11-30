<?php use yii\helpers\Html; ?>
<pre style="font-family: Arial; font-color:black!important;">
Señor <?php echo $nombreUsuario; ?>

<?php echo $laboratorio; ?>


Desde este momento su compañía <strong><?php echo $laboratorio; ?></strong> ha gestionado un usuario el cual le permitirá acceder al Portal Colaborativo de Copservir Ltda. En donde tendrá información importante, actualizada y disponible las 24 horas sobre su compañía y los convenios comerciales con Copservir Ltda.

<strong>Los servicios que tenemos disponibles por el momento son:</strong>
  1. Información general 
  2. Visita médica
  3. Actividades Comerciales
  4. Certificados Tributarios
  5. Mis productos
  6. Informe de Ventas
  7. Citas Entrega de Mercancía

Si alguno de estos servicios no esta disponible al momento de ingresar, es necesario que se ponga en contacto con el representante legal de su compañía <strong><?php echo $laboratorio; ?></strong> para que le asigne los permisos a los servicios, ya que el es la persona encargada de crear usuarios para acceder al Portal Colaborativo de Copservir Ltda. Y a los servicios de este.
Recuerde ingresar al portal y cambiar su contraseña si lo desea, además de gestionar la información de su perfil.

<strong>Información de acceso:</strong> <br>
<strong>Usuario:</strong> <?php echo $infoUsuario['usuario']; ?>

<strong>Contraseña:</strong> <?php echo $infoUsuario['password']; ?>

<strong>Link de acceso: </strong> <?= Html::a('Portal colaborativo', yii::$app->urlManager->createAbsoluteUrl('proveedores/usuario/autenticar'), array('target' => '_blank'));?>.
</pre>