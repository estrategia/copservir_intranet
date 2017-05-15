<h3 class="text-white semi-bold text-center"><?= Yii::$app->params['calendario']['dias'][$fInicio->format('w')] ?> <?= $fInicio->format('j') ?></h3>
<h2 class="text-white text-center"><?= Yii::$app->params['calendario']['meses'][$fInicio->format('n')] ?> <?= $fInicio->format('Y') ?></h2>
<div class="events-heading">&nbsp;Eventos del d&iacute;a</div>
