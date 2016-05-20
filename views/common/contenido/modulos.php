<div class="portal-container">
    <?php foreach ($listModulos as $objModulo): ?>
        <?= $this->render('//common/contenido/modulo', array('objModulo' => $objModulo)) ?>
        <div class="space-1"></div>
    <?php endforeach; ?>
</div>