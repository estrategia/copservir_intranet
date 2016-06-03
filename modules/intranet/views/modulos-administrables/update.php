<?php

use yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model app\models\TipoPQRS */

$this->title = Yii::t('app', 'Actualizar  ', [
        ]);
?>
<?=
Breadcrumbs::widget([
    'itemTemplate' => "<li>{link}</li>\n", // template for all links
    'links' => [
        [
            'label' => 'Modulos Administrativos',
            'url' => ['index'],
        ],
        'Editar',
    ],
]);?>
<br/>
<div class="box-content row" id='botones-modulos'>
    <div class="col-md-12">
        <div class="form-group">
            <div class="center">
                <div class="btn-group">
                    <?=  Html::a('Editar',['update','id' => $params['model']->idModulo],['class' => "btn btn-primary ".(($params['opcion'] == 'editar')?"active":"")] )?>
                    <?=  Html::a('Contenido',['contenido','id' => $params['model']->idModulo],['class' =>"btn btn-primary ".(($params['opcion'] == "contenido")?"active":"")] )?>
                </div>
            </div>
            <br/>
            <div>
                <?= $this->render($params['vista'], $params) ?>
            </div>
        </div>
    </div>
</div>