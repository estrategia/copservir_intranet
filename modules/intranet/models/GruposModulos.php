<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_GruposModulos".
 *
 * @property string $idGruposModulos
 * @property string $idModulo
 * @property integer $orden
 *
 * @property Modulocontenido $idModulo
 */
class GruposModulos extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 't_GruposModulos';
    }

    public function rules()
    {
        return [
            [['idModulo'], 'required'],
            [['idModulo', 'orden'], 'integer'],
            [['idModulo'], 'exist', 'skipOnError' => true, 'targetClass' => ModuloContenido::className(), 'targetAttribute' => ['idModulo' => 'idModulo']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idGruposModulos' => 'Id Grupos Modulos',
            'idModulo' => 'Id Modulo',
            'orden' => 'Orden',
        ];
    }

    // RELACIONES

    public function getObjModuloContenido()
    {
        return $this->hasOne(ModuloContenido::className(), ['idModulo' => 'idModulo']);
    }
}
