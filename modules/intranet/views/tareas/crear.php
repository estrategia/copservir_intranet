<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Tareas */

$this->title = 'Crear Tareas';
//$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>


<div class="tareas-create">

	<div class="col-md-12">
	    <div class="grid simple ">
	        <div class="grid-title no-border" style="background-color: #0AA699 !important;">
	            <h4 style="color:#fff !important;">Administrar  <span class="semi-bold">Tareas</span></h4>
	            <div class="tools">	<a href="javascript:;" class="collapse"></a>
					<a href="#grid-config" data-toggle="modal" class="config"></a>
					<a href="javascript:;" class="reload"></a>
					<a href="javascript:;" class="remove"></a>
	            </div>
	        </div>
	        <div class="grid-body no-border">
	              <h3>Crear  <span class="semi-bold">tareas</span></h3>

	              <?= $this->render('_form', [
	        			'model' => $model,
	    			]) ?>

	        </div>
	    </div>
	</div>

</div>
