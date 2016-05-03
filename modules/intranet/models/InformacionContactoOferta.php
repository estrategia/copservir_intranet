<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_informacioncontactooferta".
*
* @property string $idInformacionContacto
* @property string $plantillaContactoHtml
* @property integer $estado
* @property string $fechaRegistro
* @property integer $numeroDocumento
* @property string $nombrePlantilla
* @property integer $numeroDocumentoContacto
*
* @property Ofertaslaborales[] $listOfertaslaborales
*/
class InformacionContactoOferta extends \yii\db\ActiveRecord
{
  /**
  * @inheritdoc
  */
  const PLANTILLA_ACTIVA = 1;
  const PLANTILLA_INACTIVA = 0;

  public static function tableName()
  {
    return 't_InformacionContactoOferta';
  }

  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [['plantillaContactoHtml', 'estado', 'nombrePlantilla', 'numeroDocumentoContacto'], 'required'],
      [['plantillaContactoHtml'], 'string'],
      [['estado', 'numeroDocumento', 'numeroDocumentoContacto'], 'integer'],
      [['fechaRegistro'], 'safe'],
      [['nombrePlantilla'], 'string', 'max' => 45],
    ];
  }

  /**
  * @inheritdoc
  */
  public function attributeLabels()
  {
    return [
      'idInformacionContacto' => 'Id Informacion Contacto',
      'plantillaContactoHtml' => 'Plantilla Contacto Html',
      'estado' => 'Estado',
      'fechaRegistro' => 'Fecha Registro',
      'numeroDocumento' => 'Numero Documento',
      'nombrePlantilla' => 'Nombre Plantilla',
      'numeroDocumentoContacto' => 'Numero Documento Contacto',
    ];
  }

  /*
  * RELACIONES
  */

  /**
  * se defina la relacion entre el modelo InformacionContactoOferta y OfertasLaborales
  */
  public function getListOfertaslaborales()
  {
    return $this->hasMany(OfertasLaborales::className(), ['idInformacionContacto' => 'idInformacionContacto']);
  }
}
