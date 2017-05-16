<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\GrupoInteres;

$this->title = "Ver grupos";
$this->params['breadcrumbs'][] = ['label' => 'Grupos de interés', 'url' => ['/intranet/grupo-interes/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Ver grupo'];
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
                'value' =>  $grupo->estado == GrupoInteres::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
              ],
              [
                'label' => 'Imagen',
                'format'=>'raw',
                'value' => ( empty($grupo->imagenGrupo)) ? 'No hay imagen' :
                  '<img src="'.Yii::getAlias('@web').'/img/gruposInteres/'. $grupo->imagenGrupo.'"
                  class="img-circle img-responsive" style="width: 15%;"/>',
              ],
              [
                'attribute' => 'padre',
                'value' => $grupo->padre->nombreGrupo
              ]
          ],
      ]) ?>

  </div>
</div>

<div class="col-md-12" id="cargosGrupo">
  <?= $this->render('cargosGrupoInteres', ['grupoInteresCargo' => $grupoInteresCargo, 'modelGrupoInteresCargo' => $modelGrupoInteresCargo,'grupo'=>$grupo]) ?>
</div>
