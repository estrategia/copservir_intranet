<img src="<?= $imagen ?>" alt="">
<p class="node-title">
    <a data-role="perfil-usuario" data-numero-documento="<?= $empleado['NumeroDocumento'] ?>" href="#">
        <?php if (isset($empleado['Nombre'])): ?>
            <?= $empleado['Nombre'] ?>
        <?php else: ?>
            <?= $empleado['Nombres'] ?>
        <?php endif ?>
    </a>
</p>
<p class="node-name">
    <?= $empleado['Cargo'] ?>
</p>
