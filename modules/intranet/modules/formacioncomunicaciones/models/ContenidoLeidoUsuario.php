<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "t_FORCO_ContenidoLeidoUsuario".
 *
 * @property string $numeroDocumento
 * @property integer $idContenido
 * @property string $fechaCreacion
 *
 * @property MUsuario $numeroDocumento0
 * @property MFORCOContenido $idContenido0
 */
class ContenidoLeidoUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_ContenidoLeidoUsuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'idContenido', 'idCurso'], 'required'],
            [['numeroDocumento', 'idContenido', 'idCurso'], 'integer'],
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
            'idContenido' => 'Id Contenido',
            'fechaCreacion' => 'Fecha Creacion',
            'idCurso' => 'Id Curso'
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->fechaCreacion = date("Y-m-d H:i:s");
            } 
            return true;
        } else {
            return false;
        }
    }

    public function getContenido()
    {
        return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenido']);
    }

    public function getUsuario()
    {
        return $this->hasOne(\app\models\Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }
}
