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
class CapituloContenido extends \yii\db\ActiveRecord
{
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
            [['nombreCapitulo', 'descripcionCapitulo', 'fechaCreacion'], 'required'],
            [['estadoCapitulo'], 'integer'],
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
            'idCapitulo' => 'Id Capitulo',
            'nombreCapitulo' => 'Nombre Capitulo',
            'descripcionCapitulo' => 'Descripcion Capitulo',
            'estadoCapitulo' => 'Estado Capitulo',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }
}
