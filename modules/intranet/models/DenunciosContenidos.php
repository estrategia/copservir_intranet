<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_DenunciosContenidos".
 *
 * @property string $idDenuncioContenido
 * @property string $idContenido
 * @property string $descripcionDenuncio
 * @property string $numeroDocumento
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
            [['idContenido', 'descripcionDenuncio', 'numeroDocumento', 'fechaRegistro'], 'required'],
            [['idContenido', 'numeroDocumento'], 'integer'],
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
            'numeroDocumento' => 'Usuario Denunciante',
            'fechaRegistro' => 'Fecha Registro',
        ];
    }
}
