<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\GrupoInteres;

/* @var $this yii\web\View */
/* @var $grupo app\modules\intranet\grupos\GrupoInteres */

$this->title = $grupo->nombreGrupo;
//$this->params['breadcrumbs'][] = ['label' => 'Grupo Interes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
  <div class="grupo-interes-view">

      <p>
          <?= Html::a('Actualizar', ['actualizar', 'id' => $grupo->idGrupoInteres], ['class' => 'btn btn-primary']) ?>
          <?= Html::a('Inactivar', ['eliminar', 'id' => $grupo->idGrupoInteres], [
              'class' => 'btn btn-danger',
              'data' => [
                  'confirm' => 'estas seguro de eliminar este grupo de interes?',
                  'method' => 'post',
              ],
          ]) ?>
      </p>

      <?= DetailView::widget([
          'model' => $grupo,
          'attributes' => [
              'nombreGrupo',
              [
                'attribute' => 'estado',
                'value' =>  $model->estado == GrupoInteres::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
              ],
              [
                'label' => 'Imagen',
                'format'=>'raw',
                'value' => ( empty($grupo->imagenGrupo)) ? 'No hay imagen' :
                  '<img src="'.Yii::getAlias('@web').'/img/gruposInteres/'. $grupo->imagenGrupo.'"
                  class="img-circle img-responsive" style="width: 15%;"/>',
              ],
          ],
      ]) ?>

  </div>
</div>

<div class="col-md-12" id="cargosGrupo">
  <?= $this->render('cargosGrupoInteres', ['grupoInteresCargo' => $grupoInteresCargo, 'modelGrupoInteresCargo' => $modelGrupoInteresCargo,'grupo'=>$grupo]) ?>
</div>
