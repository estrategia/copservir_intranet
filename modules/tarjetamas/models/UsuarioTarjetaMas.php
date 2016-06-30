<?php

namespace app\modules\tarjetamas\models;

use Yii;
use app\models\Usuario;
use app\modules\intranet\models\Ciudad;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "m_usuariotarjetamas".
 *
 * @property string $numeroDocumento
 * @property string $nombres
 * @property string $primerApellido
 * @property string $segundoApellido
 * @property integer $celular
 * @property string $correo
 * @property integer $telefonoFijo
 * @property integer $codigoCiudad
 *
 * @property Ciudad $codigoCiudad
 * @property Usuario $numeroDocumento
 */
class UsuarioTarjetaMas extends \yii\db\ActiveRecord
{
    public $password;

    public static function tableName()
    {
        return 'm_UsuarioTarjetaMas';
    }

    public function rules()
    {
        return [
            [['numeroDocumento', 'nombres', 'primerApellido', 'correo', 'codigoCiudad'], 'required'],
            [['numeroDocumento', 'celular', 'telefonoFijo', 'codigoCiudad'], 'integer'],
            [['nombres', 'primerApellido', 'segundoApellido'], 'string', 'max' => 45],
            [['correo'], 'string', 'max' => 100],
            [['codigoCiudad'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['codigoCiudad' => 'codigoCiudad']],
            [['numeroDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['numeroDocumento' => 'numeroDocumento']],
            [['password'], 'string', 'min' => 6],
            [['password'], 'required', 'on' =>  ['registroDatos']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'numeroDocumento' => 'Numero Documento',
            'nombres' => 'Nombres',
            'primerApellido' => 'Primer Apellido',
            'segundoApellido' => 'Segundo Apellido',
            'celular' => 'Celular',
            'correo' => 'Correo',
            'telefonoFijo' => 'Telefono Fijo',
            'codigoCiudad' => 'Ciudad',
            'password' => 'Contraseña',
        ];
    }

    public function getCodigoCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['codigoCiudad' => 'codigoCiudad']);
    }

    public function getNumeroDocumento()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    /**
    * consulta todos los objetos del modelo Ciudad
    * @param
    * @return retorna todos los modelos Cargo mapeados por idCiudad y nombreCiudad
    */
    public function getListaCiudad()
    {
      $opciones = Ciudad::find()->asArray()->all();
      return ArrayHelper::map($opciones, 'idCiudad', 'nombreCiudad');
    }
}
