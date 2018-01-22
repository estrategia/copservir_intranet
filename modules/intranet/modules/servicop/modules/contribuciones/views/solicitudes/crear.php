<?php 
use kartik\select2\Select2;
?>
<form action="" id="form-solicitar-contribucion">
    <div class="row">
        <div class="col-md-6">
            <label for="">Contribución</label>
            <?= Select2::widget([
                'name' => 'contribucion',
                'data' => $selectContribuciones,
                'options' => [
                    'placeholder' => 'Seleccione una contribución',
                    'empty' => [NULL => 'Asociado']
                ],
                'pluginEvents' => [

                ]
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div id="widget-parentesco-contribucion">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div id="widget-beneficiario-contribucion">
                
            </div>
        </div>
    </div>
    <br>
<button class="btn btn-primary" data-role="solicitar-contribucion">Solicitar Contribucion</button>
</form>
