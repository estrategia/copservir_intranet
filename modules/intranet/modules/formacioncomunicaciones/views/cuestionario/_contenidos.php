<option value=""> Toda la unidad </option>
<?php foreach($model as $modelo):?>
	<option value=<?= $modelo->idContenido ?>><?= $modelo->tituloContenido ?></option>
<?php endforeach;?>
