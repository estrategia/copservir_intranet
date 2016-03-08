<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_contenidoportal".
 *
 * @property string $idContenido
 * @property string $idPortal
 */
class ContenidoPortal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_contenidoportal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idContenido', 'idPortal'], 'required'],
            [['idContenido', 'idPortal'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idContenido' => 'Id Contenido',
            'idPortal' => 'Id Portal',
        ];
    }
}
