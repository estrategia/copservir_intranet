<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_intra_usuario".
 *
 * @property string $numeroDocumento
 * @property string $nombres
 * @property string $primerApellido
 * @property string $segundoApellido
 * @property string $idCargo
 * @property string $nombreCargo
 */
class UsuarioIntranet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_intra_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento'], 'required'],
            [['numeroDocumento'], 'integer'],
            [['nombres', 'primerApellido', 'segundoApellido', 'idCargo', 'nombreCargo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numeroDocumento' => 'Numero Documento',
            'nombres' => 'Nombres',
            'primerApellido' => 'Primer Apellido',
            'segundoApellido' => 'Segundo Apellido',
            'idCargo' => 'Id Cargo',
            'nombreCargo' => 'Nombre Cargo',
        ];
    }
}
