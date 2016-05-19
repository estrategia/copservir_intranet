<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_EventosCalendarioPortal".
 *
 * @property integer $idEventoCalendario
 * @property integer $idPortal
 */
class EventosCalendarioPortal extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 't_EventosCalendarioPortal';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['idEventoCalendario', 'idPortal'], 'required'],
            [['idEventoCalendario', 'idPortal'], 'integer'],
            [['idPortal'], 'exist', 'skipOnError' => true, 'targetClass' => Portal::className(), 'targetAttribute' => ['idPortal' => 'idPortal']],
            [['idEventoCalendario'], 'exist', 'skipOnError' => true, 'targetClass' => EventosCalendario::className(), 'targetAttribute' => ['idEventoCalendario' => 'idEventoCalendario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'idEventoCalendario' => 'Id Evento Calendario',
            'idPortal' => 'Id Portal',
        ];
    }
    
    public function getObjPortal() {
        return $this->hasOne(Portal::className(), ['idPortal' => 'idPortal']);
    }

}
