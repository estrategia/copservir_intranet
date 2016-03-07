<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Intranet - Copservir';
?>
<div class="site-index">



    <div class="body-content">

        <div class="row">

            <!-- Las lineas de tiempo -->
            <ul class="nav nav-tabs">
                <?php foreach ($lineasTiempo as $linea): ?>
                    <li ><a data-toggle="tab" data-role="cambiar-timeline" data-timeline="<?= $linea->idLineaTiempo ?>" href="#lt<?= $linea->idLineaTiempo ?>"><?= $linea->nombreLineaTiempo ?></a></li>
                <?php endforeach; ?>
            </ul>

            <!-- el contenido de las lineas de tiempo -->
            <div class="tab-content">
                <?php foreach ($lineasTiempo as $linea): ?>
                   
                    <div id="lt<?= $linea->idLineaTiempo ?>" class="tab-pane fade lineastiempo">
                        
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>
