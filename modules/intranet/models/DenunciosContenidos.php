<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_DenunciosContenidos".
 *
 * @property string $idDenuncioContenido
 * @property string $idContenido
 * @property string $descripcionDenuncio
 * @property string $idUsuarioDenunciante
 * @property string $fechaRegistro
 */
class DenunciosContenidos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_DenunciosContenidos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idContenido', 'descripcionDenuncio', 'idUsuarioDenunciante', 'fechaRegistro'], 'required'],
            [['idContenido', 'idUsuarioDenunciante'], 'integer'],
            [['descripcionDenuncio'], 'string'],
            [['fechaRegistro'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idDenuncioContenido' => 'Id Denuncio Contenido',
            'idContenido' => 'Id Contenido',
            'descripcionDenuncio' => 'Descripcion Denuncio',
            'idUsuarioDenunciante' => 'Id Usuario Denunciante',
            'fechaRegistro' => 'Fecha Registro',
        ];
    }
}
