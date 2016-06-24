<?php 
use app\modules\intranet\models\ModuloContenido;
?>

<?php $tituloGrupo = isset($tituloGrupo)?$tituloGrupo:null; ?>

<?php if ($objModulo->tipo == ModuloContenido::TIPO_HTML): ?>
    <?= $this->render('//common/contenido/_html', array('objModulo' => $objModulo,'tituloGrupo'=>$tituloGrupo)) ?>
<?php elseif ($objModulo->tipo == ModuloContenido::TIPO_DATATABLE): ?>
    <?php $this->registerJsFile("@web/js/datatable.js", ['depends' => [app\assets\DataTableAsset::className()]]); ?>
    <?= $this->render('//common/contenido/_html', array('objModulo' => $objModulo,'tituloGrupo'=>$tituloGrupo)) ?>
    <div class="space-1"></div>
<?php endif; ?>
