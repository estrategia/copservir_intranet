<?php

namespace app\modules\proveedores\modules\visitamedica\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "m_PROV_Usuario".
 *
 * @property string $numeroDocumento
 * @property string $nombre
 * @property string $primerApellido
 * @property string $segundoApellido
 * @property string $email
 * @property integer $telefono
 * @property integer $celular
 * @property string $nitLaboratorio
 * @property string $profesion
 * @property string $fechaNacimiento
 * @property string $Ciudad
 * @property string $Direccion
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_PROV_Usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento'], 'required'],
            [['numeroDocumento'], 'integer', 'min' => 5, 'max' => 999999999999],
            [['telefono', 'celular'], 'integer', 'min' => 5, 'max' => 9999999999],
            [['fechaNacimiento'], 'safe'],
            [['nombre', 'primerApellido', 'segundoApellido', 'nitLaboratorio', 'profesion', 'Ciudad', 'Direccion'], 'string', 'max' => 45, 'min' => 3],
            [['email'], 'string', 'max' => 256],
            [['numeroDocumento'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numeroDocumento' => 'Numero Documento',
            'nombre' => 'Nombre',
            'primerApellido' => 'Primer Apellido',
            'segundoApellido' => 'Segundo Apellido',
            'email' => 'Email',
            'telefono' => 'Telefono',
            'celular' => 'Celular',
            'nitLaboratorio' => 'Nit Laboratorio',
            'profesion' => 'Profesion',
            'fechaNacimiento' => 'Fecha Nacimiento',
            'Ciudad' => 'Ciudad',
            'Direccion' => 'Direccion',
        ];
    }

    public static function getProveedores($laboratorio)
    {
        $connection = \Yii::$app->db;
        $model = $connection->createCommand(
            'SELECT * FROM intranet.m_PROV_Usuario t1
            LEFT OUTER JOIN intranet.m_usuario t2
            ON t1.numeroDocumento = t2.numeroDocumento
            LEFT OUTER JOIN intranet.auth_assignment t3
            ON t1.numeroDocumento = t3.user_id
            WHERE t2.estado = 1 AND t1.nitLaboratorio = "' . $laboratorio . '" AND t3.item_name = "visitaMedica_proveedor"'
        );
        $proveedores = $model->queryAll();
        return $proveedores;
    }

}
