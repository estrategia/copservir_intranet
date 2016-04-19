<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_contenidoemergente".
 *
 * @property string $idContenidoEmergente
 * @property string $contenido
 * @property string $fechaInicio
 * @property string $fechaFin
 * @property integer $estado
 * @property string $fechaRegistro
 *
 * @property TContenidoemergentedestino[] $tContenidoemergentedestinos
 * @property TContenidoemergentevisto[] $tContenidoemergentevistos
 */
class ContenidoEmergente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     // estados del modelo ContenidoEmergente
     const ESTADO_ACTIVO = 1;
     const ESTADO_INACTIVO = 0;

    public static function tableName()
    {
        return 'm_contenidoemergente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contenido', 'fechaInicio', 'fechaFin', 'fechaRegistro'], 'required'],
            [['contenido'], 'string'],
            [['fechaInicio', 'fechaFin', 'fechaRegistro'], 'safe'],
            [['estado'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idContenidoEmergente' => 'Id Contenido Emergente',
            'contenido' => 'Contenido',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin',
            'estado' => 'Estado',
            'fechaRegistro' => 'Fecha Registro',
        ];
    }

    /**
     * relacion entre los modelos ContenidoEmergente y ContenidoEmergenteDestino
     * @return \yii\db\ActiveQuery modelo ContenidoEmergenteDestino
     */
    public function getObjContenidoEmergenteDestinos()
    {
        return $this->hasMany(ContenidoEmergenteDestino::className(), ['idContenidoEmergente' => 'idContenidoEmergente']);
    }

    /**
     * relacion entre los modelos ContenidoEmergente y ContenidoEmegenteVisto
     * @return \yii\db\ActiveQuery modelo ContenidoEmegenteVisto
     */
    public function getTContenidoemergentevistos()
    {
        return $this->hasMany(ContenidoEmergenteVisto::className(), ['idContenidoEmergente' => 'idContenidoEmergente']);
    }

    /**
     * consulta dem anera aleatoria los modelos ContenidoEmergente dependiendo de la ciudad, grupos de interes del usuario
     * @param userCiudad = ciudad donde se encuentra el usuario, userGrupos = grupos de interes del usuario,
     * @return modelos ContenidoEmergente
     */
    public static function getContenidoEmergente($userCiudad, $userGrupos, $userNumeroDocumento)
    {
      $db = Yii::$app->db;
      $query = $db->createCommand('select distinct c.idContenidoEmergente, c.contenido
                                   from  m_ContenidoEmergente as c
                                   inner join t_ContenidoEmergenteDestino as cd on c.idContenidoEmergente = cd.idContenidoEmergente
                                   where (c.fechaInicio<=:fecha AND c.fechaFin >=:fecha AND c.estado =:estado and
                                   ((cd.idGrupoInteres IN(:userGrupos) and cd.codigoCiudad =:userCiudad) or (cd.idGrupoInteres =:todosGrupos and cd.codigoCiudad =:todosCiudad) or (cd.idGrupoInteres IN(:userGrupos) and cd.codigoCiudad =:todosCiudad) or (cd.idGrupoInteres =:todosGrupos and cd.codigoCiudad =:userCiudad)  )   )
                                   and c.idContenidoEmergente NOT IN( select idContenidoEmergente from t_ContenidoEmergenteVisto where numeroDocumento =' . $userNumeroDocumento . ' )  order by rand()')
             ->bindValue(':userCiudad', $userCiudad)
             ->bindValue(':userGrupos', implode(',', $userGrupos))
             ->bindValue(':fecha', date('Y-m-d H:i:s'))
             ->bindValue(':estado', self::ESTADO_ACTIVO)
             ->bindValue('todosCiudad', \Yii::$app->params['ciudad']['*'])
             ->bindValue('todosGrupos', \Yii::$app->params['grupo']['*'])
             ->queryOne();

      return $query;
    }
}
