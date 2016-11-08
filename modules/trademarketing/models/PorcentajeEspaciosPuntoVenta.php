<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Modelo para la tabla "t_TRMA_PorcentajeEspaciosPuntoVenta".
 *
 * @property string $idComercial
 * @property string $idEspacio
 * @property string $valor
 *
 * @property Espacio $Espacio
 */

class PorcentajeEspaciosPuntoVenta extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 't_TRMA_PorcentajeEspaciosPuntoVenta';
    }

    public function rules()
    {
        return [
            [['idComercial', 'idEspacio', 'valor'], 'required'],
            [['idEspacio', 'valor'], 'integer'],
            [['idComercial'], 'string', 'max' => 10],
            [['idEspacio'], 'exist', 'skipOnError' => true, 'targetClass' => Espacio::className(),
              'targetAttribute' => ['idEspacio' => 'idEspacio']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idComercial' => 'Punto de venta',
            'idEspacio' => 'Id Espacio',
            'valor' => 'Porcentaje',
        ];
    }

    // RELACIONES

    public function getEspacio()
    {
        return $this->hasOne(Espacio::className(), ['idEspacio' => 'idEspacio']);
    }

    // CONSULTAS

    public static function getPorcentajeByPuntoVenta($puntoVenta)
    {
      return self::find()->where(['idComercial' => $puntoVenta])->all();
    }

    public static function countPorcentajesByPuntoVenta($puntoVenta)
    {
        return self::find()->where(['idComercial' => $puntoVenta])->count();
    }

    // FUNCIONES

    public function getMapListaPuntosVenta(){
        $WSResult = $this->callWsPuntosVenta();
        $opciones = array();

        foreach ($WSResult as $key => $value) {
          array_push($opciones, $value);
        }

        return ArrayHelper::map($opciones, 'IDComercial', 'NombrePuntoDeVenta');
    }

    public function callWsPuntosVenta()
    {
        $client = new \SoapClient(\Yii::$app->params['webServices']['tradeMarketing']['puntosVenta'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            'cache_wsdl' => WSDL_CACHE_NONE
        ));

        try {

            $result = $client->getPuntoVenta(array());
            return $result;

        } catch (SoapFault $exc) {

        } catch (Exception $exc) {

        }
    }

    // extra campos para solicitar las relaciones en la peticion rest
    public function extraFields()
    {
      return ['espacio'];
    }
}
