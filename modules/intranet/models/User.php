<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $authKey
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'm_Usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['estado', 'default', 'value' => 1],
            ['estado', 'in', 'range' => [0, 1]],
            [['authKey'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['idUsuario' => $id, 'estado' => 1]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {

        return static::find()->where(['AND', ['=', 'numeroDocumento', $username], ['=', 'estado', 1], ['!=', 'numeroDocumento', 0]])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey = $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return true;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function getProfesion() {
        return "Ingeniero de sistemas y ciencias de la computación";
    }

    public function getCargo() {
        return "Jefe de Mercadeo";
    }

    public function getArea() {
        return "Mercadeo";
    }

    public function getVinculacion() {
        return strtotime("2015-01-20");
    }

    public function getAntiguedad() {
        $datetime1 = date_create(Date('Y-m-d'));
        $datetime2 = date_create('2015-08-20');
        $interval = date_diff($datetime1, $datetime2);
        $anhos = $meses  = "";

        if($interval->format('%y') > 1){
            $anhos = $interval->format('%y')." años ";
        }else if($interval->format('%y') == 1){
            $anhos = $interval->format('%y')." año ";
        }

        if($interval->format('%m') > 1){
            $meses = $interval->format('%m')." meses";
        }else if($interval->format('%m') == 1){
            $meses = $interval->format('%m')." mes";
        }
        return $anhos.$meses;
    }

    public function getJefeInmediato() {
        return "Edgar Palomino";
    }

    public function getSuperiores() {
        return "Universidad del valle sede Palmira";
    }

    public function getExtension() {
        return "35689";
    }

    public function getEmail() {
        return "miguel.sanchez@eiso.com.co";
    }

    public function getCelular() {
        return "314 598 2002";
    }

    public function getResidencia() {
        return "Calle 16 25 - 23 ";
    }

    public function getCiudad() {
        return "Palmira";
    }

    public function getCumpleanhos() {
       setlocale(LC_ALL,"es_ES");
       return  strftime("%B %d", strtotime("2015-01-20"));
    }

}
