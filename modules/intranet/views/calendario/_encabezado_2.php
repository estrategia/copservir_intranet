<h3 class="text-white semi-bold text-center"><?= Yii::$app->params['calendario']['mesesAbreviado'][$fInicio->format('n')] ?> <?= $fInicio->format('j') ?>/<?= $fInicio->format('y') ?></h3>
<h3 class="text-white semi-bold text-center"><?= Yii::$app->params['calendario']['mesesAbreviado'][$fFin->format('n')] ?> <?= $fFin->format('j') ?>/<?= $fFin->format('y') ?></h3>
<div class="events-heading">&nbsp;Eventos de la semana</div>
