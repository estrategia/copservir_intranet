<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_GrupoInteres".
 *
 * @property string $idGrupoInteres
 * @property string $nombreGrupo
 */
class GrupoInteres extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_GrupoInteres';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreGrupo'], 'required'],
            [['nombreGrupo','imagenGrupo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idGrupoInteres' => 'Id Grupo Interes',
            'nombreGrupo' => 'Nombre Grupo',
            'imagenGrupo' => 'Imagen Grupo'
        ];
    }
    
    public function getImagen(){
        return Yii::$app->homeUrl . 'img/gruposInteres/' .$this->imagenGrupo;
    }
            
}
