<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use app\models\SIICOP;
use yii\helpers\VarDumper;

/**
* modelo que agrupa las variables necesarias para generar el reporte y la calificacion
*/

class Reporte extends Model
{
    public $asignacion;
    public $calificaciones;
    public $espacios;
    public $categorias;
    public $variables;
    public $porcentajeEspacios;
    public $rangoCalificaciones;
    public $observaciones;
    public $porcentajeUnidades;
    public $unidadesNegocio;
    public $valoresReporte;

    function __construct($idAsignacion) {
       $this->asignacion = $this->consultarAsignacion($idAsignacion);
    }

     /**
     * consulta un modelo AsignacionPuntoVenta segun el valor de su llave primaria
     * @return modelo AsignacionPuntoVenta
     */
    private function consultarAsignacion($idAsignacion)
    {
        $this->asignacion = AsignacionPuntoVenta::find($idAsignacion)
            ->joinWith('calificaciones')
            ->joinWith('calificaciones.variable')
            ->joinWith('calificaciones.variable.categoria')
            ->one();
        if (($this->asignacion) !== null) {
           return $this->asignacion;
        } else {
           throw new NotFoundHttpException('El recurso no existe.');
        }
    }

    public function generarDatos()
    {
        $calificacionesAsignacion = $this->asignacion->calificaciones;
        $categorias = [];

        foreach ($calificacionesAsignacion as $i => $calificacionAsignacion) {
            $idCategoria = $calificacionAsignacion->variable->categoria->idCategoria;
            $idVariable = $calificacionAsignacion->variable->idVariable;

            if(!isset($categorias[$idCategoria])){
                $categorias[$idCategoria] = ['nombreCategoria' => $calificacionAsignacion->variable->categoria->nombre, 'variables' => [], 'totalesUnidadesNegocio' => []];
            }

            if(!isset($categorias[$idCategoria]['variables'][$idVariable])){
                $categorias[$idCategoria]['variables'][$idVariable] = ['nombreVariable' => $calificacionAsignacion->variable->nombre, 'calificaciones' => []];
            }

            $categorias[$idCategoria]['variables'][$idVariable]['calificaciones'][$calificacionAsignacion->IdAgrupacion] = ['nombreUnidad'=>$calificacionAsignacion->nombreUnidadNegocio, 'calificacion' => $calificacionAsignacion->valor];

            if (!isset($categorias[$idCategoria]['totalesUnidadesNegocio'][$calificacionAsignacion->IdAgrupacion])) {
                $categorias[$idCategoria]['totalesUnidadesNegocio'][$calificacionAsignacion->IdAgrupacion] = 0;
            }

            $categorias[$idCategoria]['totalesUnidadesNegocio'][$calificacionAsignacion->IdAgrupacion] += $calificacionAsignacion->valor;
        }
        return $categorias;
    }

     /**
     * Asigna las categorias y sus respectivas variables
     */
     private function consultarCategoriasConVariables()
     {
        $this->variables = array();

        $this->categorias = Categoria::getCategorias();
        foreach ($this->categorias as $key => $value) {
            $this->variables[$value->nombre] = $value->variablesMedicion;
        }
    }

     /**
     * Peticion webService soap de las unidades de negocio
     * @return array
     */
     private function callWSGetUnidadesNegocio()
     {
        return SIICOP::wsGetUnidadesNegocio();
    }

     /**
     * consulta todos los modelos Espacio
     * @return array
     */
     private function consultarEspacios()
     {
        return Espacio::find()->all();
    }

     /**
     * consulta todos los modelos RangoCalificaciones
     * @return array
     */
     private function consultarRangosCalificacion()
     {
        return RangoCalificaciones::find()->orderBy('valor')->all();
    }

     /**
     * crea un arreglo de modelos porcentajeEspacios consultados en base a el punto de venta y espacio
     * @return array
     */
     private function consultarPorcentajesEspacio()
     {
       $listaPorcentaje = array();

       foreach ($this->espacios as $espacio) {

           $porcentaje = Espacio::getPorcentajeEspacio($this->asignacion->idComercial, $espacio->idEspacio);

           if ($porcentaje != null) {
               $listaPorcentaje[$espacio->nombre] = $porcentaje->valor;
           }else{
               $listaPorcentaje[$espacio->nombre] = '0';
                     //Yii::$app->session->setFlash('error', "Faltan porcentajes para los espacios, los calculos se haran con ceros");
           }
       }

       return $listaPorcentaje;

   }

     /**
     * crea un arreglo de modelos PorcentajeUnidad consultados en base a si asignacion, unidad de negocio
     * @return array
     */
     private function consultarPorcentajesUnidades()
     {
       $porcentajeUnidades = array();

       foreach ($this->unidadesNegocio as $unidad) {

           $modelo = PorcentajeUnidad::find()->where(['idAsignacion' => $this->asignacion->idAsignacion, 'idAgrupacion' => $unidad['IdAgrupacion']])->one();

           if ($modelo != null) {
               $porcentajeUnidades[$unidad['NombreUnidadNegocio']] = $modelo->porcentaje;
           }else{
               $porcentajeUnidades[$unidad['NombreUnidadNegocio']] = 0;
                     //Yii::$app->session->setFlash('error', "No se encontraron porcentajes para las unidades, los calculos se haran con ceros");
           }
       }

       return $porcentajeUnidades;
   }

     /**
     * crea un arreglo de modelos PorcentajeUnidad consultados en base a si asignacion, unidad de negocio
     * @return array
     */
     private function consultarModelosPorcentajesUnidades()
     {
       $modelosPorcentajeUnidad = array();

       foreach ($this->unidadesNegocio as $unidad) {
           $modelo = PorcentajeUnidad::find()->where([ 'idAsignacion' => $this->asignacion->idAsignacion, 'idAgrupacion' => $unidad['IdAgrupacion'] ])->one();

           if ($modelo !== null) {
               array_push($modelosPorcentajeUnidad, $modelo);
           }else{
               array_push($modelosPorcentajeUnidad, new PorcentajeUnidad());
           }
       }

       return $modelosPorcentajeUnidad;
   }

     /**
     * crea un arreglo de modelos CalificacionVariable consultados en base a su asignacion, variable y/o unidade de negocio
     * @return array
     */
     protected function consultarCalificaciones()
     {
       $modelosCalificacion = array();

       foreach ($this->categorias as $categoria) {

           foreach ($categoria->variablesMedicion as $variable){

               if ($variable->calificaUnidadNegocio === 1) {

                   foreach ($this->unidadesNegocio as $unidad) {

                       $modelo = CalificacionVariable::find()->where(['idAsignacion' => $this->asignacion->idAsignacion, 'idVariable' => $variable->idVariable, 'IdAgrupacion' => $unidad['IdAgrupacion']])->one();

                       if ($modelo !== null) {
                           array_push($modelosCalificacion, $modelo);
                       }else{
                           array_push($modelosCalificacion, new CalificacionVariable());
                       }
                   }

               }else{

                   $modelo = CalificacionVariable::find()->where(['idAsignacion' => $this->asignacion->idAsignacion, 'idVariable' => $variable->idVariable])->one();

                   if ($modelo !== null) {
                       array_push($modelosCalificacion, $modelo);
                   }else{
                       array_push($modelosCalificacion, new CalificacionVariable());
                   }
               }
           }
       }

       return $modelosCalificacion;
   }


     /**
     * crea un arreglo de modelos Observaciones consultados en base a si asignacion, variable
     * @return array
     */
     protected function consultarObservaciones()
     {
       $modelosObservacion = array();

       foreach ($this->categorias as $categoria) {

           foreach ($categoria->variablesMedicion as $variable){
            if(!isset($modelosObservacion[$variable->idVariable])){
                $modelosObservacion[$variable->idVariable] = [];
            }

            $modelos = Observaciones::find()->where(['idAsignacion' => $this->asignacion->idAsignacion, 'idVariable' => $variable->idVariable])->all();
            if (!empty($modelos)) {
               $modelosObservacion[$variable->idVariable] = array_merge($modelosObservacion[$variable->idVariable], $modelos);
           }
       }
   }

   return $modelosObservacion;

        //return Observaciones::find()->where(['idAsignacion' => $this->asignacion->idAsignacion])->all();
}
}

?>
