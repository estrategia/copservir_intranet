<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\httpclient\Client;
use app\models\Usuario;

class OrganigramaController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPerfil($numeroDocumento)
    {
      $usuario = Usuario::callWSInfoPersona($numeroDocumento);
      $rutaImagenes = Yii::getAlias('@web').'/img/fotosperfil/';
      $rutaImagen = "no-image.png";
      if (!is_null($usuario) && !empty($usuario)) {
        $usuarioBd = Usuario::find()->where(['numeroDocumento' => $numeroDocumento])->one();
        if (!is_null($usuarioBd)) {
          if ($usuarioBd->imagenPerfil != '') {
            $rutaImagen = $usuarioBd->imagenPerfil;
          }
        }
      }
/*      \yii\helpers\VarDumper::dump($usuario,10,true);
      exit(0);*/
      return $this->renderAjax('_modalPerfil', ['usuario' => $usuario, 'imagen' => $rutaImagenes . $rutaImagen]);
    }

    public function actionConsultar()
    {
      $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
      $numero = 91177297;
      $data = $this->consultarWS($numero);
      $datos = $this->formatearJSON($data);
      Yii::$app->session->set(Yii::$app->params['organigrama'], $datos);
      $response = ['result' => 'ok', 'response' => Yii::$app->session->get(Yii::$app->params['organigrama'])];
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return $response;
    }

    public function actionColaboradores($numeroDocumento)
    {
      $organigrama = Yii::$app->session->get(Yii::$app->params['organigrama']);
      $datos = [];
      if ($numeroDocumento == $organigrama['numeroDocumento']) {
        $datos = $this->formatearJSON($this->consultarWS($numeroDocumento));
        if (!empty($datos)) {
          $organigrama = $this->fusionarArboles($organigrama, $datos, $organigrama['numeroDocumento']);
        }
      } else { 
        $datos = $this->consultarWS($numeroDocumento);
        if ($datos != null && !empty($datos)) {
          if (isset($datos['Colaboradores'])) {
            $datos = $this->formatearNodos($datos['Colaboradores']);
            $organigrama = $this->insertarNodos($organigrama, $datos, $numeroDocumento);
          }
        }
      }
      Yii::$app->session->set(Yii::$app->params['organigrama'], $organigrama);
      $response = ['result' => 'ok', 'response' => $organigrama];
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return $response;
    }

    private function formatearJSON($organigrama)
    {
      $jefe = $organigrama['Jefe'];
      $empleado = $organigrama['Empleado'];
      $pares = $organigrama['Pares'];
      $colaboradores = [];
      if (isset($organigrama['Colaboradores'])) {
        $colaboradores = $organigrama['Colaboradores'];
        $numerosDocumento = ArrayHelper::getColumn($colaboradores, 'NumeroDocumento');
      }
      $numerosDocumento[] = $jefe['NumeroDocumento'];
      $numerosDocumento[] = $empleado['NumeroDocumento'];
      $usuarios = Usuario::find()->where(['numeroDocumento' => $numerosDocumento])->all();
      $imagenes = ArrayHelper::map($usuarios, 'numeroDocumento', 'imagenPerfil');
      if ($jefe['NumeroDocumento'] == null) {
        $jefe['NumeroDocumento'] = 1;
        $jefe['Nombre'] = '';
      }
      $nodeStructure = [
        'numeroDocumento' => $jefe['NumeroDocumento'],
        'innerHTML' => $this->renderPartial('_nodo', [
          'empleado' => $jefe, 
          'imagen' => $this->getImagenPerfil($jefe['NumeroDocumento'], $imagenes)
        ]),
        'HTMLid' => $jefe['NumeroDocumento'],
        'children' => []
      ];
      $nodeStructure['children'][] = [
        'numeroDocumento' => $empleado['NumeroDocumento'],
        'innerHTML' => $this->renderPartial('_nodo', [
          'empleado' => $empleado, 
          'imagen' => $this->getImagenPerfil($empleado['NumeroDocumento'], $imagenes)
        ]),
        'HTMLid' => $empleado['NumeroDocumento'],
        'children' => []
      ];
      if (!empty($pares)) {
        foreach ($pares as $par) {
          $nodeStructure['children'][] = [
            'numeroDocumento' => $par['NumeroDocumento'],
            'innerHTML' => $this->renderPartial('_nodo', [
              'empleado' => $par, 
              'imagen' => $this->getImagenPerfil($par['NumeroDocumento'], $imagenes)
            ]),
            'HTMLid' => $par['NumeroDocumento'],
            'children' => []
          ];
        }
      }
      if (isset($colaboradores)) {
        $numeroDocumento = $empleado['NumeroDocumento'];
        $colaboradoresFormateados = $this->formatearNodos($colaboradores);
        $nodeStructure = $this->insertarNodos($nodeStructure, $colaboradoresFormateados, $numeroDocumento);
      }
      return $nodeStructure;
    }

    private function getImagenPerfil($numeroDocumento, $imagenes)
    {
      $rutaBase = Yii::getAlias('@web').'/img/fotosperfil/';
      if (isset($imagenes[$numeroDocumento])) {
        return $rutaBase . $imagenes[$numeroDocumento];
      } else {
        return $rutaBase . "no-image.png";
      }
    }

    private function formatearNodos($arregloNodos) 
    {
      $nodos = [];
      $numerosDocumento = ArrayHelper::getColumn($arregloNodos, 'NumeroDocumento');
      $usuarios = Usuario::find()->where(['numeroDocumento' => $numerosDocumento])->all();
      $imagenes = ArrayHelper::map($usuarios, 'numeroDocumento', 'imagenPerfil');

      foreach($arregloNodos as $key => $nodo) {
        $nombres = '';
        if (isset($nodo['Nombres'])) {
          $nombres = $nodo['Nombres'];
        } else {
          $nombres = $nodo['Nombre'];
        }

        $nodos[] = [
        'numeroDocumento' => $nodo['NumeroDocumento'],
          'innerHTML' => $this->renderPartial('_nodo', [
            'empleado' => $nodo, 
            'imagen' => $this->getImagenPerfil($nodo['NumeroDocumento'], $imagenes)
          ]),
          'HTMLid' => $nodo['NumeroDocumento'],
          'children' => []
        ];
      }
      return $nodos;
    }

    private function insertarNodo($organigrama, $nodo, $numeroDocumento)
    {
      $paths = $this->getRutasArray($organigrama);
      $path = array_search($numeroDocumento, $paths);
      $pathArray = explode('/', $path);
      array_splice($pathArray, -1);
      $pathArray[] = 'children';
      $temp = &$organigrama;
      foreach($pathArray as $key) {
        $temp = &$temp[$key];
      }
      $temp[] = $nodo;
      return $organigrama;
    }

    private function insertarNodos($organigrama, $nodos, $numeroDocumento)
    {
      $paths = $this->getRutasArray($organigrama);
      $path = array_search($numeroDocumento, $paths);
      $pathArray = explode('/', $path);
      array_splice($pathArray, -1);
      $pathArray[] = 'children';
      $temp = &$organigrama;
      foreach($pathArray as $key) {
        $temp = &$temp[$key];
      }
      $temp = $nodos;
      return $organigrama;
    }

    private function fusionarArboles($organigrama1, $organigrama2, $numeroDocumento)
    {
      $hijosInsertar = $organigrama1['children'];
      $numeroDocumento = $organigrama1['numeroDocumento'];
      $organigramaFinal = $this->insertarNodos($organigrama2, $hijosInsertar, $numeroDocumento);
      return $organigramaFinal;
    }

    private function getRutasArray($array, $path="") {
      $output = array();
      foreach($array as $key => $value) {
          if(is_array($value)) {
              $output = array_merge($output, $this->getRutasArray($value, (!empty($path)) ? $path.$key."/" : $key."/"));
          }
          else $output[$path.$key] = $value;
      }
      return $output;
    }

    private function consultarWS($numeroDocumento)
    {
      $client = new Client();
      $urlOrganigrama = Yii::$app->params['webServices']['organigrama'] . "/{$numeroDocumento}";
      $wsResponse = $client->createRequest()
      ->setMethod('get')
      ->setUrl($urlOrganigrama)
      ->setData([''])
      ->setOptions([
        'timeout' => 10,
      ])
      ->send();
      $infoEmpleado = JSON::decode($wsResponse->content);
      return $infoEmpleado;
    }

}
?>