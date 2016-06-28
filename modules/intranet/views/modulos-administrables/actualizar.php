<?php

use yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use app\modules\intranet\models\ModuloContenido;
/* @var $this yii\web\View */
/* @var $model app\models\TipoPQRS */

$this->title = Yii::t('app', 'Actualizar  ', []);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Módulos Administrativos'),'url' => ['admin']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Editar')];
?>

<?= $this->render('/common/errores', []) ?>

<div class="box-content row" id='botones-modulos'>
    <div class="col-md-12">
        <div class="form-group">
            <div class="center">
                <div class="btn-group">
                    <?=  Html::a('Editar',['actualizar','id' => $params['model']->idModulo],['class' => "btn btn-primary ".(($params['opcion'] == 'editar')?"active":"")] )?>
                    <?=  Html::a('Contenido',['contenido','id' => $params['model']->idModulo],['class' =>"btn btn-primary ".(($params['opcion'] == "contenido")?"active":"")] )?>
                </div>
                <?php //if($params['model']->tipo == ModuloContenido::TIPO_GROUP_MODULES):?>
                <br>
                <br>
                <br>
                <div class="form-group">
                  <label for="CopyUrl"> Url</label>
                  <div class="input-group">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="copy-button"
                      data-toggle="tooltip" data-placement="button"
                          title="Copy to Clipboard">
                        Copiar
                      </button>
                    </span>
                    <?= Html::textInput('CopyUrl',
                      Yii::$app->params['rutaGruposModulos'].$params['model']->idModulo,
                      ['disabled' => 'disabled', 'class' =>'form-control', 'id' => 'copy-input']
                       ) ?>
                  </div>



                </div>
                <?php //endif;?>
            </div>
            <br/>
            <div>
                <?= $this->render($params['vista'], $params) ?>
            </div>
        </div>
    </div>
</div>

<?php
  $this->registerJs("
  $(document).ready(function() {
// Initialize the tooltip.
$('#copy-button').tooltip();

// When the copy button is clicked, select the value of the text box, attempt
// to execute the copy command, and trigger event to update tooltip message
// to indicate whether the text was successfully copied.
$('#copy-button').bind('click', function() {
  var input = document.querySelector('#copy-input');
  input.setSelectionRange(0, input.value.length + 1);
  try {
    var success = document.execCommand('copy');
    if (success) {
      $('#copy-button').trigger('copied', ['Copiado!']);
    } else {
      $('#copy-button').trigger('copied', ['Copiar con Ctrl-c']);
    }
  } catch (err) {
    $('#copy-button').trigger('copied', ['Copiar con Ctrl-c']);
  }
});

// Handler for updating the tooltip message.
$('#copy-button').bind('copied', function(event, message) {
  console.log($(this));
  $(this).attr('title', message);
  $(this).attr('show');

  /*$(this).attr('title', message)
      .tooltip('fixTitle')
      .tooltip('show')
      .attr('title', 'Copy to Clipboard');
      .tooltip('fixTitle');*/
});
});


  ");
?>
