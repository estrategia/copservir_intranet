<?php
use app\modules\intranet\models\ModuloContenido;
?>

<?php $tituloGrupo = isset($tituloGrupo)?$tituloGrupo:null; ?>
<div class="portal-container">
    <?php if(!empty($tituloGrupo)): ?>
        <h1><?=$tituloGrupo?></h1>
        <?php endif;?>
    <?php foreach ($listModulos as $objModulo): ?>
      <?php $style = ''; ?>
      <?php if ($objModulo->tipo == ModuloContenido::TIPO_DATATABLE_CEDULA): ?>
        <?php $style = 'display:none'; ?>
      <?php endif; ?>
      <div id="contenido-modulos-<?= $objModulo->idModulo ?>" style="<?= $style ?>">
        <?= $this->render('//common/contenido/modulo', array('objModulo' => $objModulo,'tituloGrupo'=>$tituloGrupo)) ?>
      </div>

    <?php endforeach; ?>
</div>
