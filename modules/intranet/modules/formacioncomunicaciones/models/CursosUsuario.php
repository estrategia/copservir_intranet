<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "t_FORCO_CursosUsuario".
 *
 * @property integer $idCurso
 * @property string $numeroDocumento
 * @property string $fechaCreacion
 * @property string $fechaInicioLectura
 *
 * @property MFORCOCurso $idCurso0
 * @property MUsuario $numeroDocumento0
 */
class CursosUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_CursosUsuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCurso', 'numeroDocumento'], 'required'],
            [['idCurso', 'numeroDocumento'], 'integer'],
            [['fechaCreacion', 'fechaInicioLectura'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCurso' => 'Id Curso',
            'numeroDocumento' => 'Numero Documento',
            'fechaCreacion' => 'Fecha de Finalizacion',
            'fechaInicioLectura' => 'Fecha Inicio Lectura',
        ];
    }

    public function getUsuario()
    {
        return $this->hasOne(\app\models\Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    public function getUsuarioIntranet()
    {
        return $this->hasOne(\app\modules\intranet\models\UsuarioIntranet::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['idCurso' => 'idCurso']);
    }

}
