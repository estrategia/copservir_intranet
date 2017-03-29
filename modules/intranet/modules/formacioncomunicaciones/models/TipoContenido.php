<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "m_FORCO_TipoContenido".
 *
 * @property integer $idTipoContenido
 * @property string $nombreTipoContenido
 * @property integer $estadoTipoContenido
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 */
class TipoContenido extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_TipoContenido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreTipoContenido', 'estadoTipoContenido'], 'required'],
            [['estadoTipoContenido'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion'], 'safe'],
            [['nombreTipoContenido'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idTipoContenido' => 'Id Tipo Contenido',
            'nombreTipoContenido' => 'Nombre Tipo Contenido',
            'estadoTipoContenido' => 'Estado',
            'fechaCreacion' => 'Fecha Creación',
            'fechaActualizacion' => 'Fecha Actualización',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->fechaCreacion = date("Y-m-d H:i:s");
            } 
            return true;
        } else {
            return false;
        }
    }

    public function getCursos()
    {
        return $this->hasMany(Curso::className(), ['idTipoContenido' => 'idTipoContenido']);
    }
}
