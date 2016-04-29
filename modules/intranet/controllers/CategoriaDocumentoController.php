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

class CategoriaDocumentoController extends \yii\web\Controller
{

  /**
   * Muesrtra el menu de los documentos
   * @param
   * @return mixed
   */
    public function actionIndex()
    {
        $padres = CategoriaDocumento::getPadres();
        $html = $this->crearMenuDocumentos($padres, ' ', false);
        return $this->render('index',['menu'=>$html]);
    }


    /**
     * Funcion auxiliar recursiva donde se crea el menu para el usuario normal
     * @param $arrayCategoriasDocumento = arreglo con los elementos de un categoria del menu,
     * $html = string con el codigo html del menu que se va gerenando
     * $flagAdmin = bandera que indica si es la vista administrador o no
     * @return $html = string con todo el codigo html del menu
     */
    public function crearMenuDocumentos($arrayCategoriasDocumento, $html, $flagAdmin)
    {
      if (empty($arrayCategoriasDocumento)) {
        // no hay categoria CategoriaDocumento
          $html = $html.'';
      }else{
        foreach ($arrayCategoriasDocumento as $categoria) {

          // se Consultan los hijos del elemento
          $hijos = CategoriaDocumento::getHijos($categoria->idCategoriaDocumento);

          if (!empty($hijos)) { // ese elemento tiene hijos
            $html = $this->RenderCategoria($categoria, $hijos, false, $html, $flagAdmin);

            }else{ // ese elemento no tiene hijos
              $html = $this->RenderCategoria($categoria, $hijos, true, $html, $flagAdmin);
            }
          }
        }
        return $html;
    }

    public function RenderCategoria($categoria, $hijos, $flagHoja, $html, $flagAdmin)
    {
      // se acomoda el data-parent para indicar las dependencias
      // del acordeon dependiendo si es raiz o hijo
      $dataparent = '';
      if (is_null($categoria->idCategoriaPadre)) {
          $dataparent = 'accordion';
      }else{
          $dataparent = $categoria->idCategoriaDocumento;
      }

      // variables para almacenar diferentes elementos html
      $htmlEnlace = '<a href="#'.$categoria->idCategoriaDocumento.'" data-parent="#'.$dataparent.'" data-toggle="collapse">
                      '.$categoria->nombre.'
                    </a>';
      $htmlRelaciona = '';
      $htmlCrearCategoria = '';
      $htmlEditaCategoria = '';

      // crea los elementos html para crear y editar si viene de la vista administrador
      if ($flagAdmin) {

        $htmlCrearCategoria = '<button href="#" data-role="categoria-crear" data-padre="'.$categoria->idCategoriaDocumento.'"
                                data-parent="#'.$dataparent.'"  class="btn btn-mini btn-success">
                                crear categoria
                              </button><br><br>';

        $htmlEditaCategoria = '<button href="#" data-role="categoria-editar" data-categoria="'.$categoria->idCategoriaDocumento.'"
                                class="btn btn-mini btn-success">
                                editar categoria
                              </button>';
      }

      // crea los elementos html dependiendo si la categoria tiene un documento asociado
      if (!is_null($categoria->categoriaDocumentosDetalle)) {

        if ($flagAdmin && $flagHoja) {
          $htmlRelaciona = '<button href="#" data-parent="#'.$dataparent.'" data-role="no-relaciona-documento"
                            data-categoria="'.$categoria->idCategoriaDocumento.'"
                            data-documento="'.$categoria->categoriaDocumentosDetalle->idDocumento.'"
                            class="btn btn-mini btn-success">
                                 quitar relacion
                            </button>';
          $htmlCrearCategoria = '';
        }

        if (!$flagAdmin && $flagHoja) {
          $htmlEnlace = Html::a($categoria->nombre, ['documento/detalle', 'id'=>$categoria->categoriaDocumentosDetalle->idDocumento], ['data-role'=>'hola']);
        }

      }else{

        if ($flagAdmin && $flagHoja) {
          $htmlRelaciona = '<button href="#" data-parent="#'.$dataparent.'" data-categoria="'.$categoria->idCategoriaDocumento.'"
                            data-role="relaciona-documento" class="btn btn-mini btn-success">
                           relacionar documento
                           </button>';
        }

        if (!$flagAdmin && $flagHoja) {
          $htmlEnlace = Html::a($categoria->nombre, ['#'], []);;
          $htmlRelaciona = '<button href="#" data-parent="#'.$dataparent.'"  class="btn btn-mini btn-success">
                                 No hay un documento asociado
                            </button>';
        }
      }

      // crea el string que contien el html del menu
      $html = $html.
      '
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
          '.$htmlEnlace.'
          </h4>
          '.$htmlEditaCategoria.'
          '.$htmlRelaciona.'
        </div>
        <div class="panel-collapse collapse" id="'.$categoria->idCategoriaDocumento.'">
          <div class="panel-body">
            '.$htmlCrearCategoria.'
            '.$this->crearMenuDocumentos($hijos, '', $flagAdmin).'
          </div>
        </div>
      </div>
      ';

      return $html;
    }

  /**
   * renderiza la vista del administrador para realizar acciones sobre el menu de las categorias
   * @param none
   * @return mixed
   */
   public function actionAdministarCategoriasDocumento()
   {
     $padres = CategoriaDocumento::getPadres();
     $html = $this->crearMenuDocumentos($padres, ' ', true);
     return $this->render('administrar-categorias-documento', ['menu'=>$html]);
   }

   /**
    * Renderiza el modal donde se podra crear una categoria
    * @param none
    * @return mixed
    */
    public function actionRenderCrearCategoria()
    {
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
     public function actionRenderEditarCategoria($id)
     {
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
      public function actionCrearCategoria()
      {
          $model = new CategoriaDocumento();
          $categorias = [];

          if ($model->load(Yii::$app->request->post()) && $model->save()) {

              $padres = CategoriaDocumento::getPadres();
              $html = $this->crearMenuDocumentos($padres, ' ', true);
              $categorias = [
                  'result' => 'ok',
                  'response' => $this->renderAjax('administrar-categorias-documento', [
                      'menu'=>$html
                  ])
              ];

          } else {

              $padres = CategoriaDocumento::getPadres();
              $html = $this->crearMenuDocumentos($padres, ' ');
              $categorias = [
                  'result' => 'error',
                  'response' => $this->renderAjax('administrar-categorias-documento', [
                      'menu'=>$html
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
   public function actionActualizarCategoria($id)
   {
       $model = $this->findModel($id);
       $categorias = [];

       if ($model->load(Yii::$app->request->post()) && $model->save()) {

           $padres = CategoriaDocumento::getPadres();
           $html = $this->crearMenuDocumentos($padres, ' ', true);
           $categorias = [
               'result' => 'ok',
               'response' => $this->renderAjax('administrar-categorias-documento', [
                   'menu'=>$html
               ])
           ];

       } else {

           $padres = CategoriaDocumento::getPadres();
           $html = $this->crearMenuDocumentos($padres, ' ', true);
           $categorias = [
               'result' => 'error',
               'response' => $this->renderAjax('administrar-categorias-documento', [
                   'menu'=>$html
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
   public function actionEliminarRelacionDocumento()
   {
      $idCategoria = Yii::$app->request->post('idCategoria', NULL);
      $idDocumento = Yii::$app->request->post('idDocumento', NULL);

      $categoriaDocumentoDetalle = CategoriaDocumentoDetalle::getRelacionCategoriaDocumento($idCategoria, $idDocumento);

      $categorias =[];

      if ($categoriaDocumentoDetalle->delete()) {

        $padres = CategoriaDocumento::getPadres();
        $html = $this->crearMenuDocumentos($padres, ' ', true);
        $categorias = [
            'result' => 'ok',
            'response' => $this->renderAjax('administrar-categorias-documento', [
                'menu'=>$html
            ])
        ];
      }else{

        $padres = CategoriaDocumento::getPadres();
        $html = $this->crearMenuDocumentos($padres, ' ', true);
        $categorias = [
            'result' => 'error',
            'response' => $this->renderAjax('administrar-categorias-documento', [
                'menu'=>$html
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
    public function actionRenderRelacionarDocumento()
    {
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
     public function actionGuardarRelacionDocumento()
     {
          $model = new CategoriaDocumentoDetalle();

          if ($model->load(Yii::$app->request->post())) {

             $model->contenido = ' \n ';

             if ($model->save()) {

               $padres = CategoriaDocumento::getPadres();
               $html = $this->crearMenuDocumentos($padres, ' ', true);
               $categorias = [
                   'result' => 'ok',
                   'response' => $this->renderAjax('administrar-categorias-documento', [
                       'menu'=>$html
                   ])
               ];

             }else{

               $padres = CategoriaDocumento::getPadres();
               $html = $this->crearMenuDocumentos($padres, ' ', true);
               $categorias = [
                   'result' => 'error',
                   'response' => $this->renderAjax('administrar-categorias-documento', [
                       'menu'=>$html
                   ])
               ];
             }
          }else{

            $padres = CategoriaDocumento::getPadres();
            $html = $this->crearMenuDocumentos($padres, ' ', true);
            $categorias = [
                'result' => 'error',
                'response' => $this->renderAjax('administrar-categorias-documento', [
                    'menu'=>$html
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
      public function actionPlantillaDocumento($idDocumento)
      {
        $model = Documento::findOne($idDocumento);
        $categorias = [
            'result' => 'ok',
            'response' => $this->renderAjax('_plantillaDocumento', [
                'model'=>$model
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
     protected function findModel($id)
     {
         if (($model = CategoriaDocumento::findOne($id)) !== null) {
             return $model;
         } else {
             throw new NotFoundHttpException('The requested page does not exist.');
         }
     }

}
