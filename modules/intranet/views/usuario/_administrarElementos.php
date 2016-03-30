<?php 
use app\modules\intranet\models\Indicadores;

?>

<input type='checkbox' data-role="toggle-elemento" data-elemento="1" <?= !in_array("1", $opciones)?'checked':''?> /> Banner Inicio <br/>
<input type='checkbox' data-role="toggle-elemento" data-elemento="2" <?= !in_array("2", $opciones)?'checked':''?> /> Cumpleaños <br/>
<!-- Indicadores -->

<?php foreach(Indicadores::find()->all() as $indicador):?>
<input type='checkbox' data-role="toggle-elemento" data-elemento="3_<?= $indicador->idIndicador?>" <?= !in_array("3_$indicador->idIndicador", $opciones)?'checked':''?> /> Indicador <?= $indicador->descripcion?> <br/>
<?php endforeach;?>

<!-- Fin de indicadores -->

<input type='checkbox' data-role="toggle-elemento" data-elemento="4" <?= !in_array("4", $opciones)?'checked':''?> /> Ofertas Laborales <br/>
<input type='checkbox' data-role="toggle-elemento" data-elemento="5" <?= !in_array("5", $opciones)?'checked':''?> /> Tareas <br/>
<input type='checkbox' data-role="toggle-elemento" data-elemento="6" <?= !in_array("6", $opciones)?'checked':''?> /> Banner Fin <br/>