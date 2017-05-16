<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "m_FORCO_ParametrosPuntos".
 *
 * @property integer $idParametroPunto
 * @property integer $tipoParametro
 * @property integer $valorPuntos
 * @property integer $idTipoContenido
 * @property integer $condicion
 * @property integer $estado
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 *
 * @property MFORCOTipoContenido $idTipoContenido0
 * @property TFORCOPuntos[] $tFORCOPuntos
 */
class ParametrosPuntos extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    const PARAMETRO_TIPO_CONTENIDO = 1;
    const PARAMETRO_CUMPLEANIOS = 2;
    const PARAMETRO_ANIVERSARIO = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_ParametrosPuntos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipoParametro', 'valorPuntos'], 'required'],
            [['tipoParametro', 'valorPuntos', 'idTipoContenido', 'condicion', 'estado'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idParametroPunto' => 'Id Parametro Punto',
            'tipoParametro' => 'Tipo Parametro',
            'valorPuntos' => 'Valor Puntos',
            'idTipoContenido' => 'Tipo Contenido',
            'condicion' => 'Cantidad de años',
            'estado' => 'Estado',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoContenido0()
    {
        return $this->hasOne(MFORCOTipoContenido::className(), ['idTipoContenido' => 'idTipoContenido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTFORCOPuntos()
    {
        return $this->hasMany(TFORCOPuntos::className(), ['idParametroPunto' => 'idParametroPunto']);
    }

    public function getObjTipoContenido()
    {
        return $this->hasOne(TipoContenido::className(), ['idTipoContenido' => 'idTipoContenido']);
    }
}
