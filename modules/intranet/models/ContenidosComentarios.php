<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
* This is the model class for table "t_contenidoscomentarios".
*
* @property string $idContenidoComentario
* @property string $titulo
* @property string $contenido
* @property string $numeroDocumento
* @property string $fechaComentario
* @property string $fechaActualizacion
* @property integer $estado
* @property string $idContenido
*/
class ContenidosComentarios extends \yii\db\ActiveRecord
{
  const ESTADO_ELIMINADO = 0;
  const ESTADO_ACTIVO = 1;
  const ESTADO_DENUNCIADO = 2;

  public static function tableName()
  {
    return 't_ContenidosComentarios';
  }

  public function rules()
  {
    return [
      [['contenido', 'numeroDocumento', 'fechaComentario', 'idContenido'], 'required'],
      [['contenido'], 'string'],
      [['numeroDocumento', 'estado', 'idContenido'], 'integer'],
      [['fechaComentario', 'fechaActualizacion'], 'safe'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'idContenidoComentario' => 'Id Contenido Comentario',
      'contenido' => 'Contenido',
      'numeroDocumento' => 'Usuario Comentario',
      'fechaComentario' => 'Fecha Comentario',
      'fechaActualizacion' => 'Fecha Actualizacion',
      'estado' => 'Estado',
      'idContenido' => 'Id Contenido',
    ];
  }


  // RELACIONES

  public function getObjUsuarioPublicacionComentario()
  {
    return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
  }

  public function getObjDenuncioComentarioUsuario()
  {
    return $this->hasOne(DenunciosContenidosComentarios::className(), ['idContenidoComentario' => 'idContenidoComentario'])->andOnCondition(['numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
  }

  public function getObjDenuncioComentario()
  {
    return $this->hasOne(DenunciosContenidosComentarios::className(), ['idContenidoComentario' => 'idContenidoComentario']);
  }

  public function getObjContenido()
  {
    return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenido']);
  }
  /*
  * CONSULTAS
  */

  /**
  * Consulta todos los modelos ContenidosComentarios que han sido denunciados
  * @param none
  * @return dataProvider modelo ContenidosComentarios
  */
  public static function getComentariosDenunciadosPendientes()
  {
    $query = self::find()->joinWith(['objDenuncioComentario'])
    ->where("(   t_DenunciosContenidosComentarios.estado =:estado )")
    ->orderBy('fechaRegistro asc')
    ->with(['objContenido', 'objDenuncioComentario'])
    ->addParams([':estado' => DenunciosContenidosComentarios::PENDIENTE_APROBACION ]);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    return $dataProvider;

  }

  /**
  * Consulta un modelo DenunciosContenidosComentarios
  * @param none
  * @return dataProvider modelo DenunciosContenidosComentarios
  */
  public static function getComentarioDenunciadoDetalle($id)
  {

    $query = self::find()->joinWith(['objDenuncioComentario'])
    ->where("(   t_DenunciosContenidosComentarios.estado =:estado and t_ContenidosComentarios.idContenidocomentario =:id )")
    ->addParams([':estado' => DenunciosContenidosComentarios::PENDIENTE_APROBACION, ':id' => $id ])
    ->with(['objUsuarioPublicacionComentario',
    'objDenuncioComentario' => function($q) {
      $q->with('objUsuario');
    },
    'objContenido'])->one();

    return $query;
  }

  //FUNCIONES

  public function saveEstadoEliminado()
  {
    $this->estado = ContenidosComentarios::ESTADO_ELIMINADO;
    $this->fechaActualizacion = Date("Y-m-d H:i:s");

    if (!$this->save()) {
      throw new Exception("Error al guardar comentario:".yii\helpers\Json::encode($this->getErrors()), 101);
    }
  }
}
