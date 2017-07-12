<?php

use yii\helpers\Html;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buscar Cursos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buscador-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_buscador_form', 
        [
            'model' => $searchModel,
        ]); 
    ?>
    <br>
    <?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item_misCursos',
    'layout' => '{summary}{items}{pager}',
    'pager' => [
        'prevPageLabel' => 'Anterior',
        'nextPageLabel' => 'Siguiente',
        'maxButtonCount' => 3,
    ],
]); ?>

</div>
