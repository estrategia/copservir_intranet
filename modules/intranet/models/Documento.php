<?php

namespace app\modules\intranet\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Json;
/**
* This is the model class for table "m_documento".
*
* @property string $idDocumento
* @property string $titulo
* @property string $descripcion
* @property string $rutaDocumento
* @property string $estado
* @property string $fechaCreacion
* @property string $fechaActualizacion
*
* @property MCategoriadocumentodetalle[] $mCategoriadocumentodetalles
* @property TLogdocumento[] $tLogdocumentos
*/
class Documento extends \yii\db\ActiveRecord
{
  /**
  * @inheritdoc
  */

  public $file;
  public $descripcionLog;
  // escenarios
  const SCENARIO_CREAR = 'crear';
  const SCENARIO_ACTUALIZAR = 'actualizar';
  // estados del documento
  const ESTADO_ACTIVO = 1;
  const ESTADO_INACTIVO = 0;


  public static function tableName()
  {
    return 'm_Documento';
  }

  /**
  * @inheritdoc
  */

  public function rules()
  {
    return [
      [['titulo', 'descripcion', 'rutaDocumento', 'estado', 'fechaCreacion', 'fechaActualizacion'], 'required'],
      [['fechaCreacion', 'fechaActualizacion'], 'safe'],
      [['titulo', 'rutaDocumento'], 'string', 'max' => 100],
      [['file'], 'file', 'on' => self::SCENARIO_ACTUALIZAR ],
      [['descripcionLog'], 'required', 'on' => self::SCENARIO_ACTUALIZAR ],
      [['descripcionLog'], 'string', 'on' => self::SCENARIO_ACTUALIZAR ],
      [['file'], 'file', 'on' => self::SCENARIO_CREAR ],
      [['file'], 'required', 'on' => self::SCENARIO_CREAR ],
      [['descripcion'], 'string', 'max' => 250],
      [['estado'], 'string', 'max' => 45],
    ];
  }

  /**
  * @inheritdoc
  */
  public function attributeLabels()
  {
    return [
      'idDocumento' => 'Id Documento',
      'titulo' => 'Titulo',
      'descripcion' => 'Descripcion',
      'rutaDocumento' => 'Ruta Documento',
      'estado' => 'Estado',
      'fechaCreacion' => 'Fecha Creacion',
      'fechaActualizacion' => 'Fecha Actualizacion',
      'file' => 'Documento',
      'descripcionLog' => 'Descripcion del cambio'
    ];
  }

  /*
  * RELACIONES
  */

  /**
  * se define la relacion entre los modelos Documento y CategoriaDocumentoDetalle
  * @return \yii\db\ActiveQuery modelo CategoriaDocumentoDetalle
  */
  public function getObjCategoriaDocumentoDetalle()
  {
    return $this->hasMany(CategoriaDocumentoDetalle::className(), ['idDocumento' => 'idDocumento']);
  }

  /**
  * Se define la relacion entre los modelos Documento y LogDocumento
  * @return \yii\db\ActiveQuery modelo LogDocumento
  */
  public function getObjLogDocumentos()
  {
    return $this->hasMany(LogDocumento::className(), ['idDocumento' => 'idDocumento']);
  }

  /*
  * CONSULTAS
  */

  /**
  * consulta todos los modelos Documento
  * @param none
  * @return \yii\db\ActiveQuery modelo Documento
  */
  public static function getTodosDocumento()
  {
    return self::find()->all();
  }


  /*
  * FUNCIONES
  */

  /**
  * funcion para crear un modelo LogDocumentos
  * si el modelo no se crea devuelve una excepcionss
  * @param
  * @return
  * @throws excepcion 101 el modelo no guardo su log
  */
  public function afterSave($inser, $changedAttributes)
  {
    $logDocumento = new LogDocumento();
    $logDocumento->idDocumento = intval($this->idDocumento);
    $this->isNewRecord ? $logDocumento->descripcion = $this->descripcionLog : $logDocumento->descripcion = 'Se crea el documento';
    $logDocumento->fechaCreacion = Date("Y-m-d H:i:s");

    if (!$logDocumento->save()) {

      throw new \Exception("Error al guardar el logDocumento:", 101);
    }
    return parent::afterSave($inser, $changedAttributes);
  }

  /**
  * asigna la ruta del documento cargado por el usuario
  */
  public function setRutaDocumento()
  {
    $this->file = UploadedFile::getInstance($this, 'file'); // si no selecciona nada pone null
    if (!is_null($this->file)) {
      $this->file->saveAs('contenidos/documentos/' . $this->file->baseName . '.' . $this->file->extension);
      $this->rutaDocumento = $this->file->baseName . '.' . $this->file->extension;
    }
  }
}
