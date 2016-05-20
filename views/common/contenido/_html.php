<div class="container-fluid">
    <section> 
        <?php if (!empty($objModulo->descripcion)): ?>
            <div class="row-fluid">
                <div class="col-md-12 title">
                    <span><i class="glyphicon glyphicon-chevron-right"></i></span>
                    <strong class=""><?php echo $objModulo->descripcion ?></strong>
                </div>
            </div>
        <?php endif; ?>
    </section> 
    <br>
    <?php echo $objModulo->contenido ?>
</div>