<div class="row <?php echo ($nHojas > 1) ? "data-tables-group": ""?>">
    <?php if ($nHojas > 1): ?>
        <div class="col-md-12">
            <div class="m-t-10 input-prepend inside search-form no-boarder">
                <div class="add-on" data-role="data-tables-busqueda" data-modulo="<?= $idModulo ?>"> <span class="iconset top-search"></span></div>
                <input data-role="data-tables-texto-busqueda"  data-modulo="<?= $idModulo ?>" type="text" placeholder="Buscar" class="dark form-control no-boarder" style="width:300px;">
            </div>
        </div>
        <div class="col-md-12"></div>
        <div class="col-md-12">
            <ul role="tablist" class="nav nav-tabs">
                <?php foreach ($hojas as $idHoja => $nombreHoja): ?>
                    <li class="<?= $idHoja == 0 ? "active" : "" ?>">
                        <a data-toggle="tab" role="tab" href="#table-group-<?= $idModulo ?>_<?= $idHoja ?>" aria-expanded="true"><?= $nombreHoja ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="tab-content">
                <?php foreach ($hojas as $idHoja => $nombreHoja): ?>
                    <div id="table-group-<?= $idModulo ?>_<?= $idHoja ?>" class="tab-pane <?= $idHoja == 0 ? "active" : "" ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped data-table" data-modulo="<?= $idModulo ?>">
                                    <?= $this->render('datatable_table', ['objWorksheet' => $objPHPExcel->getSheet($idHoja)->toArray(null, true, true, true)]) ?>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="space-1"></div>
        <div class="col-md-12">
            <table class="table table-striped data-table" data-modulo="<?= $idModulo ?>">
                <?= $this->render('datatable_table', ['objWorksheet' => $objPHPExcel->getSheet(0)->toArray(null, true, true, true)]) ?>
            </table>
        </div>
    <?php endif; ?>
</div>
