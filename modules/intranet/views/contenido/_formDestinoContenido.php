<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Ciudad;
use kartik\select2\Select2;
?>
<?php $uid = uniqid(); ?>
<div class="row" id='<?= $uid ?>'>
    <div class="col-md-5">
        <?= Html::label('Grupo de Interés') ?>
        <?php // echo Html::dropDownList('ContenidoDestino[idGrupoInteres][]', null, ArrayHelper::map(GrupoInteres::find()->all(), 'idGrupoInteres', 'nombreGrupo')); ?>
        <?= Select2::widget([
            'name' => 'ContenidoDestino[idGrupoInteres][]',
            'id' => "grupo_$uid",
            'data' => ArrayHelper::map(GrupoInteres::find()->all(), 'idGrupoInteres', 'nombreGrupo'),
            'options' => ['placeholder' => 'Selecione ...']
        ]);
        ?>
    </div>
    <div class="col-md-5">
        <?= Html::label('Ciudad') ?>
        <?php // echo Html::dropDownList('ContenidoDestino[codigoCiudad][]', null, ArrayHelper::map(Ciudad::find()->all(), 'codigoCiudad', 'nombreCiudad')) ?>
        <?=
        Select2::widget([
            'name' => 'ContenidoDestino[codigoCiudad][]',
            'value' => '',
            'id' => "ciudad_$uid",
            'data' => ArrayHelper::map(Ciudad::find()->all(), 'codigoCiudad', 'nombreCiudad'),
            'options' => ['placeholder' => 'Selecione ...']
        ]);
        ?>
    </div>
    <div class="col-md-1">
        <?= Html::label('Quitar') ?>
        <?=
        Html::a('<i class = "fa fa-minus-square" ></i>', '#', [
            //'id' => 'showFormPublications' . $linea->idLineaTiempo,
            'data-role' => 'quitar-destino-contenido',
            'data-row' => "#$uid",
            'title' => 'Quitar'
        ]);
        ?>
    </div>
    
</div>
<br/>