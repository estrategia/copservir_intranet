<?php foreach ($garantias as $key => $garantia): ?>
    <div class="radio-inline">
        <label for="<?= $garantia['idGarantia'] ?>" > 
            <input type="radio" name="garantia" value="<?= $garantia['idGarantia'] ?>" data-solicita-codeudor="<?= $garantia['solicitaCodeudor'] ?>">
            <?= $garantia['nombreGarantia'] ?> 
        </label>
    </div>
<?php endforeach ?>
