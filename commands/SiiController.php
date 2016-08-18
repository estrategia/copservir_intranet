<?php

namespace app\commands;

use yii\console\Controller;
use app\modules\intranet\models\CumpleanosLaboral;
use app\modules\intranet\models\CumpleanosPersona;

/**
 * Comando con tareas programadas para la intranet
 */
class SiiController extends Controller {

    /**
     * Este comando solicita los cumpleaños de los usuarios por web services y los guarda
     * en la BD de la intranet en la tabla t_CumpleanosPersona
     */
    public function actionSincronizarCumpleanos() {
        \Yii::info('sincronizar cumpleanos -- inicio');
        $cumpleanos = CumpleanosPersona::getCumpleanosMes();
        $cedulasOmitir = $this->generarCedulas($cumpleanos);

        $response = CumpleanosPersona::callWSGetCumpleanos($cedulasOmitir);

        if (!empty($response)) {
            foreach ($response as $value) {
                try {
                    $model = new CumpleanosPersona;
                    $model->numeroDocumento = $value['NumeroDocumento'];
                    $model->nombre = $value['Nombres'] . ' ' . $value['PrimerApellido'] . ' ' . $value['SegundoApellido'];
                    $model->idCargo = $value['CodigoCargo'];
                    $model->fecha = date("Y") . '-' . $value['Mes'] . '-' . $value['Dia'];
                    $model->codigoCiudad = $value['CodigoCiudad'];
                    $model->fechaIngreso = $value['FechaIngreso'];

                    if (!is_null($value['NombrePuntoDeVenta'])) {
                      $model->ubicacion = $value['NombrePuntoDeVenta'];
                    }elseif (!is_null($value['NombreCEDI'])) {
                      $model->ubicacion = $value['NombreCEDI'];
                    }else {
                      $model->ubicacion = $value['NombreSede'];
                    }

                    if (!$model->save()) {
                        throw new \Exception("Error al sincronizar cumpleanos: " . \yii\helpers\Json::encode($model->getErrors()), 100);
                    }
                } catch (\Exception $e) {
                    \Yii::error($e->getMessage());
                }
            }
        }
        \Yii::info('sincronizar cumpleanos -- fin');
    }

    /**
     * Este comando solicita los aniversarios de los usuarios por web services y los guarda
     * en la BD de la intranet en la tabla t_CumpleanosLaboral
     */
    public function actionSincronizarAniversarios() {
        \Yii::info('sincronizar aniversarios -- inicio');
        $aniversarios = CumpleanosLaboral::getAniversariosMes();
        $cedulas = $this->generarCedulas($aniversarios);
        $response = CumpleanosLaboral::callWSGetAniversarios($cedulas);

        if (!empty($response)) {
            foreach ($response as $value) {
                try {
                    $model = new CumpleanosLaboral;
                    $model->numeroDocumento = $value['NumeroDocumento'];
                    $model->nombre = $value['Nombres'] . ' ' . $value['PrimerApellido'] . ' ' . $value['SegundoApellido'];
                    $model->idCargo = $value['CodigoCargo'];
                    $model->fecha = date("Y") . '-' . $value['Mes'] . '-' . $value['Dia'];
                    $model->codigoCiudad = $value['CodigoCiudad'];
                    $model->fechaIngreso = $value['FechaIngreso'];

                    if (!$model->save()) {
                        throw new \Exception("Error al sincronizar aniversarios: " . \yii\helpers\Json::encode($model->getErrors()), 100);
                    }

                } catch (Exception $e) {
                    \Yii::error($e->getMessage());
                }
            }
        }

        \Yii::info('sincronizar aniversarios -- fin');
    }

    private function generarCedulas($modelos) {
        $cedulas = array();

        foreach ($modelos as $model) {
            $cedulas[] = $model->numeroDocumento;
        }

        return implode(",", $cedulas);
    }

}

?>
