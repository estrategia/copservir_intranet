<?php use app\modules\intranet\models\Menu;
$items = $opciones->getOpcionesUsuario();
?>

<?php if (!empty($items)): ?>
    <?php foreach ($menu as $subMenu): ?>
        <?php Menu::menuHtml($subMenu, $items); ?>
    <?php endforeach; ?>
<?php endif; ?>
