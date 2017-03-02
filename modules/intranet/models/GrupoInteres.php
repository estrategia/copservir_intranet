<?php

namespace app\modules\intranet\models;

use Yii;
use app\modules\intranet\models\GrupoInteresCargo;
use yii\web\UploadedFile;


/**
* This is the model class for table "m_GrupoInteres".
*
* @property string $idGrupoInteres
* @property string $nombreGrupo
*/
class GrupoInteres extends \yii\db\ActiveRecord
{
  const ESTADO_ACTIVO = 1;
  const ESTADO_INACTIVO = 0;

  public static function tableName()
  {
    return 'm_GrupoInteres';
  }

  public function rules()
  {
    return [
      [['nombreGrupo', 'estado'], 'required'],
      [['nombreGrupo','imagenGrupo'], 'string', 'max' => 45],
      [['imagenGrupo'], 'file', 'extensions' => 'jpg, png, jpeg'],
      [['idGrupoInteresPadre'], 'integer']
    ];
  }

  public function attributeLabels()
  {
    return [
      'idGrupoInteres' => 'Id Grupo Interes',
      'nombreGrupo' => 'Nombre Grupo',
      'imagenGrupo' => 'Imagen Grupo',
      'estado' => 'Estado',
      'idGrupoInteresPadre' => 'Grupo padre'
    ];
  }

  // RELACIONES

  public function getObjGrupoInteresCargo(){
    return $this->hasMany(GrupoInteresCargo::className(), ['idGrupoInteres' => 'idGrupoInteres']);
  }

  public function getGruposHijos()
  {
    return $this->hasMany(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteresPadre']);
  }

  public function getPadre()
  {
    return $this->hasOne(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteresPadre']);
  }

  public static function getNombresGruposPadres()
  {
    $gruposPadres = self::find()
      ->where(['idGrupoInteresPadre' => null])
      ->andWhere(['!=', 'estado', '0'])
      ->all();
    $nombresPadres = [];
    foreach ($gruposPadres as $grupo) {
      $nombresPadres[$grupo->idGrupoInteres] = $grupo->nombreGrupo;
    }
    return $nombresPadres;
  }

  // FUNCIONES

  public function getImagen(){
    return Yii::$app->homeUrl . 'img/gruposInteres/' .$this->imagenGrupo;
  }


  public function asignarImagenGrupo()
  {
  	$file = UploadedFile::getInstance($this, 'imagenGrupo');
  	 
  	if (!empty($file)) {
  		$file->saveAs('img/gruposInteres/' . $file->baseName . '.' . $file->extension);
  		$this->imagenGrupo = $file->baseName . '.' . $file->extension;
  	}
  }

}
