<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use app\modules\intranet\models\Documento;
use app\modules\intranet\models\LogDocumento;
use app\modules\intranet\models\CategoriaDocumento;
use app\modules\intranet\models\CategoriaDocumentoDetalle;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class CategoriaDocumentoController extends \yii\web\Controller {

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                   'admin', 'index'
                 ],
                 'authsActions' => [
                     //colocar los permisos
                      'admin' => 'intranet_categoria-documento_admin',
                      'index' => 'intranet_usuario'
                 ]
             ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Muesrtra el menu de los documentos
     * @param
     * @return mixed
     */
    public function actionIndex() {
        $padres = CategoriaDocumento::getPadres();
        $html = $this->crearMenuDocumentos($padres, ' ');
        return $this->render('index', ['menu' => $html]);
    }

    /**
     * Funcion auxiliar recursiva donde se crea el menu para el usuario normal
     * @param $arrayCategoriasDocumento = arreglo con los elementos de un categoria del menu,
     * $html = string con el codigo html del menu que se va gerenando
     * $flagAdmin = bandera que indica si es la vista administrador o no
     * @return $html = string con todo el codigo html del menu
     */
    public function crearMenuDocumentos($arrayCategoriasDocumento, $html) {

        if (empty($arrayCategoriasDocumento)) {

            $html = $html . '';
        } else {
            foreach ($arrayCategoriasDocumento as $categoria) {


                $hijos = CategoriaDocumento::getHijos($categoria->idCategoriaDocumento);

                if (!empty($hijos)) {
                    $html = $this->RenderCategoria($categoria, $hijos, false, $html);
                } else {
                    $html = $this->RenderCategoria($categoria, $hijos, true, $html);
                }
            }
        }
        return $html;

    }

    public function RenderCategoria($categoria, $hijos, $flagHoja, $html) {

        $htmlEnlace = '<a href="#'. $categoria->idCategoriaDocumento .'" class="list-group-item" data-toggle="collapse">
          <i class="glyphicon glyphicon-chevron-right"></i>' . $categoria->nombre . '
          </a>';

        // crea los elementos html dependiendo si la categoria tiene un documento asociado
        if (!is_null($categoria->categoriaDocumentosDetalle)) {

            if ($flagHoja) {
                $htmlEnlace = Html::a($categoria->nombre, ['documento/detalle-documento',
                'id' => $categoria->categoriaDocumentosDetalle->idDocumento], ['class' => 'list-group-item',
                ]);
            }
        } else {

            if ($flagHoja) {
              $htmlEnlace = Html::a($categoria->nombre .' (No hay un documento asociado)',
              ['#'],
              ['class' => 'list-group-item','data-toggle' => 'collapse']);
            }
        }

        $html = $html .
                        '
                        '. $htmlEnlace . '
                        <div class="list-group collapse" id="'. $categoria->idCategoriaDocumento.'">
                        ' . $this->crearMenuDocumentos($hijos, '') . '
                        </div>';

        return $html;
    }


    /**
     * Funcion auxiliar donde se va creando el string con el html del menu
     * @param $categoria = modelo CategoriaDocumento
     * $hijos = arreglo de modelos CategoriaDocumento cuyo padre es categoria
     * $html = string con el codigo html del menu que se va gerenando
     * $flagHoja = bandera que indica si el elemento es una hoja o no
     * @return $html = string con todo el codigo html del menu
     */

    /**
     * renderiza la vista del administrador para realizar acciones sobre el menu de las categorias
     * @param none
     * @return mixed
     */
    public function actionAdmin() {
        $padres = CategoriaDocumento::getPadres();
        $html = $this->crearMenuDocumentosAdmin($padres);
        return $this->render('administrar-categorias-documento', ['menu' => $html]);
    }

    public function crearMenuDocumentosAdmin($arrayCategoriasDocumento)
    {
      $opcionArray = [];

      foreach ($arrayCategoriasDocumento as $categoria) {
        $opcionArray[] = self::obtenerHijosArrayAdmin($categoria);
      }

      return $opcionArray;
    }

    public static function obtenerHijosArrayAdmin($objCategoria) {

      $hijos = CategoriaDocumento::getHijos($objCategoria->idCategoriaDocumento);

      $htmlCrearCategoria = '<button class="btn btn-mini" data-role="categoria-crear" data-padre="' . $objCategoria->idCategoriaDocumento . '"
      class="btn btn-mini btn-success">
      crear categoria
      </button>';

      $htmlEditaCategoria = '<button class="btn btn-mini" data-role="categoria-editar" data-categoria="' . $objCategoria->idCategoriaDocumento . '"
      class="btn btn-mini btn-success">
      editar categoria
      </button>';

      if (!empty($hijos)) {

        $children = [];

        foreach ($hijos as $objSubmenu) {
            $children[] = self::obtenerHijosArrayAdmin($objSubmenu);
        }

        return ['title' => "
        <div class='panel-default panel-menu'>
          <div class=' panel-heading'>
            <h6 class='panel-title' style='font-size: 13px;'>
              <a href='#'>
                $objCategoria->nombre
              </a>
            </h6>
            $htmlCrearCategoria
            $htmlEditaCategoria
          </div>
        </div>", 'children' => $children, 'folder' => true];

      }else{
        $htmlRelaciona = '';
        // crea los elementos html dependiendo si la categoria tiene un documento asociado
        if (!is_null($objCategoria->categoriaDocumentosDetalle)) {
          $htmlRelaciona = '<button class="btn btn-mini" data-role="no-relaciona-documento"
          // este va si es admin y hoja y si tiene un documento relacionado
          data-categoria="' . $objCategoria->idCategoriaDocumento . '"
          data-documento="' . $objCategoria->categoriaDocumentosDetalle->idDocumento . '"
          class="btn btn-mini btn-success">
          quitar relacion
          </button>';
        }else{
          // este va si es admin y hoja y no tiene un documento relacionado
          $htmlRelaciona = '<button class="btn btn-mini" data-categoria="' . $objCategoria->idCategoriaDocumento . '"
        data-role="relaciona-documento" class="btn btn-mini btn-success">
        relacionar documento
        </button>';
        }

        return ['title' => "
        <div class='panel-default panel-submenu'>
          <div class=' panel-heading'>
            <h6 class='panel-title' style='font-size: 13px;'>
              $objCategoria->nombre
            </h6>
            $htmlCrearCategoria
            $htmlEditaCategoria
            $htmlRelaciona
          </div>
        </div> "];
      }
    }

    /**
     * Renderiza el modal donde se podra crear una categoria
     * @param none
     * @return mixed
     */
    public function actionRenderCrearCategoria() {
        $model = new CategoriaDocumento();

        $categoriaPadre = Yii::$app->request->post('categoriaPadre', NULL);

        $categorias = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalCategoria', [
                'model' => $model,
                'categoriaPadre' => $categoriaPadre
            ])
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $categorias;
    }

    /**
     * Renderiza el modal donde se podra editar una categoria
     * @param none
     * @return mixed
     */
    public function actionRenderEditarCategoria($id) {
        $model = $this->findModel($id);

        $categorias = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalCategoria', [
                'model' => $model,
                'categoriaPadre' => ''
            ])
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $categorias;
    }

    /**
     * crea un nuevo modelo CategoriaDocumento
     * @param none
     * @return mixed
     */
    public function actionCrearCategoria() {
        $model = new CategoriaDocumento();
        $categorias = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $padres = CategoriaDocumento::getPadres();
            $html = $this->crearMenuDocumentos($padres, ' ', true);
            $categorias = [
                'result' => 'ok',
                'response' => $this->renderAjax('administrar-categorias-documento', [
                    'menu' => $html
                ])
            ];
        } else {
            $categorias = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalCategoria', [
                    'model' => $model,
                    'categoriaPadre' => $model->idCategoriaPadre
                ])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $categorias;
    }

    /**
     * Actualiza un modelo CategoriaDocumento existente
     * @param id
     * @return mixed
     */
    public function actionActualizarCategoria($id) {
        $model = $this->findModel($id);
        $categorias = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $padres = CategoriaDocumento::getPadres();
            $html = $this->crearMenuDocumentos($padres, ' ', true);
            $categorias = [
                'result' => 'ok',
                'response' => $this->renderAjax('administrar-categorias-documento', [
                    'menu' => $html
                ])
            ];
        } else {

            $categorias = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalCategoria', [
                    'model' => $model,
                    'categoriaPadre' => ''
                ])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $categorias;
    }

    /**
     * Elimina un modelo CategoriaDocumentoDetalle que es donde se guarda la relacion entre los modelos CategoriaDocumento y Documento
     * Si la eliminacion es correcta renderiza de nuevo la pagina
     * @param string $idCategoria, string idDocumento
     * @return el html con la vista administrar-categorias-documento
     */
    public function actionEliminarRelacionDocumento() {
        $idCategoria = Yii::$app->request->post('idCategoria', NULL);
        $idDocumento = Yii::$app->request->post('idDocumento', NULL);

        $categoriaDocumentoDetalle = CategoriaDocumentoDetalle::getRelacionCategoriaDocumento($idCategoria, $idDocumento);

        $categorias = [];

        if ($categoriaDocumentoDetalle->delete()) {

            $padres = CategoriaDocumento::getPadres();
            $html = $this->crearMenuDocumentos($padres, ' ', true);
            $categorias = [
                'result' => 'ok',
                'response' => $this->renderAjax('administrar-categorias-documento', [
                    'menu' => $html
                ])
            ];
        } else {

            $padres = CategoriaDocumento::getPadres();
            $html = $this->crearMenuDocumentos($padres, ' ', true);
            $categorias = [
                'result' => 'error',
                'response' => $this->renderAjax('administrar-categorias-documento', [
                    'menu' => $html
                ])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $categorias;
    }

    /**
     * Renderiza el modal con el formulario para relacionar un Documento y un CategoriaDocumento
     * @param string $idCategoria
     * @return el html con la vista del modal
     */
    public function actionRenderRelacionarDocumento() {
        $idCategoriaDocumento = Yii::$app->request->post('idCategoria', NULL);
        $listaDocumentos = ArrayHelper::map(Documento::getTodosDocumento(), 'idDocumento', 'titulo');
        $model = new CategoriaDocumentoDetalle();

        $categorias = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalRelacionDocumento', [
                'model' => $model,
                'listaDocumentos' => $listaDocumentos,
                'idCategoriaDocumento' => $idCategoriaDocumento
            ])
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $categorias;
    }

    /**
     * Crea un modelo CategoriaDocumentoDetalle donde se relaciona los modelos Documento y un CategoriaDocumento
     * @param none
     * @return el html con la vista administrar-categorias-documento
     */
    public function actionGuardarRelacionDocumento() {
        $model = new CategoriaDocumentoDetalle();

        if ($model->load(Yii::$app->request->post())) {

            $model->contenido = ' \n ';

            if ($model->save()) {

                $padres = CategoriaDocumento::getPadres();
                $html = $this->crearMenuDocumentos($padres, ' ', true);
                $categorias = [
                    'result' => 'ok',
                    'response' => $this->renderAjax('administrar-categorias-documento', [
                        'menu' => $html
                    ])
                ];
            } else {
                $listaDocumentos = ArrayHelper::map(Documento::getTodosDocumento(), 'idDocumento', 'titulo');
                $categorias = [
                    'result' => 'error',
                    'response' => $this->renderAjax('_modalRelacionDocumento', [
                        'model' => $model,
                        'listaDocumentos' => $listaDocumentos,
                        'idCategoriaDocumento' =>  $model->idCategoriaDocumento
                    ])
                ];
            }
        } else {

            $padres = CategoriaDocumento::getPadres();
            $html = $this->crearMenuDocumentos($padres, ' ', true);
            $categorias = [
                'result' => 'error',
                'response' => $this->renderAjax('administrar-categorias-documento', [
                    'menu' => $html
                ])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $categorias;
    }

    /**
     * Renderiza la plantilla del documento cuando selecciona uno mientras relaciona un CategoriaDocumento con Documento
     * @param string $idDocumento
     * @return el html con la vista de la plantilla
     */
    public function actionPlantillaDocumento($idDocumento) {
        $model = Documento::findOne($idDocumento);
        $categorias = [
            'result' => 'ok',
            'response' => $this->renderAjax('_plantillaDocumento', [
                'model' => $model
            ])
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $categorias;
    }

    /**
     * Encuentra un modelo CategoriaDocumento basado en su llave primaria.
     * Si el modelo no se encuentra se lanza una excepcion 404 HTTP exception.
     * @param string $id
     * @return modelo Documento
     * @throws NotFoundHttpException si no encuentra el modelo
     */
    protected function findModel($id) {
        if (($model = CategoriaDocumento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
