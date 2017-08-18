<?php foreach ($garantias as $key => $garantia): ?>
    <div class="checkbox-inline">
        <label for="<?= $garantia['idGarantia'] ?>" > 
            <?= $garantia['nombreGarantia'] ?> 
            <input style="opacity: 1;" type="checkbox" data-combinada="<?= $garantia['combinada'] ?>" name="<?= 'garantia-' . $garantia['idGarantia'] ?>">
        </label>
    </div>
<?php endforeach ?>