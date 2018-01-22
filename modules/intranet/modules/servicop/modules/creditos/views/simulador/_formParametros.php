<?php foreach ($parametros as $key => $parametro): ?>
    <?php if ($parametro['solicitarUsuario'] == 1): ?>
        <div data-role="parametros-usuario-credito" class="<?php echo $parametro['idGarantia'] == null ? '' : 'hidden' ?>" data-id-garantia="<?php echo $parametro['idGarantia'] == null ? 0 : $parametro['idGarantia'] ; ?>">
            <label for=""><?php echo $parametro['nombreParametro'] ?></label>
            <input type="text" class="form-control formatear-numero" name="<?php echo 'parametro-' . $parametro['idParametro'] ?>" data-id-garantia="<?php echo $parametro['idGarantia'] == null ? 0 : $parametro['idGarantia'] ; ?>" value="0">
        </div>
    <?php endif ?>
<?php endforeach ?>
