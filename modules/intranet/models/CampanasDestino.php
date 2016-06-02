<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "t_campanasdestino".
 *
 * @property string $idImagenCampana
 * @property integer $codigoCiudad
 * @property string $idGrupoInteres
 *
 * @property MCiudad $codigoCiudad0
 * @property MGrupointeres $idGrupoInteres0
 * @property TPublicacionescampanas $idImagenCampana0
 */
class CampanasDestino extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 't_CampanasDestino';
    }

    public function rules()
    {
        return [
            [['idImagenCampana', 'codigoCiudad', 'idGrupoInteres'], 'required'],
            [['idImagenCampana', 'codigoCiudad', 'idGrupoInteres'], 'integer'],
            [['codigoCiudad'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['codigoCiudad' => 'codigoCiudad']],
            [['idGrupoInteres'], 'exist', 'skipOnError' => true, 'targetClass' => Grupointeres::className(), 'targetAttribute' => ['idGrupoInteres' => 'idGrupoInteres']],
            [['idImagenCampana'], 'exist', 'skipOnError' => true, 'targetClass' => PublicacionesCampanas::className(), 'targetAttribute' => ['idImagenCampana' => 'idImagenCampana']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idImagenCampana' => 'Id Imagen Campana',
            'codigoCiudad' => 'Codigo Ciudad',
            'idGrupoInteres' => 'Id Grupo Interes',
        ];
    }

    //RELACIONES

    public function getObjCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['codigoCiudad' => 'codigoCiudad']);
    }

    public function getObjGrupoInteres()
    {
        return $this->hasOne(Grupointeres::className(), ['idGrupoInteres' => 'idGrupoInteres']);
    }

    public function getObjImagenCampana()
    {
        return $this->hasOne(PublicacionesCampanas::className(), ['idImagenCampana' => 'idImagenCampana']);
    }

    // CONSULTAS

    /**
    * Consulta los CampanasDestino segun el idImagenCampana junto con los objetos cargos relacionados
    * @param idImagenCampana
    * @return data provider con OfertasLaboralesDestino
    */
    public static function listaDestinos($idImagenCampana)
    {

      $query = self::find()->joinWith(['objImagenCampana'])
      ->where("(  t_CampanasDestino.idImagenCampana =:idImagenCampana )")
      ->addParams([':idImagenCampana' => $idImagenCampana])->with(['objImagenCampana','objGrupoInteres','objCiudad']);

      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 10,
        ],
      ]);

      return $dataProvider;
    }
}
