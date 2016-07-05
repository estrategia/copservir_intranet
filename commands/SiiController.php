<?php

namespace app\commands;

use yii\console\Controller;
use app\modules\intranet\models\CumpleanosLaboral;
use app\modules\intranet\models\CumpleanosPersona;

/**
 * Comando con tareas programadas para la intranet
 */
class SiiController extends Controller
{
    /**
     * Este comando solicita los cumpleaños de los usuarios por web services y los guarda
     * en la BD de la intranet en la tabla t_CumpleanosPersona
     */
    public function actionSincronizarCumpleanos()
    {
        echo 'sincronizar cumpleanos';
        $cumpleanos = CumpleanosPersona::getCumpleanosMes();

        $cedulas = $this->generarCedulas($cumpleanos);

        $response = self::callWSGetCumpleanos($cedulas);

        if (!empty($response)) {

            foreach ($response as $key => $value) {

              //$existeCumpleanos  = CumpleanosPersona::find()->where(['numeroDocumento' => $value['NumeroDocumento']])->one();

              //if (empty($existeCumpleanos)) {

                $transaction = CumpleanosPersona::getDb()->beginTransaction();

                try {

                  $model = new CumpleanosPersona;
                  $model->numeroDocumento = $value['NumeroDocumento'];
                  $model->nombre = $value['Nombres'].' '.$value['PrimerApellido'].' '.$value['SegundoApellido'];
                  $model->idCargo = $value['CodigoCargo'];
                  $model->fecha  = date("Y").'-'.$value['Mes'].'-'.$value['Dia'];
                  $model->codigoCiudad = $value['CodigoCiudad'];

                  if ($model->save()) {
                    $transaction->commit();
                  }else{
                    throw new Exception("Error al sincronizar cumpleanos: ".yii\helpers\Json::enconde($model->getErrors()), 100);
                  }

                } catch (Exception $e) {
                  $transaction->rollBack();
                  throw $e;
                }
              //}else{
                //echo 'el cumpleanos ya esta guardado';
              //}
            }
        }
        echo 'termina sincronizar cumpleanos';
    }

    private function callWSGetCumpleanos($cedulas)
    {
      $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
          "trace" => 1,
          "exceptions" => 0,
          'connection_timeout' => 5,
          'cache_wsdl' => WSDL_CACHE_NONE
      ));

      try {

          $result = $client->getCumpleanos(date("m"), $cedulas);
          return $result;

      } catch (SoapFault $ex) {
        Yii::error($ex->getMessage());
      } catch (Exception $ex) {
        Yii::error($ex->getMessage());
      }
    }

    /**
     * Este comando solicita los aniversarios de los usuarios por web services y los guarda
     * en la BD de la intranet en la tabla t_CumpleanosLaboral
     */
    public function actionSincronizarAniversarios()
    {
        echo 'sincronizar Aniverzarios';
        $aniversarios = CumpleanosLaborales::getAniversariosMes();

        $cedulas = $this->generarCedulas($aniversarios);

        $response = self::callWSGetAniversarios($cedulas);

        if (!empty($response)) {

            foreach ($response as $key => $value) {

              //$existeCumpleanos  = CumpleanosLaboral::find()->where(['numeroDocumento' => $value['NumeroDocumento']])->one();

              //if (empty($existeCumpleanos)) {

                $transaction = CumpleanosLaboral::getDb()->beginTransaction();

                try {

                  $model = new CumpleanosLaboral;
                  $model->numeroDocumento = $value['NumeroDocumento'];
                  $model->nombre = $value['Nombres'].' '.$value['PrimerApellido'].' '.$value['SegundoApellido'];
                  $model->idCargo = $value['CodigoCargo'];
                  $model->fecha  = date("Y").'-'.$value['Mes'].'-'.$value['Dia'];
                  $model->codigoCiudad = $value['CodigoCiudad'];

                  if ($model->save()) {
                    $transaction->commit();
                  }else{
                    throw new Exception("Error al sincronizar aniversarios: ".yii\helpers\Json::enconde($model->getErrors()), 100);
                  }

                } catch (Exception $e) {
                  $transaction->rollBack();
                  throw $e;
                }
              //}else{
                //echo 'el cumpleanos ya esta guardado';
              //}
            }
        }

        echo 'Termina sincronizar Aniverzarios';

    }

    private function callWSGetAniversarios($cedulas)
    {
      $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
          "trace" => 1,
          "exceptions" => 0,
          'connection_timeout' => 5,
          'cache_wsdl' => WSDL_CACHE_NONE
      ));

      try {

          $result = $client->getAniversarios(date("m"), $cedulas);
          return $result;

      } catch (SoapFault $ex) {
        Yii::error($ex->getMessage());
      } catch (Exception $ex) {
        Yii::error($ex->getMessage());
      }
    }

    private function generarCedulas($modelos)
    {
      $cedulas = '';

      foreach ($modelos as $model) {
        $cedulas .= $model->numeroDocumento.',';
      }

      return $cedulas;
    }
}
?>
