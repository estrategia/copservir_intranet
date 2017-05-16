<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "t_contenidoemergentedestino".
 *
 * @property string $idContenidoEmergente
 * @property string $idGrupoInteres
 * @property integer $codigoCiudad
 *
 * @property MCiudad $codigoCiudad0
 * @property MContenidoemergente $idContenidoEmergente0
 * @property MGrupointeres $idGrupoInteres0
 */
class ContenidoEmergenteDestino extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 't_ContenidoEmergenteDestino';
    }

    public function rules()
    {
        return [
            [['idContenidoEmergente', 'idGrupoInteres', 'codigoCiudad'], 'required'],
            [['idContenidoEmergente', 'idGrupoInteres', 'codigoCiudad'], 'integer'],
            [['codigoCiudad'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['codigoCiudad' => 'codigoCiudad']],
            [['idContenidoEmergente'], 'exist', 'skipOnError' => true, 'targetClass' => ContenidoEmergente::className(), 'targetAttribute' => ['idContenidoEmergente' => 'idContenidoEmergente']],
            [['idGrupoInteres'], 'exist', 'skipOnError' => true, 'targetClass' => GrupoInteres::className(), 'targetAttribute' => ['idGrupoInteres' => 'idGrupoInteres']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idContenidoEmergente' => 'Contenido Emergente',
            'idGrupoInteres' => 'Grupo Interes',
            'codigoCiudad' => 'Ciudad',
        ];
    }

    // RELACIONES

    public function getObjCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['codigoCiudad' => 'codigoCiudad']);
    }

    public function getObjContenidoEmergente()
    {
        return $this->hasOne(ContenidoEmergente::className(), ['idContenidoEmergente' => 'idContenidoEmergente']);
    }

    public function getObjGrupoInteres()
    {
        return $this->hasOne(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteres']);
    }

    // CONSULTAS

    /**
    * Consulta los ContenidoEmergenteDestino segun el idContenidoEmergente
    * @param idContenidoEmergente
    * @return data provider con ContenidoEmergenteDestino
    */
    public static function listaDestinos($idContenidoEmergente)
    {

      $query = self::find()->joinWith(['objContenidoEmergente'])
      ->where("(  t_ContenidoEmergenteDestino.idContenidoEmergente =:idContenidoEmergente )")
      ->addParams([':idContenidoEmergente' => $idContenidoEmergente])->with(['objContenidoEmergente','objGrupoInteres','objCiudad']);

      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 10,
        ],
      ]);

      return $dataProvider;
    }
}
