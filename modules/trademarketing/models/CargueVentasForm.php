<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\SIICOP;
use app\modules\intranet\models\Funciones;

/**
* CargueVentasForm.
*/
class CargueVentasForm extends Model {

  public $archivo;
  public $directorio;
  public $documento;
  public $rutaArchivo;
  public $cargado = false;
  public $arrConsulta = [];
  public $fecha;
  public $mes;

  /**
  * @return array the validation rules.
  */
  public function rules() {
    return [
      // username and password are both required
      [['archivo', 'mes'], 'required'],
      [['archivo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
      [['mes'], 'integer', 'min'=>1, 'max'=>12]
    ];
  }

  public function attributeLabels() {
    return [
      'archivo' => 'Archivo',
    ];
  }
  
  public function guardarArchivo(){
  	$archivo = UploadedFile::getInstance($this, 'archivo');
  	
  	if (!is_null($archivo)) {
  		$this->directorio = Yii::getAlias('@app') . Yii::$app->params['tradeMarketing']['directorioCargues'];
  		$this->documento = "CargueVentas_". Yii::$app->user->identity->numeroDocumento . "_" . date('YmdHis') . '.' . $archivo->extension;
  		$this->rutaArchivo = $this->directorio . $this->documento;
  		
  		if (!file_exists($this->directorio)) {
  			if(!mkdir($this->directorio, 0777, true)){
  				throw new \Exception("No se puede crear directorio para cargar $this->directorio", 302);
  			}
  		}
  		
  		if($archivo->saveAs($this->rutaArchivo)){
  			$this->cargado = true;
  		}
  	}
  }
  
  public function procesarArchivo(){
  	if($this->cargado){
  		$unidades = SIICOP::wsGetUnidadesNegocio(1);
  		$unidadesFlip = array_flip($unidades);
  		$nfila = 1;
  		$objFecha = new \DateTime;
  		$this->fecha = $objFecha->format('Y-m-d H:i:s');
  		$mes = $this->mes;
  		$idComercial = "-1";
  		$this->arrConsulta = [ 'insert' => [], 'delete' =>[] ];
  		
  		$file = fopen($this->rutaArchivo,'r');
  		
  		if($file==false){
  			throw new \Exception("Error al abrir archivo '$this->rutaArchivo'", 304);
  		}
  		
  		while ($line = fgets($file)) {
  			$arrLine = explode(";",$line);
  			$concepto = trim($arrLine[0]);
  			$conceptoExplode = explode("-",$concepto);
  			
  			if(count($conceptoExplode)>1){
  				//se obtiene idcomercial
  				$idComercial = trim($conceptoExplode[0]);
  			}else{
  				//se obtienen valores de cada unidad de negocio si existe
  				if(isset($unidadesFlip[$concepto])){
  					$valor = trim($arrLine[1]);
  					$valor = Funciones::getNumeric($valor);
  					$cantidad = trim($arrLine[2]);
  					$cantidad = Funciones::getNumeric($cantidad);
  					$idAgrupacion = $unidadesFlip[$concepto];
  					
  					$this->arrConsulta['insert'][] = [$idComercial,$idAgrupacion,$mes,$valor,$cantidad,$this->fecha];
  					$this->arrConsulta['delete'][] = "('$idComercial','$idAgrupacion','$mes')";
  				}else{
  					fclose($file);
  					throw new \Exception("Registro No. $nfila - Unidad negocio '$concepto' no existente", 102);
  				}
  			}
  		
  			$nfila++;
  		}
  	
  		fclose($file);
  	}
  }
  
  public function procesado(){
  	return ( !empty($this->fecha) && !empty($this->arrConsulta) && isset($this->arrConsulta['insert']) && isset($this->arrConsulta['insert']) && !empty($this->arrConsulta['insert']) && !empty($this->arrConsulta['delete']) );
  }
  
  public function cargarArchivo(){
  	if($this->procesado()){
  		$transaction = \Yii::$app->db->beginTransaction();
  		
  		try{
  			\Yii::$app->db->createCommand()->batchInsert(
  				InformacionVentasActual::tableName(),
  				['idComercial', 'idAgrupacion', 'mes', 'valor', 'unidades', 'fechaRegistro'],
  				$this->arrConsulta['insert']
  			)->execute();
  			
  			//eliminar datos anteriores
  			$sqlDelete = "DELETE FROM ".InformacionVentasActual::tableName()." WHERE (idComercial,idAgrupacion,mes) IN (".implode(",", $this->arrConsulta['delete']).") AND fechaRegistro<'$this->fecha' ";
  			\Yii::$app->db->createCommand($sqlDelete)->execute();
  			$transaction->commit();
  			$registros = count($this->arrConsulta['insert']);
  			$this->arrConsulta = [];
  			$this->cargado = false;
  			$this->fecha = null;
  			return $registros;
  		}catch (\Exception $exc){
  			$transaction->rollBack();
  			throw new \Exception($exc->getMessage() . " - " . $exc->getCode() . " -",310);
  		}
  	}else{
  		throw new \Exception("Archivo no procesado",201);
  	}
  }


}
