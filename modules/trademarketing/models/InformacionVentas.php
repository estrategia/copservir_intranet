<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;

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
        ->all();
    }

    public function consultarInformacionActual()
    {
        return InformacionVentasActual::find()
        ->where('( mes=:mesInicio AND idComercial =:puntoVenta)')
        ->addParams([':mesInicio' => $this->mesInicio, ':puntoVenta' => $this->puntoVenta])
        ->all();
    }

    public function consultarInformacionMesAnterior()
    {   
        $mesAnterior = ($this->mesInicio - 1 == 0 ? 12 : $this->mesInicio - 1);
        return InformacionVentasActual::find()
        ->where('( mes=:mesInicio AND idComercial =:puntoVenta)')
        ->addParams([':mesInicio' => $mesAnterior , ':puntoVenta' => $this->puntoVenta])
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

    public function crecimientoAñoAnterior()
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
        
    }

    public function consultarCriterios()
    {
        return CriteriosEvaluacionVentas::find()->all();
    }

}
