<?php

namespace app\modules\proveedores\models;

use Yii;
use yii\db\Query;
use yii\db\Command;
use yii\helpers\VarDumper;

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
class UsuarioProveedor extends \yii\db\ActiveRecord
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
            [['numeroDocumento', 'nombre', 'primerApellido', 'nitLaboratorio', 'email', 'celular'], 'required'],
            [['numeroDocumento'], 'integer', 'min' => 5, 'max' => 999999999999],
            [['telefono', 'celular'], 'integer', 'min' => 5, 'max' => 9999999999],
            [['fechaNacimiento'], 'safe'],
            [['nombre', 'primerApellido', 'segundoApellido', 'nitLaboratorio', 'Ciudad', 'Direccion'], 'string', 'max' => 45, 'min' => 3],
        	[['email'], 'email'],
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
            'idProfesion' => 'Profesion',
        ];
    }

    public static function getProveedores($laboratorio)
    {
        $connection = \Yii::$app->db;
        $model = $connection->createCommand(
            'SELECT * FROM intranet.m_prov_usuario t1
            LEFT OUTER JOIN intranet.m_usuario t2
            ON t1.numeroDocumento = t2.numeroDocumento
            LEFT OUTER JOIN intranet.auth_assignment t3
            ON t1.numeroDocumento = t3.user_id
            WHERE t2.estado = 1 AND t1.nitLaboratorio = "' . $laboratorio . '" AND t3.item_name = "visitaMedica_proveedor"'
        );
        $proveedores = $model->queryAll();
        return $proveedores;
    }

    // Retorna la lista de permisos paara asignar a los usuarios
    public function getPermisosAsignacion()
    {
        $permisos = [
            'Modulo proveedores' => 'proveedores_usuario',
            'Modulo visita medica' => 'visitaMedica_proveedor',
        ];
        return $permisos;
    }

    // Retorna los roles que no tiene el usuario para ser eliminados
    public function permisosFaltantes($arr1, $arr2)
    {   
        $valores1 = array_values($arr1);
        $valores2 = array_values($arr2);

        $valores1Trimmed=array_map('trim',$valores1);
        $valores2Trimmed=array_map('trim',$valores2);

        // VarDumper::dump($valores1,10,true);
        // VarDumper::dump($valores2,10,true);
        $diff = array_diff($valores1Trimmed, $valores2Trimmed);
        // VarDumper::dump($diff,10,true);
        return $diff;
    }

    public function asignarPermisos($permisos)
    {
        $sql = 'INSERT INTO auth_assignment (item_name, user_id) VALUES ';
        foreach ($permisos as $permiso) {
            $value = "( '{$permiso}', {$this->numeroDocumento} ),";
            $value = preg_replace('/\s+/', '', $value);
            $sql .= $value;
        }
        $sql = trim(substr($sql, 0, -1) . "ON DUPLICATE KEY UPDATE user_id = user_id;");
        $connection = \Yii::$app->db;
        Yii::$app->db->createCommand($sql)->execute();
    }

    public function removerPermisos($permisos)
    {   
        if(!empty($permisos)) {
            $sql = 'DELETE FROM auth_assignment WHERE (item_name, user_id) IN (';
            foreach ($permisos as $permiso) {
                $value = "( '{$permiso}', {$this->numeroDocumento} ),";
                $value = preg_replace('/\s+/', '', $value);
                $sql .= $value;
            }
            $sql = trim(substr($sql, 0, -1) . ");");
            $connection = \Yii::$app->db;
            Yii::$app->db->createCommand($sql)->execute();
        }
    }

    public function getPermisosAsignados()
    {
        $sql = "SELECT * FROM auth_assignment WHERE user_id= {$this->numeroDocumento};";
        $connection = \Yii::$app->db;
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public function getObjUsuario()
    {
        return $this->hasOne(\app\models\Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    public static function getCorreosAdmin()
    {
        $sql = "SELECT correoElectronico 
                FROM m_INTRA_Usuario
                INNER JOIN auth_assignment
                ON m_INTRA_Usuario.numeroDocumento = auth_assignment.user_id
                WHERE auth_assignment.item_name = " . '"intranet_admin"';
        $connection = \Yii::$app->db;
        $model = $connection->createCommand($sql);
        $correos = $model->queryAll();
        return $correos;
    }

}
