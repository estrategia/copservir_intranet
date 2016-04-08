<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\OfertasLaborales;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Ciudad;

/**
 * This is the model class for table "t_ofertaslaboralesdestino".
 *
 * @property integer $idOfertaLaboral
 * @property integer $idGrupoInteres
 * @property integer $codigoCiudad
 */
class OfertasLaboralesDestino extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_OfertasLaboralesDestino';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idOfertaLaboral', 'idGrupoInteres',  'codigoCiudad'], 'required'],
            [['idOfertaLaboral', 'idGrupoInteres',  'codigoCiudad'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idOfertaLaboral' => 'Id Oferta Laboral',
            'idGrupoInteres' => 'Id Grupo Interes',
            'codigoCiudad' => 'Codigo Ciudad',
        ];
    }

    /**
    * Se define la relacion entre los modelos  OfertasLaboralesDestino y OfertasLaborales
    * @param none
    * @return modelo OfertasLaborales
    */
    public function getObjOfertaLaboral(){
        return $this->hasOne(OfertasLaborales::className(), ['idOfertaLaboral' => 'idOfertaLaboral']);
    }

    /**
    * Se define la relacion entre los modelos  OfertasLaboralesDestino y GrupoInteres
    * @param none
    * @return modelo GrupoInteres
    */
    public function getObjGrupoInteres(){
        return $this->hasOne(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteres']);
    }

    /**
    * Se define la relacion entre los modelos  OfertasLaboralesDestino y Ciudad
    * @param none
    * @return modelo Ciudad
    */
    public function getObjCiudad(){
        return $this->hasOne(Ciudad::className(), ['codigoCiudad' => 'codigoCiudad']);
    }

    /**
    * Consulta los OfertasLaboralesDestino segun el idOfertaLaboral junto con los objetos cargos relacionados
    * @param idOfertaLaboral
    * @return data provider con OfertasLaboralesDestino
    */
    public static function listaOfertas($idOfertaLaboral)
    {

      $query = self::find()->joinWith(['objOfertaLaboral'])
              ->where("(  t_OfertasLaboralesDestino.idOfertaLaboral =:idOfertaLaboral )")
              ->addParams([':idOfertaLaboral' => $idOfertaLaboral])->with(['objOfertaLaboral','objGrupoInteres','objCiudad']);

      $dataProvider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
               'pageSize' => 10,
           ],
       ]);

      return $dataProvider;
    }

}
