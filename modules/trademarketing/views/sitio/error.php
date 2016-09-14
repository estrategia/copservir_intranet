<?php

use yii\helpers\Html;

$this->title = $name;

?>

<div class="space-1"></div>
<div class="space-2"></div>

<div class="container">

	<div class="site-error">
	  <h1><?= Html::encode($this->title) ?></h1>

	  <div class="alert alert-danger">
	    <?= nl2br(Html::encode($message)) ?>
	  </div>
	</div>

</div>

<div class="space-1"></div>
<div class="space-2"></div>
