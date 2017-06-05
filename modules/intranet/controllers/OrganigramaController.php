<?php

namespace app\modules\intranet\controllers;

use Yii;
// use app\models\Tree;
// use app\models\Node;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\httpclient\Client;
use app\models\Usuario;

class OrganigramaController extends \yii\web\Controller
{
    public $datos = [
      'Empleado' => [
          'NumeroDocumento' => "1115077082",
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

    public $datos2 = [
      'Empleado' => [
          'NumeroDocumento' => "94504074",
          'Nombre' => "TORRES CORDOBA CAMILO",
          'Cargo' => "001213 - DIRECTOR DE SISTEMAS DE INFORMACION"
      ],
      'Jefe' => [
          'NumeroDocumento' => "1234",
          'Nombre' => "PEPETO",
          'Cargo' => "001213 - DIRECTOR GENERAL"
      ],
      'Pares' => [
        [
          'NumeroDocumento' => "8765",
          'Nombres' => "POPEYE",
          'Cargo' => "001328 - JEFE DE DESARROLLO",
          'Estado' => "ACTIVO",
          'CentroCostos' => "520400"
        ],
      ],
      'Colaboradores' => [
        [
          'NumeroDocumento' => "6341008",
          'Nombres' => "TORRES ALVARO",
          'Cargo' => "001328 - JEFE DE DESARROLLO",
          'Estado' => "ACTIVO",
          'CentroCostos' => "520400"
        ],
        [
          'NumeroDocumento' => "80113523",
          'Nombres' => "SOLANO SOLER CARLOS ALBERTO",
          'Cargo' => "001305 - JEFE DE CENTRO DE COMPUTO",
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
        ],
        'HTMLid' => 12345,
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

    public function actionPerfil($numeroDocumento)
    {
      $usuario = Usuario::callWSInfoPersona($numero);
      // \yii\helpers\VarDumper::dump($usuario, 10, true);
      return $this->renderAjax('_modalPerfil', ['usuario' => $usuario]);
    }

    public function actionConsultar()
    {
      // if (is_null(Yii::$app->session->get(Yii::$app->params['organigrama']))) {
        $numero = 80113523;
        $datos = $this->consultarWS($numero);
      //   Yii::$app->session->set(Yii::$app->params['organigrama'], $this->formatearJSON($datos));
      // // }
      // $response = ['result' => 'ok', 'response' => Yii::$app->session->get(Yii::$app->params['organigrama'])];
      // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return $datos;
    }

    public function actionColaboradores($numeroDocumento)
    {
      $organigrama = Yii::$app->session->get(Yii::$app->params['organigrama']);
      if ($numeroDocumento == $organigrama['numeroDocumento']) {
        $organigrama = $this->fusionarArboles($organigrama, $this->formatearJSON($this->datos2), $organigrama['numeroDocumento']);
      } else { 
        $organigrama = $this->insertarNodos($organigrama, $this->nodos, $numeroDocumento);
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
      $colaboradores = $organigrama['Colaboradores'];
      $numerosDocumento = ArrayHelper::getColumn($colaboradores, 'NumeroDocumento');
      $numerosDocumento[] = $jefe['NumeroDocumento'];
      $numerosDocumento[] = $empleado['NumeroDocumento'];
      $usuarios = Usuario::find()->where(['numeroDocumento' => $numerosDocumento])->all();
      $imagenes = ArrayHelper::map($usuarios, 'numeroDocumento', 'imagenPerfil');
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
      foreach ($pares as $par) {
        $nodeStructure['children'][] = [
          'numeroDocumento' => $par['NumeroDocumento'],
          'innerHTML' => $this->renderPartial('_nodo', [
            'empleado' => $empleado, 
            'imagen' => $this->getImagenPerfil($par['NumeroDocumento'], $imagenes)
          ]),
          'HTMLid' => $par['NumeroDocumento'],
          'children' => []
        ];
      }
      $numeroDocumento = $empleado['NumeroDocumento'];
      $colaboradoresFormateados = $this->formatearNodos($colaboradores);
      $nodeStructure = $this->insertarNodos($nodeStructure, $colaboradoresFormateados, $numeroDocumento);
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
      var_dump($infoEmpleado);
    }

}
?>