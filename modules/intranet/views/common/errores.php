<!-- para visualizar los mensajes de error -->
<div class="row">
   <div class="col-lg-12">
       <?php foreach (Yii::$app->session->getAllFlashes() as $tipo => $mensaje): ?>
           <div role="alert" class="alert alert-<?= $tipo ?> alert-dismissible fade in">
               <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
               <p><?= $mensaje ?></p>
           </div>
       <?php endforeach; ?>
   </div>
</div>
