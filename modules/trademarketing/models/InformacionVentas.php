<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use app\models\SIICOP;

/**
* modelo que agrupa las variables necesarias para generar el reporte de ventas
*/

class InformacionVentas extends Model
{

    public $informacionActual;
    public $meses;
    public $informacionAnterior;
    public $mesInicio;
    public $mesFin;
    public $puntoVenta;
    public $criteriosEvaluacion;



    function __construct($mesInicio, $puntoVenta) {
        
        $this->mesInicio = $mesInicio;
        //$this->mesFin = $mesFin;
        $this->puntoVenta = $puntoVenta;

        
        $this->informacionActual = $this->consultarInformacionActual();
        $this->informacionAnterior = $this->consultarInformacionAnterior();
        $this->meses = $this->consultarMeses();
        $this->criteriosEvaluacion = $this->consultarCriterios();
        
    }

    public function consultarInformacionAnterior()
    {
        return InformacionVentasAnterior::find()
        ->where('( mes=:mesInicio AND idComercial =:puntoVenta)')
        ->addParams([':mesInicio' => $this->mesInicio, ':puntoVenta' => $this->puntoVenta])
        ->orderBy(['idAgrupacion' => SORT_ASC])
        ->all();
    }

    public function consultarInformacionActual()
    {
        return InformacionVentasActual::find()
        ->where('( mes=:mesInicio AND idComercial =:puntoVenta)')
        ->addParams([':mesInicio' => $this->mesInicio, ':puntoVenta' => $this->puntoVenta])
        ->orderBy(['idAgrupacion' => SORT_ASC])
        ->all();
    }

    public function consultarInformacionMesAnterior()
    {   
        $mesAnterior = ($this->mesInicio - 1 == 0 ? 12 : $this->mesInicio - 1);
        return InformacionVentasActual::find()
        ->where('( mes=:mesInicio AND idComercial =:puntoVenta)')
        ->addParams([':mesInicio' => $mesAnterior , ':puntoVenta' => $this->puntoVenta])
        ->orderBy(['idAgrupacion' => SORT_ASC])
        ->all();
    }

    public function consultarMeses()
    {
        return InformacionVentasAnterior::find()
        ->where('( mes=:mesInicio AND idComercial =:puntoVenta)')
        ->groupBy(['mes'])
        ->addParams([':mesInicio' => $this->mesInicio, ':puntoVenta' => $this->puntoVenta])
        ->all();
    }

    public function crecimientoMesAnterior()
    {
        $infoAnterior = $this->consultarInformacionMesAnterior();
        $infoActual = $this->consultarInformacionActual();
        $dataset = [];
        foreach ($infoAnterior as $indice => $registro) {
            $fila = [
                        'unidadDeNegocio' => $registro->idAgrupacion,
                        'mesAnterior' => $registro->mes,
                        'mesActual' => $infoActual[$indice]->mes,
                        'unidadesMesAnterior' => $registro->unidades,
                        'unidadesMesActual' => $infoActual[$indice]->unidades,
                        'valorMesAnterior' => $registro->valor,
                        'valorMesAnterior' => $infoActual[$indice]->valor,
                        'crecimiento' => ($infoActual[$indice]->valor - $registro->valor) / $registro->valor
                    ];
            $dataset[] = $fila;
        }
        return $dataset;
    }

    public function crecimientoAnioAnterior()
    {
        $infoAnterior = $this->consultarInformacionAnterior();
        $infoActual = $this->consultarInformacionActual();
        $dataset = [];
        foreach ($infoAnterior as $indice => $registro) {
            $fila = [
                        'unidadDeNegocio' => $registro->idAgrupacion,
                        'mesAnterior' => $registro->mes,
                        'mesActual' => $infoActual[$indice]->mes,
                        'unidadesMesAnterior' => $registro->unidades,
                        'unidadesMesActual' => $infoActual[$indice]->unidades,
                        'valorMesAnterior' => $registro->valor,
                        'valorMesAnterior' => $infoActual[$indice]->valor,
                        'crecimiento' => ($infoActual[$indice]->valor - $registro->valor) / $registro->valor
                    ];
            $dataset[] = $fila;
        }
        return $dataset;
    }

    public function crecimientoTotal()
    {
        $infoAnioAnterior = $this->consultarInformacionAnterior();
        $infoMesAnterior = $this->consultarInformacionMesAnterior();
        $infoActual = $this->consultarInformacionActual();
        $unidadesNegocio = [];
        $dataset = [];
        $agrupaciones = SIICOP::wsGetUnidadesNegocio(2);
        // \Yii::$app->response->format = 'json';
        // return $agrupaciones;
        // exit();
        $totalUnidadesAnioAnterior = 0;
        $totalUnidadesMesAnterior = 0;
        $totalUnidadesMesActual = 0;

        $totalValorAnioAnterior = 0;
        $totalValorMesAnterior = 0;
        $totalValorMesActual = 0;

        $crecimientoTotalUnidadesMes = 0;
        $crecimientoTotalUnidadesAnio = 0;
        $crecimientoTotalValorMes = 0;
        $crecimientoTotalValorAnio = 0;

        foreach ($infoMesAnterior as $indice => $registro) {
            $crecimientoAnioAnteriorUnidades = ($infoActual[$indice]->unidades - $infoAnioAnterior[$indice]->unidades) / $infoAnioAnterior[$indice]->unidades;
            $crecimientoMesAnteriorUnidades = ($infoActual[$indice]->unidades - $registro->unidades) / $registro->unidades;
            $crecimientoAnioAnteriorValor = ($infoActual[$indice]->valor - $infoAnioAnterior[$indice]->valor) / $infoAnioAnterior[$indice]->valor;
            $crecimientoMesAnteriorValor = ($infoActual[$indice]->valor - $registro->valor) / $registro->valor;
            $unidadNegocio = [
                'unidadDeNegocio' => $registro->idAgrupacion,
                'nombreUnidadDeNegocio' => $agrupaciones[$registro->idAgrupacion],
                'mesAnterior' => $registro->mes,
                'mesActual' => $infoActual[$indice]->mes,
                'unidadesAnioAnterior' => $infoAnioAnterior[$indice]->unidades,
                'unidadesMesAnterior' => $registro->unidades,
                'unidadesMesActual' => $infoActual[$indice]->unidades,
                'valorAnioAnterior' => $infoAnioAnterior[$indice]->valor,
                'valorMesAnterior' => $registro->valor,
                'valorMesActual' => $infoActual[$indice]->valor,
                'crecimientoAnioAnteriorUnidades' => $crecimientoAnioAnteriorUnidades,
                'crecimientoMesAnteriorUnidades' => $crecimientoMesAnteriorUnidades,
                'crecimientoAnioAnteriorValor' => $crecimientoAnioAnteriorValor,
                'crecimientoMesAnteriorValor' => $crecimientoMesAnteriorValor,
            ];
            $totalUnidadesAnioAnterior += $infoAnioAnterior[$indice]->unidades;
            $totalUnidadesMesAnterior += $registro->unidades;
            $totalUnidadesMesActual += $infoActual[$indice]->unidades;

            $totalValorAnioAnterior += $infoAnioAnterior[$indice]->valor;
            $totalValorMesAnterior += $registro->valor;
            $totalValorMesActual += $infoActual[$indice]->valor;
            
            $crecimientoTotalUnidadesAnio += $crecimientoAnioAnteriorUnidades; 
            $crecimientoTotalUnidadesMes += $crecimientoMesAnteriorUnidades;
            $crecimientoTotalValorAnio += $crecimientoAnioAnteriorValor;
            $crecimientoTotalValorMes += $crecimientoMesAnteriorValor;
            
            $unidadesNegocio[] = $unidadNegocio;
        }
        
        $dataset['unidadesNegocio'] = $unidadesNegocio;

        $dataset['totalUnidadesAnioAnterior'] = $totalUnidadesAnioAnterior;
        $dataset['totalUnidadesMesAnterior'] = $totalUnidadesMesAnterior;
        $dataset['totalUnidadesMesActual'] = $totalUnidadesMesActual;

        $dataset['totalValorAnioAnterior'] = $totalValorAnioAnterior;
        $dataset['totalValorMesAnterior'] = $totalValorMesAnterior;
        $dataset['totalValorMesActual'] = $totalValorMesActual;

        $dataset['crecimientoTotalUnidadesAnio'] = $crecimientoTotalUnidadesAnio;
        $dataset['crecimientoTotalUnidadesMes'] = $crecimientoTotalUnidadesMes;
        $dataset['crecimientoTotalValorAnio'] = $crecimientoTotalValorAnio;
        $dataset['crecimientoTotalValorMes'] = $crecimientoTotalValorMes;
        \Yii::$app->response->format = 'json';
        return $dataset;

    }

    public function completarAgrupacion($info)
    {
        for ($i = 1; $i < 5; $i++) { 
            if ($info[i]->idAgrupacion) {
                # code...
            }
        }
    }

    public function consultarCriterios()
    {
        return CriteriosEvaluacionVentas::find()->all();
    }

}
