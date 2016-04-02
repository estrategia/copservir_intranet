<div style="width:300px">
    <?php if (empty($listNotificaciones)): ?>
        <div class="notification-messages info">
            <div class="message-wrapper">
                <div class="heading">
                    Sin notificaciones
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php else: ?>
        <?php foreach ($listNotificaciones as $idx => $objNotificacion): ?>
            <?php echo $this->render('_notificacionItem', ['objNotificacion'=>$objNotificacion, 'idx'=>$idx]); ?>
        <?php endforeach; ?>
        <div class="text-center">
            <?= yii\bootstrap\Html::a('Ver todo', ['notificaciones/'], ['class' => 'text-center']) ?>
        </div>
    <?php endif; ?>
</div>




