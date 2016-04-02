<?php 
use app\modules\intranet\models\Indicadores;

?>
<div class="row">
<div class="col-md-2">
   <div class="buton-check">
       <p><i class="fa fa-picture-o fa-2x"></i></p>
       <input id="baner-inicio" type='checkbox' data-role="toggle-elemento" data-elemento="1" <?= !in_array("1", $opciones)?'checked':''?> /> 
        <label for="baner-inicio"><span><span></span></span> Banner Inicio </label>
   </div>
</div>

<div class="col-md-2">
    <div class="buton-check">
        <p><i class="fa fa-birthday-cake fa-2x"></i></p>
        <input id="cumpleanos" type='checkbox' data-role="toggle-elemento" data-elemento="2" <?= !in_array("2", $opciones)?'checked':''?> /> 
        <label for="cumpleanos"><span><span></span></span> Cumpleaños </label>
    </div>
</div>

<!-- Indicadores -->
<?php foreach(Indicadores::find()->all() as $indicador):?>
    <div class="col-md-2">
         <div class="buton-check">
            <input type='checkbox' data-role="toggle-elemento" id="3_<?= $indicador->idIndicador?>" data-elemento="3_<?= $indicador->idIndicador?>" <?= !in_array("3_$indicador->idIndicador", $opciones)?'checked':''?> /> 
            <label for="3_<?= $indicador->idIndicador?>"><span><span></span></span> Indicador <?= $indicador->descripcion?> </label>
         </div>
    </div>
<?php endforeach;?>
<!-- Fin de indicadores -->

<div class="col-md-2 ">
    <div class="buton-check">
        <p><i class="fa fa-briefcase fa-2x"></i></p>
        <input id="ofertas" type='checkbox' data-role="toggle-elemento" data-elemento="4" <?= !in_array("4", $opciones)?'checked':''?> /> 
        <label for="ofertas"><span><span></span></span> Ofertas Laborales</label>
       
    </div>
</div>

<div class="col-md-2 ">
    <div class="buton-check">
        <p><i class="fa fa-file-o fa-2x"></i></p>
        <input id="tareas" type='checkbox' data-role="toggle-elemento" data-elemento="5" <?= !in_array("5", $opciones)?'checked':''?> /> 
        <label for="tareas"><span><span></span></span>Tareas  </label>
    </div>
</div>

<div class="col-md-2">
    <div class="buton-check">
        <p><i class="fa fa-picture-o fa-2x"></i></p>
        <input id="banner-fin"type='checkbox' data-role="toggle-elemento" data-elemento="6" <?= !in_array("6", $opciones)?'checked':''?> /> 
         <label for="banner-fin"><span><span></span></span>Banner Fin </label>
    </div>
</div>
</div>