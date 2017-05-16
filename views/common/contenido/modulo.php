<?php
use app\modules\intranet\models\ModuloContenido;
?>

<?php $tituloGrupo = isset($tituloGrupo)?$tituloGrupo:null; ?>

<?php if ($objModulo->tipo == ModuloContenido::TIPO_HTML): ?>
    <?= $this->render('//common/contenido/_html', array('objModulo' => $objModulo,'tituloGrupo'=>$tituloGrupo)) ?>
<?php elseif ($objModulo->tipo == ModuloContenido::TIPO_DATATABLE || $objModulo->tipo == ModuloContenido::TIPO_DATATABLE_CEDULA): ?>

    <?php $this->registerJsFile("@web/js/datatable.js", ['depends' => [app\assets\DataTableAsset::className()]]); ?>
    <?= $this->render('//common/contenido/_html', array('objModulo' => $objModulo,'tituloGrupo'=>$tituloGrupo)) ?>
    <div class="space-1"></div>
<?php endif; ?>

<?php if ($objModulo->tipo == ModuloContenido::TIPO_GALERIA): ?>
  <?= $this->render('//common/contenido/_galeria', array('objModulo' => $objModulo,'tituloGrupo'=>$tituloGrupo)) ?>
<?php endif ?>

<?php if ($objModulo->tipo == ModuloContenido::TIPO_DATATABLE_CEDULA): ?>


<?php
  $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
  $this->registerJs("

  $( document ).ready(function() {
    dataTablesGroupSearch2($objModulo->idModulo, $numeroDocumento)
  });
  ");
?>
<?php endif; ?>
