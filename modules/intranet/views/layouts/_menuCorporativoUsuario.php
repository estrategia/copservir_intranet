<?php use app\modules\intranet\models\Menu; ?>

<?php if (!empty($opciones->getOpcionesUsuario())): ?>
    <?php foreach ($menu as $subMenu): ?>
        <?php Menu::menuHtml($subMenu, $opciones->getOpcionesUsuario()); ?>
    <?php endforeach; ?>
<?php endif; ?>
