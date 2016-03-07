<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_usuario".
 *
 * @property string $idUsuario
 * @property string $numeroDocumento
 * @property string $alias
 * @property string $idPerfil
 * @property integer $estado
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'alias', 'idPerfil', 'estado'], 'required'],
            [['numeroDocumento', 'idPerfil', 'estado'], 'integer'],
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
            'idPerfil' => 'Id Perfil',
            'estado' => 'Estado',
            'imagenPerfil' => 'Imagen Perfil',
        ];
    }

}
