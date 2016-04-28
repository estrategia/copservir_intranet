<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_cumpleanospersona".
 *
 * @property integer $idCumpleanosPersona
 * @property integer $numeroDocumento
 * @property string $nombre
 * @property string $idCargo
 * @property string $fecha
 * @property integer $codigoCiudad
 */
class CumpleanosPersona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_CumpleanosPersona';
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
            'idCumpleanosPersona' => 'Id Cumpleanos Persona',
            'numeroDocumento' => 'Numero Documento',
            'nombre' => 'Nombre',
            'idCargo' => 'Id Cargo',
            'fecha' => 'Fecha',
            'codigoCiudad' => 'Id Ciudad',
        ];
    }

    /**
     * Se define la relacion entre los modelos CumpleanosLaboral y User
     * @return \yii\db\ActiveQuery modelo User
     */
    public function getObjUsuario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    /**
     * Se define la relacion entre los modelos CumpleanosLaboral y GrupoInteresCargo
     * @return \yii\db\ActiveQuery modelo GrupoInteresCargo
     */
    public function getObjGrupoInteresCargo()
    {
        return $this->hasMany(GrupoInteresCargo::className(), ['idCargo' => 'idCargo']);
    }

    /**
    * consulta los modelos CumpleanosPersona que van en el index
    * @param $userCiudad = ciudad donde se encuentra el usuario, $userGrupos = grupos de interes del usuario
    * @return array modelo CumpleanosLaboral
    */
    public static function getCumpleanosIndex($userCiudad, $userGrupos)
    {
      $fecha = new \DateTime;
      $fecha->modify('-5 days');
      $userGrupos = implode(',',$userGrupos);

      $todosCiudad = \Yii::$app->params['ciudad']['*'];
      $todosGrupo = \Yii::$app->params['grupo']['*'];

      return self::find()->joinWith(['objGrupoInteresCargo'])->with(['objUsuario'])
      ->where("( t_CumpleanosPersona.fecha>=:fecha AND ( (t_CumpleanosPersona.codigoCiudad =:codigoCiudad AND m_GrupoInteresCargo.idGrupoInteres IN ($userGrupos)) OR (t_CumpleanosPersona.codigoCiudad =:codigoCiudad AND m_GrupoInteresCargo.idGrupoInteres=:todosGrupo) OR (t_CumpleanosPersona.codigoCiudad =:todosCiudad AND m_GrupoInteresCargo.idGrupoInteres IN ($userGrupos)) OR (t_CumpleanosPersona.codigoCiudad =:todosCiudad AND m_GrupoInteresCargo.idGrupoInteres =:todosGrupo) )   )")
      ->addParams([':fecha' => $fecha->format('Y-m-d H:i:s'), ':codigoCiudad'=> $userCiudad, ':todosCiudad'=>$todosCiudad, ':todosGrupo'=> $todosGrupo])
      ->orderBy('t_CumpleanosPersona.fecha asc')
      ->all();
    }


    /**
    * consulta todos los modelos CumpleanosPersona a partir de 5 dias atras de la fecha actual
    * @param
    * @return array modelo CumpleanosLaboral
    */
    public static function getCumpleanosVerTodos(){

      $fecha = new \DateTime;
      $fecha->modify('-5 days');
      return self::find()->joinWith(['objGrupoInteresCargo'])->with(['objUsuario'])
      ->where("( t_CumpleanosPersona.fecha>=:fecha  )")
      ->addParams([':fecha' => $fecha->format('Y-m-d H:i:s')])
      ->orderBy('t_CumpleanosPersona.fecha asc')
      ->all();
    }
}
