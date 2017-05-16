<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "t_FORCO_RestriccionesRedencion".
 *
 * @property string $numeroDocumento
 * @property string $fechaCreacion
 */
class RestriccionesRedencion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_RestriccionesRedencion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento'], 'required'],
            [['numeroDocumento'], 'integer'],
            [['fechaCreacion'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numeroDocumento' => 'Numero Documento',
            'fechaCreacion' => 'Fecha Creacion',
        ];
    }

    public function getObjUsuario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    public function getObjUsuarioIntranet()
    {
        return $this->hasOne(\app\modules\intranet\models\UsuarioIntranet::className(), ['numeroDocumento' => 'numeroDocumento']);
    }
}
