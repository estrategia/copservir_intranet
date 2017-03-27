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
            [['nombreCapitulo', 'descripcionCapitulo', 'estadoCapitulo'], 'required'],
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
            'idCapitulo' => 'Id Capítulo',
            'nombreCapitulo' => 'Nombre',
            'descripcionCapitulo' => 'Descripción',
            'estadoCapitulo' => 'Estado',
            'fechaCreacion' => 'Fecha Creación',
            'fechaActualizacion' => 'Fecha Actualización',
        ];
    }
}
