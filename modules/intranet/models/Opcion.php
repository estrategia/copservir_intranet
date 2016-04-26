<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_Opcion".
 *
 * @property string $idOpcion
 * @property string $nombrePermiso
 * @property string $url
 * @property integer $estado
 * @property string $idMenu
 */
class Opcion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_Opcion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombrePermiso', 'url', 'estado', 'idMenu'], 'required'],
            [['estado', 'idMenu'], 'integer'],
            [['nombrePermiso'], 'string', 'max' => 45],
            [['url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idOpcion' => 'Id Opcion',
            'nombrePermiso' => 'Nombre Permiso',
            'url' => 'Url',
            'estado' => 'Estado',
            'idMenu' => 'Id Menu',
        ];
    }
}
