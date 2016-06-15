<?php
use app\modules\intranet\models\Menu;
?>

<?php foreach ($menu as $subMenu): ?>
  <?php Menu::menuHtml($subMenu, $opciones->getOpcionesUsuario()); ?>
<?php endforeach; ?>
