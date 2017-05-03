<?php $tituloGrupo = isset($tituloGrupo)?$tituloGrupo:null; ?>
<div class="container-fluid">
    <?php if (!empty($objModulo->titulo) && empty($tituloGrupo)): ?>
        <h1><?php echo $objModulo->titulo ?></h1>
    <?php endif; ?>
    <?php echo $objModulo->getContenido() ?>
</div>
