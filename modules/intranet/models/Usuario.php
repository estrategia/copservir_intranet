<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_usuario".
 *
 * @property string $idUsuario
 * @property string $numeroDocumento
 * @property string $alias
 * @property integer $estado
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_Usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'estado'], 'required'],
            [['numeroDocumento', 'estado'], 'integer'],
            [['alias'], 'string', 'max' => 60],
            [['numeroDocumento'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idUsuario' => 'Id Usuario',
            'numeroDocumento' => 'Numero Documento',
            'alias' => 'Alias',
            'estado' => 'Estado',
            'imagenPerfil' => 'Imagen Perfil',
        ];
    }

}
