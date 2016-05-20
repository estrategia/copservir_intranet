<?php 
use app\modules\intranet\models\ModuloContenido;
?>

<?php if ($objModulo->tipo == ModuloContenido::TIPO_HTML): ?>
    <?= $this->render('//common/contenido/_html', array('objModulo' => $objModulo)) ?>
<?php elseif ($objModulo->tipo == ModuloContenido::TIPO_DATATABLE): ?>
    <?= $this->render('//common/contenido/_html', array('objModulo' => $objModulo)) ?>
<?php endif; ?>
