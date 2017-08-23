<?php

namespace app\commands;

use yii\console\Controller;
use app\modules\intranet\models\CumpleanosLaboral;
use app\modules\intranet\models\CumpleanosPersona;
use yii\helpers\VarDumper;

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
        
        \Yii::info("Cedulas omitir: " . $cedulasOmitir);
        \Yii::info("Cantidad cedular omitir: " . count($cedulasOmitir));

        $response = CumpleanosPersona::callWSGetCumpleanos($cedulasOmitir);
        
        \Yii::info('Respuesta SIICOP: \n');
        \Yii::info(VarDumper::dumpAsString($response));

        if (!empty($response)) {
            \Yii::info('Guardar cumpleanos -- inicio');
            \Yii::info('Cantidad cumpleanos consultados: ' . count($response));
            $count = 0;
            foreach ($response as $value) {
                try {
                    $model = new CumpleanosPersona;
                    $model->numeroDocumento = $value['NumeroDocumento'];
                    $model->nombre = $value['Nombres'] . ' ' . $value['PrimerApellido'] . ' ' . $value['SegundoApellido'];
                    $model->idCargo = $value['CodigoCargo'];
                    $model->fecha = date("Y") . '-' . $value['Mes'] . '-' . $value['Dia'];
                    $model->codigoCiudad = $value['CodigoCiudad'];
                    $model->fechaIngreso = $value['FechaIngreso'];

                    if (!empty($value['NombrePuntoDeVenta'])) {
                      $model->ubicacion = $value['NombrePuntoDeVenta'];
                    }elseif (!empty($value['NombreCEDI'])) {
                      $model->ubicacion = "CEDI " . $value['NombreCEDI'];
                    }else {
                      $model->ubicacion = "Sede ". $value['NombreSede'];
                    }

                    if (!$model->save()) {
                        throw new \Exception("Error al sincronizar cumpleanos: " . \yii\helpers\Json::encode($model->getErrors()), 100);
                    }
                    
                    $count++;
                } catch (\Exception $e) {
                    \Yii::error($e->getMessage());
                }
            }
            \Yii::info('Cantidad cumpleanos guardados: ' . $count);
            \Yii::info('Guardar cumpleanos -- fin');
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
        
        \Yii::info("Cedulas omitir: " . $cedulas);
        \Yii::info("Cantidad cedular omitir: " . count($cedulas));
        
        $response = CumpleanosLaboral::callWSGetAniversarios($cedulas);
        
        \Yii::info('Respuesta SIICOP: \n');
        \Yii::info(VarDumper::dumpAsString($response));

        if (!empty($response)) {
            \Yii::info('Guardar aniversarios -- inicio');
            \Yii::info('Cantidad aniversarios: ' . count($response));
            $count = 0;
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
                    
                    $count++;
                } catch (Exception $e) {
                    \Yii::error($e->getMessage());
                }
            }
            \Yii::info('Cantidad aniversarios guardados: ' . $count);
            \Yii::info('Guardar aniversarios -- fin');
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
