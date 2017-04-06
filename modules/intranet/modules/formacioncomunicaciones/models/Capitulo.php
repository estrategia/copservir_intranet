<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "m_FORCO_Capitulo".
 *
 * @property integer $idCapitulo
 * @property string $nombreCapitulo
 * @property string $descripcionCapitulo
 * @property integer $estadoCapitulo
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 */
class Capitulo extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_Capitulo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreCapitulo', 'descripcionCapitulo', 'estadoCapitulo', 'idModulo'], 'required'],
            [['estadoCapitulo', 'idModulo'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion'], 'safe'],
            [['nombreCapitulo'], 'string', 'max' => 45],
            [['descripcionCapitulo'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCapitulo' => 'Id Capítulo',
            'nombreCapitulo' => 'Nombre',
            'descripcionCapitulo' => 'Descripción',
            'estadoCapitulo' => 'Estado',
            'idModulo' => 'Id Modulo',
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

    public function getModulo()
    {
        return $this->hasOne(Modulo::className(), ['idModulo' => 'idModulo']);
    }

    public function getContenidos()
    {
        return $this->hasMany(Contenido::className(), ['idCapitulo' => 'idCapitulo']);
    }

    public function getContenidosActivos()
    {
        return $this->hasMany(Contenido::className(), ['idCapitulo' => 'idCapitulo'])->andWhere(['estadoContenido' => Contenido::ESTADO_ACTIVO])->all();
    }
}
