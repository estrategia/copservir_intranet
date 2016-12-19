<?php

namespace app\modules\intranet\models;

use app\modules\intranet\models\AuthItem;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'auth_assignment';
    }

    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }

    public function getListaRoles($numeroDocumento, $modulo=null)
    {
        // var_dump($modulo);exit();
        if (!($modulo == null || $modulo == '')) {
            $opciones = AuthItem::find()
            ->where('(  type=:tipo and name not in (select item_name from auth_assignment where user_id =:numeroDocumento) AND moduloPadre=:moduloPadre)')
            ->addParams([':tipo' => AuthItem::TIPO_ROL, ':numeroDocumento' => $numeroDocumento, ':moduloPadre' => $modulo])
            ->asArray()
            ->all();
        } else {
            $opciones = AuthItem::find()
            ->where('(  type=:tipo and name not in (select item_name from auth_assignment where user_id =:numeroDocumento) )')
            ->addParams([':tipo' => AuthItem::TIPO_ROL, ':numeroDocumento' => $numeroDocumento])
            ->asArray()
            ->all();            
        }

      return ArrayHelper::map($opciones, 'name', 'name');
    }
}
