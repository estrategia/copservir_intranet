<?php 
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
$url = Url::toRoute('/intranet/usuario/buscar-ajax');
?>
<label for="selector-codeudor">Codeudor</label>
<?= Select2::widget([
    'name' => 'codeudor',
    'id' => 'selector-codeudor',
    'options' => ['placeholder' => 'Seleccione un codeudor ...'],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 3,
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Buscando...'; }"),
        ],
        'ajax' => [
            'url' => $url,
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(usuario) { return usuario.text; }'),
        'templateSelection' => new JsExpression('function (usuario) { return usuario.text; }'),
    ],
    'pluginEvents' => [
        "select2:select" => "function() { $('#valor-cuota').val(0).trigger('change'); }"
    ]
]);
?>

