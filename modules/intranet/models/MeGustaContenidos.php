<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_MeGustaContenidos".
 *
 * @property string $idMeGusta
 * @property string $idContenido
 * @property string $idUsuario
 * @property string $fechaRegistro
 */
class MeGustaContenidos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_MeGustaContenidos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idContenido', 'numeroDocumento', 'fechaRegistro'], 'required'],
            [['idContenido', 'numeroDocumento'], 'integer'],
            [['fechaRegistro'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idMeGusta' => 'Id Me Gusta',
            'idContenido' => 'Id Contenido',
            'numeroDocumento' => 'Id Usuario',
            'fechaRegistro' => 'Fecha Registro',
        ];
    }
    
    
}
