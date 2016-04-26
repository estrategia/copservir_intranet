<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\Cargo;


/**
 * This is the model class for table "m_grupointerescargo".
 *
 * @property string $idCargo
 * @property string $idGrupoInteres
 */
class GrupoInteresCargo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_GrupoInteresCargo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCargo', 'idGrupoInteres'], 'required'],
            [['idGrupoInteres'], 'integer'],
            [['idCargo'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCargo' => 'Id Cargo',
            'idGrupoInteres' => 'Id Grupo Interes',
        ];
    }

    /*
    * RELACIONES
    */

    /**
    * Se define la relacion entre los modelos  GrupoInteresCargo y Cargo
    * @param none
    * @return modelo Cargo
    */
    public function getObjGrupoInteresCargo(){
        return $this->hasOne(Cargo::className(), ['idCargo' => 'idCargo']);
    }

    /*
    * CONSULTAS
    */

    /**
    * Consulta los GrupoInteresCargo segun el idGrupoInteres junto con los objetos cargos relacionados
    * @param idGrupoInteres
    * @return data provider con GrupoInteresCargo
    */
    public static function listaCargos($idGrupoInteres)
    {
      $query = self::find()->joinWith(['objGrupoInteresCargo'])
              ->where("(  m_GrupoInteresCargo.idGrupoInteres =:idGrupoInteres )")
              ->addParams([':idGrupoInteres' => $idGrupoInteres])->with(['objGrupoInteresCargo']);

      $dataProvider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
               'pageSize' => 10,
           ],
       ]);

      return $dataProvider;
    }

}
