<?php

  $html = '';

  /*
  $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
  $separador = ",";
	$array_lrv = array();
	$existe = false;
	if(($handle = fopen("ruta archivo", "r")) !== false)
	{
		while(($datos = fgetcsv($handle, 0, $separador)) !== false){
			$array_lrv[$datos[0]] = $datos;
			if(trim($datos[0])==$cedulaUsuario){
				$existe=true;
				break;
			}

		}
		fclose($handle);
	}
  */

  $ipUsuario= $_SERVER['REMOTE_ADDR'];
  $ipNegacion = explode('.',$ipUsuario);
  $ipNegado = $ipNegacion[0];

  //if($existe){
  //si existe la cedula en el csv no muestra nada
  //$html .='No Mostrar';
  //}


  if($ipNegado == 192) {
  $html .='<div align="right" style="width:87%; margin: 0 auto;">
        <table>
          <tr>
            <td>
              <img src="'.Yii::getAlias('@web').'/img/boton_emisora_copservir.png'.'" alt="Radio Copservir">
            </td>
            <td bgcolor="#585556">
              <audio id="audio-player" controls="controls" autoplay="true" style="width: 180px; height: 28px;">
                <source src="http://radio.cenek.com:8000/radio" type="audio/mpeg">
                <source src="http://radio.cenek.com:8000/radio" type="audio/ogg">
                Su navegador no soporta streaming.
              </audio>
            </td>
          </tr>
        </table>
      </div>';
  } else if ($ipNegado == 10){
  //No muestra nada
  }

?>

<?= $html; ?>
