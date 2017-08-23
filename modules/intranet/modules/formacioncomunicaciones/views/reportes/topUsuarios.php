<?php 
    $this->title = 'Ranking';
    $this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['mis-cursos']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<h1>Top Usuarios Formación y Comunicación</h1>
<table class="table table-stripped table-responsive">
    <thead>
        <tr>
            <th>Ranking</th>
            <th>Puntos</th>
            <th>Tiempo</th>
            <th colspan="2">Usuario</th>
            <th>Cargo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($top as $key => $registro): ?>
            <?php $usuario = $registro['usuario'] ?>
            <tr>
                <td>
                    <span class="badge"><?php echo $registro['rank'] ?></span>
                </td>
                <td>
                    <?php echo $registro['puntos'] ?>
                </td>
                <td>
                    <?php echo gmdate('H:i:s', $registro['tiempo']) ?>
                </td>
                <td>
                    <img src= <?= Yii::$app->homeUrl . 'img/fotosperfil/' . $usuario->getImagenPerfil() ?> alt="" data-src="" data-src-retina="" width="30" height="30">
                </td>
                <td>
                  <?php echo $usuario->objUsuarioIntranet->nombres . ' ' . $usuario->objUsuarioIntranet->primerApellido . ' ' . $usuario->objUsuarioIntranet->segundoApellido?>
                </td>
                <td>
                  <?php echo $usuario->objUsuarioIntranet->nombreCargo ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
