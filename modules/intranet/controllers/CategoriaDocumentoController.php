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
        $html = $this->renderMenuDocumentos($padres, ' ');
        return $this->render('index',['menu'=>$html]);
    }


    /**
     * Funcion auxiliar recursiva donde se crea el menu para el usuario normal
     * @param $seccion = arreglo con los elementos de un nivel del menu, $html = string con el codigo html del menu que se va gerenando
     * @return $html = string con todo el codigo html del menu
     */
    public function renderMenuDocumentos($seccion, $html)
    {
      if (empty($seccion)) {
        // no hay nivel CategoriaDocumento
          $html = $html.'No hay categorias';
      }else{
        foreach ($seccion as $item) {

          // se Consultan los hijos del elemento
          $hijos = CategoriaDocumento::getHijos($item->idCategoriaDocumento);
          //var_dump($hijos);
          // se acomoda el data-parent para indicar las dependencias
          // del acordeon dependiendo si es raiz o hijo
          $dataparent = '';
          if (is_null($item->idCategoriaPadre)) {
              $dataparent = 'accordion';
          }else{
              $dataparent = $item->idCategoriaDocumento;
          }

          if (!empty($hijos)) { // ese elemento tiene hijos

              $html = $html. // renderiza el titulo y su cuerpo
              '
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a href="#'.$item->idCategoriaDocumento.'" data-parent="#'.$dataparent.'" data-toggle="collapse" class="">
                      '.$item->nombre.'
                    </a>
                    <!-- aca porcion editar -->
                  </h4>
                </div>
                <div class="panel-collapse collapse" id="'.$item->idCategoriaDocumento.'">
                  <div class="panel-body">
                    <!-- aca porcion crear -->
                      '.$this->renderMenuDocumentos($hijos, '').'
                  </div>
                </div>
              </div>
              ';
            }else{ // ese elemento no tiene hijos

              // renderiza el titulo y su cuerpo
              $htmlEnlace = Html::a($item->nombre, ['#'], []);;
              $htmlRelaciona = '<button href="#" data-parent="#'.$dataparent.'"  class="btn btn-mini btn-success">
                                     No hay un documento asociado
                                </button>';
              if (!is_null($item->categoriaDocumentosDetalle)) {
                $htmlEnlace = Html::a($item->nombre, ['documento/detalle', 'id'=>$item->categoriaDocumentosDetalle->idDocumento], ['data-role'=>'hola']);
                $htmlRelaciona = '';
              }

              $html = $html.
              '
              <div class="panel panel-default">

                <div class="panel-heading">

                  <h4 class="panel-title">
                  <!-- enlace al detalle del documento -->
                  '.$htmlEnlace.'
                  '.$htmlRelaciona.'

                  </h4>
                  <!-- aca porcion editar -->
                </div>

                <div class="panel-collapse collapse" id="'.$item->idCategoriaDocumento.'">
                  <div class="panel-body">
                    <!-- aca porcion editar -->
                  </div>
                </div>
              </div>
              ';
              $this->renderMenuDocumentos($hijos, $html);
            }
          }
        }
        return $html;
    }


    /**
     * Funcion auxiliar recursiva donde se crea el menu para el usuario administrador
     * @param $seccion = arreglo con los elementos de un nivel del menu, $html = string con el codigo html del menu que se va gerenando
     * @return $html = string con todo el codigo html del menu
     */
    public function renderMenuDocumentosAdmin($seccion, $html)
    {
      if (empty($seccion)) {
        // no hay nivel CategoriaDocumento
          $html = $html.'No hay categorias';
      }else{
        foreach ($seccion as $item) {

          // se Consultan los hijos del elemento
          $hijos = CategoriaDocumento::getHijos($item->idCategoriaDocumento);

          // se acomoda el data-parent para indicar las dependencias
          // del acordeon dependiendo si es raiz o hijo
          $dataparent = '';
          if (is_null($item->idCategoriaPadre)) {
              $dataparent = 'accordion';
          }else{
              $dataparent = $item->idCategoriaDocumento;
          }

          if (!empty($hijos)) { // ese elemento tiene hijos

              $html = $html. // renderiza el titulo y su cuerpo
              '
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a href="#'.$item->idCategoriaDocumento.'" data-parent="#'.$dataparent.'" data-toggle="collapse" class="">
                      '.$item->nombre.'
                    </a>
                    <!-- aca porcion editar -->
                    <button href="#" data-role="categoria-editar" data-categoria="'.$item->idCategoriaDocumento.'"  class="btn btn-mini btn-success">
                        editar categoria
                    </button>
                  </h4>
                </div>
                <div class="panel-collapse collapse" id="'.$item->idCategoriaDocumento.'">
                  <div class="panel-body">
                    <!-- aca porcion crear -->
                    <button href="#" data-role="categoria-crear" data-padre="'.$item->idCategoriaDocumento.'" data-parent="#'.$dataparent.'"  class="btn btn-mini btn-success">
                        crear categoria
                    </button><br><br>
                      '.$this->renderMenuDocumentosAdmin($hijos, '').'
                  </div>
                </div>
              </div>
              ';
            }else{ // ese elemento no tiene hijos

              // Se verifica si tiene un documento asociado o no
              $htmlRelaciona = '<button href="#" data-parent="#'.$dataparent.'" data-categoria="'.$item->idCategoriaDocumento.'" data-role="relaciona-documento" class="btn btn-mini btn-success">
                               relacionar documento
                               </button>';

              $htmlCrearCategoria = '<button href="#" data-role="categoria-crear" data-padre="'.$item->idCategoriaDocumento.'" data-parent="#'.$dataparent.'"  class="btn btn-mini btn-success">
                                   crear categoria
                               </button><br><br>';

              if (!is_null($item->categoriaDocumentosDetalle)) {

                $htmlRelaciona = '<button href="#" data-parent="#'.$dataparent.'" data-role="no-relaciona-documento" data-categoria="'.$item->idCategoriaDocumento.'" data-documento="'.$item->categoriaDocumentosDetalle->idDocumento.'"  class="btn btn-mini btn-success">
                                       quitar relacion
                                  </button>';

                $htmlCrearCategoria = '';

              }
              // renderiza el titulo y su cuerpo
              $html = $html.
              '
              <div class="panel panel-default">

                <div class="panel-heading">

                  <h4 class="panel-title">
                  <!-- enlace cuerpo del accordion -->
                  <a href="#'.$item->idCategoriaDocumento.'" data-parent="#'.$dataparent.'" data-toggle="collapse" class="">
                      '.$item->nombre.'
                  </a>

                  </h4>
                  <!-- aca porcion editar -->
                  <button href="#" data-role="categoria-editar" data-categoria="'.$item->idCategoriaDocumento.'"  class="btn btn-mini btn-success">
                      editar categoria
                  </button>
                  '.$htmlRelaciona.'
                </div>

                <div class="panel-collapse collapse" id="'.$item->idCategoriaDocumento.'">
                  <div class="panel-body">
                    <!-- aca porcion crear  si no tiene relacion -->
                    '.$htmlCrearCategoria.'
                  </div>
                </div>
              </div>
              ';
              $this->renderMenuDocumentosAdmin($hijos, $html);
            }
          }
        }
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
     //CategoriaDocumento::find()->where('idCategoriaPadre is null')->all();
     $html = $this->renderMenuDocumentosAdmin($padres, ' ');
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

        $items = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalCategoria', [
                'model' => $model,
                'categoriaPadre' => $categoriaPadre
            ])
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $items;

    }

    /**
     * Renderiza el modal donde se podra editar una categoria
     * @param none
     * @return mixed
     */
     public function actionRenderEditarCategoria($id)
     {
        $model = $this->findModel($id);

        $items = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalCategoria', [
                'model' => $model,
                'categoriaPadre' => ''
            ])
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $items;
     }


     /**
      * crea un nuevo modelo CategoriaDocumento
      * @param none
      * @return mixed
      */
      public function actionCrearCategoria()
      {
          $model = new CategoriaDocumento();
          $items = [];

          if ($model->load(Yii::$app->request->post()) && $model->save()) {

              $padres = CategoriaDocumento::getPadres();
              $html = $this->renderMenuDocumentosAdmin($padres, ' ');
              $items = [
                  'result' => 'ok',
                  'response' => $this->renderAjax('administrar-categorias-documento', [
                      'menu'=>$html
                  ])
              ];

          } else {

              $padres = CategoriaDocumento::getPadres();
              $html = $this->renderMenuDocumentos($padres, ' ');
              $items = [
                  'result' => 'error',
                  'response' => $this->renderAjax('administrar-categorias-documento', [
                      'menu'=>$html
                  ])
              ];

          }

          Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          return $items;

      }


  /**
   * Actualiza un nuevo modelo CategoriaDocumento existente
   * @param id
   * @return mixed
   */
   public function actionActualizarCategoria($id)
   {
       $model = $this->findModel($id);
       $items = [];

       if ($model->load(Yii::$app->request->post()) && $model->save()) {

           $padres = CategoriaDocumento::getPadres();
           $html = $this->renderMenuDocumentosAdmin($padres, ' ');
           $items = [
               'result' => 'ok',
               'response' => $this->renderAjax('administrar-categorias-documento', [
                   'menu'=>$html
               ])
           ];

       } else {

           $padres = CategoriaDocumento::getPadres();
           $html = $this->renderMenuDocumentosAdmin($padres, ' ');
           $items = [
               'result' => 'error',
               'response' => $this->renderAjax('administrar-categorias-documento', [
                   'menu'=>$html
               ])
           ];

       }

       Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       return $items;

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

      $items =[];

      if ($categoriaDocumentoDetalle->delete()) {

        $padres = CategoriaDocumento::getPadres();
        $html = $this->renderMenuDocumentosAdmin($padres, ' ');
        $items = [
            'result' => 'ok',
            'response' => $this->renderAjax('administrar-categorias-documento', [
                'menu'=>$html
            ])
        ];
      }else{

        $padres = CategoriaDocumento::getPadres();
        $html = $this->renderMenuDocumentosAdmin($padres, ' ');
        $items = [
            'result' => 'error',
            'response' => $this->renderAjax('administrar-categorias-documento', [
                'menu'=>$html
            ])
        ];
      }

      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return $items;

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

        $items = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalRelacionDocumento', [
                'model' => $model,
                'listaDocumentos' => $listaDocumentos,
                'idCategoriaDocumento' => $idCategoriaDocumento
            ])
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $items;

    }

    /**
     * Renderiza el modal con el formulario para relacionar un Documento y un CategoriaDocumento
     * @param string $idCategoria
     * @return el html con la vista del modal
     */
     public function actionGuardarRelacionDocumento()
     {
          $model = new CategoriaDocumentoDetalle();

          if ($model->load(Yii::$app->request->post())) {

             $model->contenido = ' \n ';

             if ($model->save()) {

               $padres = CategoriaDocumento::getPadres();
               $html = $this->renderMenuDocumentosAdmin($padres, ' ');
               $items = [
                   'result' => 'ok',
                   'response' => $this->renderAjax('administrar-categorias-documento', [
                       'menu'=>$html
                   ])
               ];

             }else{

               $padres = CategoriaDocumento::getPadres();
               $html = $this->renderMenuDocumentosAdmin($padres, ' ');
               $items = [
                   'result' => 'error',
                   'response' => $this->renderAjax('administrar-categorias-documento', [
                       'menu'=>$html
                   ])
               ];
             }
          }else{

            $padres = CategoriaDocumento::getPadres();
            $html = $this->renderMenuDocumentosAdmin($padres, ' ');
            $items = [
                'result' => 'error',
                'response' => $this->renderAjax('administrar-categorias-documento', [
                    'menu'=>$html
                ])
            ];

          }

          Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          return $items;
     }

     /**
      * Renderiza la plantilla del documento cuando selecciona uno mientras relaciona un CategoriaDocumento con Documento
      * @param string $idDocumento
      * @return el html con la vista de la plantilla
      */
      public function actionPlantillaDocumento($idDocumento)
      {
        $model = Documento::findOne($idDocumento);
        $items = [
            'result' => 'ok',
            'response' => $this->renderAjax('_plantillaDocumento', [
                'model'=>$model
            ])
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $items;
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
