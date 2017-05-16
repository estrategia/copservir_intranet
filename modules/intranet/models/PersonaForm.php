<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;

class PersonaForm extends Model {

  public $Email;
  public $EmailPersonal;
  public $Nombres;
  public $PrimerApellido;
  public $SegundoApellido;
  public $Direccion;
  public $IdCiudad;
  public $FechaNacimiento;
  public $NumeroDocumento;
  public $alias;

  /**
  * @return array the validation rules.
  */
  public function rules() {
    return [

      [['Nombres','Direccion', 'FechaNacimiento', 'IdCiudad', 'alias'], 'required'],
      [['Email', 'EmailPersonal'], 'email'],
      [['IdCiudad', 'NumeroDocumento'], 'integer' ],
      [['Nombres', 'PrimerApellido', 'SegundoApellido'], 'string', 'max' => 255],
      [['Direccion'], 'string', 'min' =>8],
      [['alias'], 'string', 'min' => 4, 'max' => '60' ],
      [['FechaNacimiento'], 'safe'],
    ];
  }

  public function attributeLabels() {
    return [
      'Email' => 'Email Corporativo',
      'EmailPersonal' => 'Email Personal',
      'Nombres' => 'Nombres',
      'PrimerApellido' => 'Primer Apellido',
      'SegundoApellido' => 'Segundo Apellido',
      'Direccion' => 'Residencia',
      'IdCiudad' => 'Ciudad',
      'FechaNacimiento' => 'Fecha Nacimiento',
      'NumeroDocumento'=>'Numero Documento',
      'alias' => 'Alias',
    ];
  }

  public function setValuesUserGuest()
  {
    if (!\Yii::$app->user->isGuest) {
      $this->NumeroDocumento = \Yii::$app->user->identity->numeroDocumento;
      $this->Nombres = \Yii::$app->user->identity->getNombres();
      $this->PrimerApellido = \Yii::$app->user->identity->getPrimerApellido();
      $this->SegundoApellido = \Yii::$app->user->identity->getSegundoApellido();
      $this->FechaNacimiento = \Yii::$app->user->identity->getFechaNacimiento();
      $this->IdCiudad = \Yii::$app->user->identity->getCiudadCodigo();
      $this->Direccion = \Yii::$app->user->identity->getResidencia();
      $this->Email = \Yii::$app->user->identity->getEmail();
      $this->EmailPersonal = \Yii::$app->user->identity->getEmailPersonal();
      $this->alias = \Yii::$app->user->identity->alias;
    }

  }
  
  public function guardar(){
  	$usuario = UsuarioSearch::find()->where(['numeroDocumento' => \Yii::$app->user->identity->numeroDocumento])->one();
  	$usuario->alias = Yii::$app->request->post()['PersonaForm']['alias'];
  	
  	if ($usuario->save()) {
  		if ($this->actualizarPersonaWS()) {
  			return true;
  		}else{
  			$this->addError("alias","Error al guardar informacion de usuario");
  		}
  	}else{
  		$this->addError("alias","Error al guardar alias");
  	}
  	
  	return false;
  }
  
  /**
   * Funcion para actualizar la informacion de un usuario a traves de un web services
   * @param string $request
   * @return array['result'],
   */
  private function actualizarPersonaWS() {
  	$client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
  			"trace" => 1,
  			"exceptions" => 0,
  			'connection_timeout' => 5,
  			'cache_wsdl' => WSDL_CACHE_NONE
  	));
  	
  	try {
  		$result = $client->actualizarPersona($this->attributes);
  		return $result;
  	} catch (SoapFault $ex) {
  		Yii::error($ex->getMessage());
  	} catch (Exception $ex) {
  		Yii::error($ex->getMessage());
  	}
  	
  	return false;
  }
  

}
