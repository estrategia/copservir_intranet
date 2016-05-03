<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_cumpleanoslaboral".
*
* @property integer $idCumpleanosLaboral
* @property integer $numeroDocumento
* @property string $nombre
* @property string $idCargo
* @property string $fecha
* @property integer $codigoCiudad
*/
class CumpleanosLaboral extends \yii\db\ActiveRecord
{
  /**
  * @inheritdoc
  */
  public static function tableName()
  {
    return 't_CumpleanosLaboral';
  }

  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [['numeroDocumento', 'nombre', 'idCargo', 'fecha', 'codigoCiudad'], 'required'],
      [['numeroDocumento', 'codigoCiudad'], 'integer'],
      [['fecha'], 'safe'],
      [['nombre', 'idCargo'], 'string', 'max' => 255],
    ];
  }

  /**
  * @inheritdoc
  */
  public function attributeLabels()
  {
    return [
      'idCumpleanosLaboral' => 'Id Cumpleanos Laboral',
      'numeroDocumento' => 'Numero Documento',
      'nombre' => 'Nombre',
      'idCargo' => 'Id Cargo',
      'fecha' => 'Fecha',
      'codigoCiudad' => 'Id Ciudad',
    ];
  }

  /*
  * RELACIONES
  */

  /**
  * Se define la relacion entre los modelos CumpleanosPersona y User
  * @return \yii\db\ActiveQuery modelo User
  */
  public function getObjUsuario()
  {
    return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
  }

  /**
  * Se define la relacion entre los modelos CumpleanosPersona y GrupoInteresCargo
  * @return \yii\db\ActiveQuery modelo GrupoInteresCargo
  */
  public function getObjGrupoInteresCargo()
  {
    return $this->hasMany(GrupoInteresCargo::className(), ['idCargo' => 'idCargo']);
  }

  /*
  * CONSULTAS
  */

  /**
  * consulta los modelos CumpleanosLaboral que van en el index
  * @param $userCiudad = ciudad donde se encuentra el usuario, $userGrupos = grupos de interes del usuario
  * @return array modelo CumpleanosPersona
  */
  public static function getAniversariosIndex($userCiudad, $userGrupos)
  {
    $fecha = Date("Y-m-d H:i:s");
    $userGrupos = implode(',',$userGrupos);
    $todosCiudad = \Yii::$app->params['ciudad']['*'];
    $todosGrupo = \Yii::$app->params['grupo']['*'];

    $query =  self::find()->joinWith(['objGrupoInteresCargo'])->with(['objUsuario'])
    ->where("( t_CumpleanosLaboral.fecha>=:fecha AND ( (t_CumpleanosLaboral.codigoCiudad =:codigoCiudad AND m_GrupoInteresCargo.idGrupoInteres IN ($userGrupos)) OR (t_CumpleanosLaboral.codigoCiudad =:codigoCiudad AND m_GrupoInteresCargo.idCargo=:todosGrupo) OR (t_CumpleanosLaboral.codigoCiudad =:todosCiudad AND m_GrupoInteresCargo.idGrupoInteres IN ($userGrupos)) OR (t_CumpleanosLaboral.codigoCiudad =:todosCiudad AND m_GrupoInteresCargo.idCargo =:todosGrupo) )   )")
    ->addParams([':fecha' => $fecha, ':codigoCiudad'=> $userCiudad, ':todosCiudad'=>$todosCiudad, ':todosGrupo'=> $todosGrupo])
    ->orderBy('t_CumpleanosLaboral.fecha asc')
    ->all();

    //var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
    return $query;
  }

  /**
  * consulta todos los modelos CumpleanosLaboral a partir de 5 dias atras de la fecha actual
  * @param
  * @return array modelo CumpleanosLaboral
  */
  public static function getAniversariosVerTodos(){

    $fecha = new \DateTime;
    $fecha->modify('-5 days');
    return self::find()->joinWith(['objGrupoInteresCargo'])->with(['objUsuario'])
    ->where("( t_CumpleanosLaboral.fecha>=:fecha  )")
    ->addParams([':fecha' => $fecha->format('Y-m-d H:i:s')])
    ->orderBy('t_CumpleanosLaboral.fecha asc')
    ->all();
  }
}
