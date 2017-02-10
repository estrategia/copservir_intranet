<?php

namespace app\modules\intranet\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \yii\db\ActiveRecord {

    const TIPO_ROL = 1;
    const TIPO_PERMISO = 2;

    public static function tableName() {
        return 'auth_item';
    }

    public function rules() {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'safe'],
            // [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Nombre',
            'type' => 'Tipo',
            'description' => 'Descripción',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getAuthAssignments() {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    public function getRuleName() {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    public function getAuthItemChildren() {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    public function getAuthItemChildren0() {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    public function getChildren() {
        return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }

    public function getParents() {
        return $this->hasMany(AuthItem::className(), ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
    }

    public static function consultarPermisos($usuario, $modulo, $tipoConsulta = 'modelo') {
        $listPermisos = null;
        $consulta = AuthItem::find()
                ->alias('permiso')
                ->joinWith(['parents as rol', 'parents.authAssignments as rolasignacion'])
                ->where("permiso.type=:tipoPermiso AND rolasignacion.user_id=:usuario AND permiso.visualizacionMenus=1 AND permiso.moduloDestino=:modulo")
                ->addParams([':tipoPermiso' => 2, ':usuario' => $usuario, ':modulo' => $modulo])
                ->distinct();
                // ->all();
        // if ($tipoConsulta != 'modelo') {
        //     // $rawSql = $consulta->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;
        //     $rawSql = "SELECT DISTINCT `permiso`.* FROM `auth_item` `permiso` LEFT JOIN `auth_item_child` ON `permiso`.`name` = `auth_item_child`.`child` LEFT JOIN `auth_item` `rol` ON `auth_item_child`.`parent` = `rol`.`name` LEFT JOIN `auth_assignment` `rolasignacion` ON `rol`.`name` = `rolasignacion`.`item_name` WHERE permiso.type=2 AND rolasignacion.user_id='1113618983' AND permiso.visualizacionMenus=1 AND permiso.moduloDestino='intranet'";
        //     $listPermisos = Yii::$app->db->createCommand($rawSql)->queryAll();
        // } else {
            $listPermisos = $consulta->all();
        // }
        return $listPermisos;
        // var_dump(sizeof($listPermisos));
                // \yii\helpers\VarDumper::dump($listPermisos, 10, true);
        // exit();
    }

    public function getListaPermisos() {
      $query = self::find()
      ->joinwith(['children as permiso'])
      ->where('auth_item.type =:tipo and auth_item.name not in (select child from auth_item_child where parent = "'.$this->name.'")')
      ->addParams([':tipo' => 2])
      ->asArray()
      ->all();

      return ArrayHelper::map($query, 'name', 'name');

    }

}
