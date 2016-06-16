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
  public static function tableName()
  {
    return 'm_GrupoInteres';
  }

  public function rules()
  {
    return [
      [['nombreGrupo'], 'required'],
      [['nombreGrupo','imagenGrupo'], 'string', 'max' => 45]
    ];
  }

  public function attributeLabels()
  {
    return [
      'idGrupoInteres' => 'Id Grupo Interes',
      'nombreGrupo' => 'Nombre Grupo',
      'imagenGrupo' => 'Imagen Grupo'
    ];
  }


  // RELACIONES

  public function getObjGrupoInteresCargo(){
    return $this->hasMany(GrupoInteresCargo::className(), ['idGrupoInteres' => 'idGrupoInteres']);
  }

  // FUNCIONES

  public function getImagen(){
    return Yii::$app->homeUrl . 'img/gruposInteres/' .$this->imagenGrupo;
  }


  public function asignarImagenGrupo()
  {
    $this->imagenGrupo = UploadedFile::getInstances($this, 'imagenGrupo');

    if ($this->imagenGrupo) {
      foreach ($this->imagenGrupo as $file) {
        $file->saveAs('img/gruposInteres/' . $file->baseName . '.' . $file->extension);
      }
      $this->imagenGrupo = $file->baseName . '.' . $file->extension;
    }
  }

}
