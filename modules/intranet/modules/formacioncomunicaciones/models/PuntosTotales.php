<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use app\models\Usuario;

/**
 * This is the model class for table "t_FORCO_PuntosTotales".
 *
 * @property string $numeroDocumento
 * @property string $puntos
 * @property string $fechaActualizacion
 *
 * @property MUsuario $numeroDocumento0
 */
class PuntosTotales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_PuntosTotales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'puntos'], 'required'],
            [['numeroDocumento', 'puntos'], 'integer'],
            [['fechaActualizacion'], 'safe'],
            [['numeroDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['numeroDocumento' => 'numeroDocumento']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numeroDocumento' => 'Numero Documento',
            'puntos' => 'Puntos',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjUsuario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }
}
