<div class="col-md-8">
    <br><br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-title no-border" style='background-color:#0AA699 !important'>
                    <h4 style='color:#fff !important;'>Ofertas <span class="semi-bold">Laborales</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#grid-config" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="grid-body no-border">
                    <p>La Oficina de Talento Humano ...</p>
                    <?php if (!empty($ofertasLaborales)): ?>
                        <table class="table table-hover no-more-tables">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Oferta</th>
                                    <th>Ciudad</th>
                                    <th>Fecha</th>
                                    <th>Area</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 ?>
                                <?php foreach ($ofertasLaborales as $oferta): ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $oferta->objCargo->nombreCargo ?></td>
                                        <td><?= $oferta->objCiudad->nombreCiudad ?></td>
                                        <td><?= $oferta->fechaCierre ?></td>
                                        <td><?= $oferta->objArea->nombreArea ?></td>
                                        <td><a href="<?= $oferta->urlElEmpleo ?>" type="button" class="btn btn-primary btn-sm btn-small" target="_blank">Postularse</a></td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>