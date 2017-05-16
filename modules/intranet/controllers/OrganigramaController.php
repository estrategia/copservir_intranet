<?php

namespace app\modules\intranet\controllers;

use Yii;
// use app\models\Tree;
// use app\models\Node;
use yii\helpers\Json;
use yii\httpclient\Client;

class OrganigramaController extends \yii\web\Controller
{
    public $datos = [
      'Empleado' => [
          'NumeroDocumento' => "6341008",
          'Nombre' => "TORRES ALVARO",
          'Cargo' => "001328 - JEFE DE DESARROLLO"
      ],
      'Jefe' => [
          'NumeroDocumento' => "94504074",
          'Nombre' => "TORRES CORDOBA CAMILO",
          'Cargo' => "001213 - DIRECTOR DE SISTEMAS DE INFORMACION"
      ],
      'Pares' => [
        [
          'NumeroDocumento' => "80113523",
          'Nombres' => "SOLANO SOLER CARLOS ALBERTO",
          'Cargo' => "001305 - JEFE DE CENTRO DE COMPUTO",
          'Estado' => "ACTIVO",
          'CentroCostos' => "520400"
        ]
      ],
      'Colaboradores' => [
        [
          'NumeroDocumento' => "1112474925",
          'Nombres' => "SANDOVAL VELEZ JORGE ENRIQUE",
          'Cargo' => "001611 - ANALISTA PROGRAMADOR",
          'Estado' => "ACTIVO",
          'CentroCostos' => "520400"
        ],
        [
          'NumeroDocumento' => "1114822370",
          'Nombres' => "RODRIGUEZ ARENAS JUAN MANUEL",
          'Cargo' => "001611 - ANALISTA PROGRAMADOR",
          'Estado' => "ACTIVO",
          'CentroCostos' => "520400"
        ],
        [
          'NumeroDocumento' => "1115077981",
          'Nombres' => "LINCE PINEDA ANDRES FELIPE",
          'Cargo' => "001611 - ANALISTA PROGRAMADOR",
          'Estado' => "ACTIVO",
          'CentroCostos' => "520400"
        ],
        [
          'NumeroDocumento' => "1116247424",
          'Nombres' => "MONEDERO POSSO OSCAR ALEJANDRO",
          'Cargo' => "001611 - ANALISTA PROGRAMADOR",
          'Estado' => "ACTIVO",
          'CentroCostos' => "520400"
        ]
      ]
    ];

    public $nodo = [
      'numeroDocumento' => 12345,
      'text' => [
        'title' => 'juan',
        'name' => 'ing junior'
      ],
      'children' => []
    ];

    public $nodos = [
      [
        'numeroDocumento' => 12345,
        'text' => [
          'title' => 'juan',
          'name' => 'ing junior',
          'HTMLid' => 12345,
        ],
        'children' => []
      ],
      [
        'numeroDocumento' => 23456,
        'text' => [
          'title' => 'pepe',
          'name' => 'ing junior',
        ],
        'HTMLid' => 23456,
        'children' => []
      ]
    ];


    public function actionIndex()
    {
        return $this->render('index');
    }

    // public function actionCrearArbol()
    // { 
    //   $jefe = $this->datos['Jefe'];
    //   $empleado = $this->datos['Empleado'];
    //   $pares = $this->datos['Pares'];
    //   $colaboradores = $this->datos['Colaboradores'];
    //   $arbol = new Tree();
    //   $nodoJefe = new Node($jefe['NumeroDocumento'], $jefe);
    //   $arbol->setRoot($nodoJefe);
    //   $nodoEmpleado = new Node($empleado['NumeroDocumento'], $empleado);
    //   $nodoJefe->addChild($nodoEmpleado);
    //   $nodoJefe->insertDataArrayAsChildren($pares, 'NumeroDocumento');
    //   $arbol->insertDataArrayAsChildrenById(6341008, $colaboradores, 'NumeroDocumento');

    //   \yii\helpers\VarDumper::dump($arbol, 10, true);
    // }

    public function actionConsultar()
    {
      // if (is_null(Yii::$app->session->get(Yii::$app->params['organigrama']))) {
        Yii::$app->session->set(Yii::$app->params['organigrama'], $this->formatearJSON($this->datos));
      // }
      // $nuevo = $this->insertarNodos($organigrama, $this->nodos, 80113523);
      // $nuevo = $this->insertarNodo($nuevo, $this->nodo, 12345);
      // $response = ['result' => 'ok', 'response' => $this->nested_values($organigrama)];
      $response = ['result' => 'ok', 'response' => Yii::$app->session->get(Yii::$app->params['organigrama'])];
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return $response;
    }

    public function actionColaboradores($numeroDocumento)
    {
      $organigrama = Yii::$app->session->get(Yii::$app->params['organigrama']);
      $organigrama = $this->insertarNodos($organigrama, $this->nodos, $numeroDocumento);
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
      $colaboradores = $organigrama['Colaboradores'];
      $nodeStructure = [
        'numeroDocumento' => $jefe['NumeroDocumento'],
        'text' => [
          'title' => $jefe['Nombre'],
          'name' => $jefe['Cargo'],
        ],
        'HTMLid' => $jefe['NumeroDocumento'],
        'children' => []
      ];
      $nodeStructure['children'][] = [
        'numeroDocumento' => $empleado['NumeroDocumento'],
        'text' => [
          'title' => $empleado['Nombre'],
          'name' => $empleado['Cargo'],
        ],
        'HTMLid' => $empleado['NumeroDocumento'],
        'children' => []
      ];
      foreach ($pares as $par) {
        $nodeStructure['children'][] = [
          'numeroDocumento' => $par['NumeroDocumento'],
          'text' => [
            'title' => $par['Nombres'],
            'name' => $par['Cargo'],
          ],
          'HTMLid' => $par['NumeroDocumento'],
          'children' => []
        ];
      }
      return $nodeStructure;
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
        'timeout' => 5,
      ])
      ->send();
      $infoEmpleado = JSON::decode($wsResponse->content);
      var_dump($infoEmpleado);
    }

}
?>