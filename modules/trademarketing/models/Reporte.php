<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use app\models\SIICOP;
use yii\helpers\VarDumper;
use yii\helpers\Json;

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

    function __construct() {
      // $this->asignacion = $this->consultarAsignacion($idAsignacion);
    }

    public function generarValoresCalificacion($idAsignacion)
    {
      $this->asignacion = $this->consultarAsignacion($idAsignacion);
      $this->consultarCategoriasConVariables();
      $this->unidadesNegocio = $this->callWSGetUnidadesNegocio();
      $this->calificaciones = $this->consultarCalificaciones();
      $this->observaciones = $this->consultarObservaciones();
      $this->porcentajeUnidades = $this->consultarModelosPorcentajesUnidades();
    }

    public function cearReporte($idAsignacion)
   {
       $this->asignacion = $this->consultarAsignacion($idAsignacion);
       $this->consultarCategoriasConVariables();
       $this->unidadesNegocio = $this->callWSGetUnidadesNegocio();
       $this->espacios = $this->consultarEspacios();
       $this->porcentajeEspacios = $this->consultarPorcentajesEspacio();
       $this->porcentajeUnidades = $this->consultarPorcentajesUnidades();
       $this->calificaciones = $this->consultarCalificaciones();
       $this->observaciones = $this->consultarObservaciones();
       $this->rangoCalificaciones = $this->consultarRangosCalificacion();
   }

   public function generarValoresReporte()
   {
        $arrayCalificaciones = array();

        foreach ($this->unidadesNegocio as $unidad) {
          foreach ($this->espacios as $espacio) {
          $calificacion = null;
          if ($espacio->variable->calificaUnidadNegocio == VariableMedicion::CALIFICA_UNIDAD) {
            $calificacion = CalificacionVariable::find()->where([
              'idAsignacion' => $this->asignacion->idAsignacion,
              'idVariable' => $espacio->variable->idVariable,
              'IdAgrupacion' => $unidad['IdAgrupacion'],
              ])->one();
          }else{
            $calificacion = CalificacionVariable::find()->where([
              'idAsignacion' => $this->asignacion->idAsignacion,
              'idVariable' => $espacio->variable->idVariable,
              ])->one();
          }

          array_push($arrayCalificaciones, $calificacion);
          }
        }

        $this->valoresReporte = $arrayCalificaciones;
   }

    public function generarDatos($idAsignacion)
    {
      $this->asignacion = $this->consultarAsignacion($idAsignacion);
      $response = [];
      $calificacionesAsignacion = $this->asignacion->calificaciones;
      // echo "string";
      // \yii\helpers\VarDumper::dump($calificacionesAsignacion);exit();
      $asignacion = [
        'idAsignacion' => $this->asignacion->idAsignacion,
        'idComercial' => $this->asignacion->idComercial,
        'estado' => $this->asignacion->estado,
        'NombrePuntoDeVenta' => $this->asignacion->NombrePuntoDeVenta,
        'nombreTipoNegocio' => $this->asignacion->nombreTipoNegocio,
        'idCiudad' => $this->asignacion->idCiudad,
        'idZona' => $this->asignacion->idZona,
        'nombreZona' => $this->asignacion->nombreZona,
        'idSede' => $this->asignacion->idSede,
        'nombreSede' => $this->asignacion->nombreSede,
        'numeroDocumento' => $this->asignacion->numeroDocumento,
        'usuarioSupervisor' => $this->asignacion->usuarioSupervisor->data['personal']['nombres'],
        'administrador' => [
          'documento' => $this->asignacion->numeroDocumentoAdministradorPuntoVenta,
          'nombres' => $this->asignacion->usuarioAdministrador->data['personal']['nombres'],
          'primerApellido' => $this->asignacion->usuarioAdministrador->data['personal']['primerApellido'],
          'segundoApellido' => $this->asignacion->usuarioAdministrador->data['personal']['segundoApellido'],
        ],
        'subAdministrador' => [
          'documento' => $this->asignacion->numeroDocumentosubAdministradorpuntoVenta,
          'nombres' => $this->asignacion->usuarioSubAdministrador->data['personal']['nombres'],
          'primerApellido' => $this->asignacion->usuarioSubAdministrador->data['personal']['primerApellido'],
          'segundoApellido' => $this->asignacion->usuarioSubAdministrador->data['personal']['segundoApellido'],
        ],
        'estado' => $this->asignacion->estado,
        'fechaAsignacion' => $this->asignacion->fechaAsignacion
      ];
      $response['asignacion'] = $asignacion;
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

          if (!isset($categorias[$idCategoria]['totalesVariables'][$idVariable])) {
              $categorias[$idCategoria]['totalesVariables'][$idVariable] = 0;
          }

          $categorias[$idCategoria]['totalesVariables'][$idVariable] += $calificacionAsignacion->valor;

          if (!isset($categorias[$idCategoria]['totalesUnidadesNegocio'][$calificacionAsignacion->IdAgrupacion])) {
              $categorias[$idCategoria]['totalesUnidadesNegocio'][$calificacionAsignacion->IdAgrupacion] = 0;
          }

          $categorias[$idCategoria]['totalesUnidadesNegocio'][$calificacionAsignacion->IdAgrupacion] += $calificacionAsignacion->valor;
      }
      foreach ($categorias as $keyCategoria => $categoria) {
        $cantidadUnidadesNegocio = count($categoria['totalesUnidadesNegocio']);
        $cantidadVariables = count($categoria['totalesVariables']);
        $promediosUnidadesNegocio = [];
        $promediosVariables = [];
        foreach ($categoria['totalesUnidadesNegocio'] as $keyUnidad => $totalUnidadNegocio) {
          $promediosUnidadesNegocio[$keyUnidad] = $totalUnidadNegocio / $cantidadVariables;
        }
        foreach ($categoria['totalesVariables'] as $keyVariable => $totalVariable) {
          $promediosVariables[$keyVariable] = $totalVariable / $cantidadUnidadesNegocio;
        }
        $categorias[$keyCategoria]['promediosUnidadesNegocio'] = $promediosUnidadesNegocio;
        $categorias[$keyCategoria]['promediosVariables'] = $promediosVariables;
      }
      $response['categorias'] = $categorias;
      $reporteEspacios = $this->generarDatosEspacios();
      $response['reporteEspacios'] = $reporteEspacios['unidadesNegocio'];
      $response['calificacionFinal'] = $reporteEspacios['calificacionFinal'];
      return $response;
    }

    public function generarDatosEspacios()
    {
      $idAsignacion = $this->asignacion->idAsignacion;
      $idComercial = $this->asignacion->idComercial;
      $espacios = [];
      $porcentajesUnidades = [];
      $porcentajesReales = PorcentajeUnidad::find()
        ->where(['idAsignacion' => $idAsignacion])
        ->all();
      foreach ($porcentajesReales as $porcentaje) {
        $porcentajesUnidades[$porcentaje->idAgrupacion] = $porcentaje->porcentaje;
      }
      // VarDumper::dump($porcentajesUnidades, 10, true); exit();
        
      $datos = Espacio::find()
        ->joinWith('porcentaje p')
        ->joinWith('variable v')
        ->joinWith('variable.calificaciones c')
        ->joinWith('variable.calificaciones.asignacion a')
        ->where(['c.idAsignacion' => $idAsignacion])
        ->andWhere(['p.idComercial' => $idComercial])
        ->all();
         // var_dump($datos->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

      // \yii\helpers\VarDumper::dump($datos,10,true); exit();
      // VarDumper::dump($datos, 10, true); exit();
      $unidadesNegocio = [];
      $sumaCalificacionUnidad = 0;

      foreach ($datos as $dato) {
        $variable = $dato->variable;
        $calificaciones = $variable->calificaciones;
        $porcentaje = $dato->porcentaje;
        foreach ($calificaciones as $calificacion) {
          $espacio = [];
          $idAgrupacion = $calificacion->IdAgrupacion;
          $idVariable = $calificacion->idVariable;
          $espacio['nombre'] = $variable->nombre;
          $espacio['idCalificacion'] = $calificacion->idCalificacion;
          $espacio['valor'] = $calificacion->valor;
          $espacio['porcentaje'] = $porcentaje->valor;
          if (!is_null($idAgrupacion)) {
            if (!isset($unidadesNegocio[$idAgrupacion])) {
              $unidadesNegocio[$idAgrupacion]['nombreUnidadNegocio'] = $calificacion->nombreUnidadNegocio;
            }
            if (!isset($unidadesNegocio[$idAgrupacion]['espacios'][$idVariable])) {
              $unidadesNegocio[$idAgrupacion]['espacios'][$idVariable] = $espacio;
            }
            if (!isset($unidadesNegocio[$idAgrupacion]['resultadoUnidadNegocio'])) {
              $unidadesNegocio[$idAgrupacion]['resultadoUnidadNegocio'] = 0;
            }
            $unidadesNegocio[$idAgrupacion]['resultadoUnidadNegocio'] += $calificacion->valor * ($porcentaje->valor / 100);
            $unidadesNegocio[$idAgrupacion]['porcentajeUnidad'] = $porcentajesUnidades[$idAgrupacion];
            $sumaCalificacionUnidad += ($calificacion->valor * ($porcentaje->valor / 100) * ($porcentajesUnidades[$idAgrupacion] / 100));
          }
        }
      }
      // $unidadesNegocio['calificacionFinal'] = $sumaCalificacionUnidad;
      return ['unidadesNegocio' => $unidadesNegocio, 'calificacionFinal' => $sumaCalificacionUnidad];
    }

    /**
     * consulta un modelo AsignacionPuntoVenta segun el valor de su llave primaria
     * @return modelo AsignacionPuntoVenta
     */
    private function consultarAsignacion($idAsignacion)
    {
        $this->asignacion = AsignacionPuntoVenta::find()->alias('t')
            ->where('t.idAsignacion=:asignacion', [':asignacion' => $idAsignacion])
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
             $modelo = Observaciones::find()->where(['idAsignacion' => $this->asignacion->idAsignacion, 'idVariable' => $variable->idVariable])->one();
             if ($modelo !== null) {
               array_push($modelosObservacion, $modelo);
             }else{
               array_push($modelosObservacion, new Observaciones);
             }
         }
       }

       return $modelosObservacion;
   }
}

?>
