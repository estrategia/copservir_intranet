<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_contenidoportal".
 *
 * @property string $idContenido
 * @property string $idPortal
 *
 * @property TContenido $idContenido0
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
            [['idContenido', 'idPortal'], 'integer'],
            [['idContenido'], 'exist', 'skipOnError' => true, 'targetClass' => Contenido::className(), 'targetAttribute' => ['idContenido' => 'idContenido']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdContenido0()
    {
        return $this->hasOne(TContenido::className(), ['idContenido' => 'idContenido']);
    }
}
