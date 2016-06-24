<?php $tituloGrupo = isset($tituloGrupo)?$tituloGrupo:null; ?>
<div class="portal-container">
    <?php if(!empty($tituloGrupo)): ?>
        <h1><?=$tituloGrupo?></h1>
        <?php endif;?>
    <?php foreach ($listModulos as $objModulo): ?>
        <?= $this->render('//common/contenido/modulo', array('objModulo' => $objModulo,'tituloGrupo'=>$tituloGrupo)) ?>
    <?php endforeach; ?>
</div>