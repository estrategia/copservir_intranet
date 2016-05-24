<?php 
use app\modules\intranet\models\ModuloContenido;
?>

<?php if ($objModulo->tipo == ModuloContenido::TIPO_HTML): ?>
    <?= $this->render('//common/contenido/_html', array('objModulo' => $objModulo)) ?>
<?php elseif ($objModulo->tipo == ModuloContenido::TIPO_DATATABLE): ?>
    <?php $this->registerJsFile("@web/js/datatable.js", ['depends' => [app\assets\DataTableAsset::className()]]); ?>
    <?= $this->render('//common/contenido/_html', array('objModulo' => $objModulo)) ?>
    <div class="space-1"></div>
<?php endif; ?>
