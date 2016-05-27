<div class="portal-container">
    <?php foreach ($listModulos as $objModulo): ?>
        <?= $this->render('//common/contenido/modulo', array('objModulo' => $objModulo)) ?>
    <?php endforeach; ?>
</div>