<div class="row">
	<div class="col-md-3 col-sm-3" >
		<div class="user-profile-pic">
			<img width="69" height="69" data-src-retina=""   data-src="" src="<?= Yii::$app->homeUrl . 'img/fotosperfil/' . \Yii::$app->user->identity->getImagenPerfil() ?>"  alt="">
		</div>
    </div>
    <div class="col-md-5 user-description-box  col-sm-5">
            <h4 class="semi-bold no-margin"><?= $usuario->alias ?></h4>
            <br>
            <p><i class="fa fa-briefcase"></i> <?= $usuario->getCargoNombre() ?></p>
     </div>
</div>