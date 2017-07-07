<?php

use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="container internal">
    <div class="space-2"></div>
    <div class="space-2"></div>
    <div class="row">
        <div class="col-md-12">
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
               		['attribute' => 'IdPQRS', 
               				'label' => 'No. Caso', 
							'format' => 'html' ,
               				'value' => function($model){
               					return "<a href='".$model['url']."'>".$model['IdPQRS']."</a>";
               				}
               		
               		],
                    ['attribute' => 'Cliente', 'label' => 'Usuario'],
                    ['attribute' => 'Ciudad',
                     'label' => "Ciudad"],
                    ['attribute' => 'tipoCaso', 'label' => 'Tipo'],
                    ['attribute' => 'origenCaso', 'label' => "Origen"],
                    ['attribute' => 'tipoPQRS','label' => "Concepto"],
                    ['attribute' => 'prioridad','label' => "Prioridad"],
                    ['attribute' => 'estado','label' => "Estado"],
                    ['attribute' => 'fecha','label' => "Fecha"],
                    
                ]
            ]);
            ?>

        </div>
    </div>
  
</div>