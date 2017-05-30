<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\SIICOP;
use app\modules\intranet\models\Funciones;

/**
* CargueVentasForm.
*/
class CargueRestriccionesRedencion extends Model {

  public $archivo;

  /**
  * @return array the validation rules.
  */
  public function rules() {
    return [
      // username and password are both required
      [['archivo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
    ];
  }

  public function attributeLabels() {
    return [
      'archivo' => 'Archivo',
    ];
  }
  
  public function guardarArchivo(){
    $archivo = UploadedFile::getInstance($this, 'archivo');
    $rutaDirectorio = '';
    $nombreArchivo = '';
    $rutaArchivo = '';
    if (!is_null($archivo)) {
      $rutaDirectorio = Yii::getAlias('@app') . Yii::$app->params['formacioncomunicaciones']['directorioCargues'];
      $nombreArchivo = "CargueRestricciones_". Yii::$app->user->identity->numeroDocumento . "_" . date('YmdHis') . '.' . $archivo->extension;
      $rutaArchivo = $rutaDirectorio . $nombreArchivo;
      
      if (!file_exists($rutaDirectorio)) {
        if(!mkdir($rutaDirectorio, 0777, true)){
          throw new \Exception("No se puede crear directorio para cargar $rutaDirectorio", 302);
        }
      }
      
      return $archivo->saveAs($rutaArchivo) ? $rutaArchivo : false;
    }
  }
  
}
