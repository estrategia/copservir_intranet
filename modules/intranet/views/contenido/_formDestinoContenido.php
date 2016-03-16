<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Ciudad;
?>

<div class="row">
    <div class="col-md-5">
        <?= Html::label('Grupo de Interés') ?>
        <?php echo Html::dropDownList('ContenidoDestino[idGrupoInteres][]', null, ArrayHelper::map(GrupoInteres::find()->all(), 'idGrupoInteres', 'nombreGrupo')); ?>
    </div>
    <div class="col-md-5">
        <?= Html::label('Ciudad') ?>
        <?php echo Html::dropDownList('ContenidoDestino[codigoCiudad][]', null, ArrayHelper::map(Ciudad::find()->all(), 'codigoCiudad', 'nombreCiudad')) ?>
    </div>
    <div class="col-md-1">
       
        <!-- las noticias -->
        <?=
        Html::a('<i class = "fa fa-plus-square" ></i>','#', [
            //'id' => 'showFormPublications' . $linea->idLineaTiempo,
            'data-role' => 'agregar-destino-contenido',
        ]);
        ?>
    </div>

</div>
<br/>