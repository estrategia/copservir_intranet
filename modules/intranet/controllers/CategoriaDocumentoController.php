<?php

namespace app\modules\intranet\controllers;
use app\modules\intranet\models\Documento;
use app\modules\intranet\models\LogDocumento;
use app\modules\intranet\models\CategoriaDocumento;
use app\modules\intranet\models\CategoriaDocumentoDetalle;
use yii\helpers\Url;
use yii\helpers\Html;

class CategoriaDocumentoController extends \yii\web\Controller
{

  /**
   * Muesrtra el menu de los documentos
   * @param
   * @return mixed
   */
    public function actionIndex()
    {
        $padres = CategoriaDocumento::find()->where('idCategoriaPadre is null')->all();//->with(['categoriaDocumentos'])
        $html = $this->creaMenuDocumentos($padres, ' ');
        return $this->render('index',['menu'=>$html]);
    }


    /**
     * Funcion auxiliar recursiva donde se crea el menu
     * @param $seccion = arreglo con los elementos de un nivel del menu, $html = string con el codigo html del menu que se va gerenando
     * @return $html = string con todo el codigo html del menu
     */
    public function creaMenuDocumentos($seccion, $html)
    {

      if (empty($seccion)) {
        // no hay nivel CategoriaDocumento
      }else{
        foreach ($seccion as $item) {

          $hijos = CategoriaDocumento::find()
          ->where("( idCategoriaPadre =:idCategoria )")
          ->addParams([':idCategoria'=> $item->idCategoriaDocumento])->all();

          // se acomoda el data-parent para indicar las dependencias
          // del acordeon dependiendo si es raiz o hijo
          $dataparent = '';
          if (is_null($item->idCategoriaPadre)) {
              $dataparent = 'accordion';
          }else{
              $dataparent = $item->idCategoriaDocumento;
          }

          if (!empty($hijos)) { // ese elemento tiene hijos

              $html = $html.
              '
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a href="#'.$item->idCategoriaDocumento.'" data-parent="#'.$dataparent.'" data-toggle="collapse" class="">
                      '.$item->nombre.'
                    </a>
                  </h4>
                </div>
                <div class="panel-collapse collapse" id="'.$item->idCategoriaDocumento.'">
                  <div class="panel-body">
                      '.$this->creaMenuDocumentos($hijos, '').'
                  </div>
                </div>
              </div>
              ';
            }else{ // es una hoja es el final

              // se consulta el detalle para crear el encale
              /*$documentoDetalle  = CategoriaDocumentoDetalle::find()
              ->where("( idCategoriaDocumento =:idCategoria )")
              ->addParams([':idCategoria'=> $item->idCategoriaDocumento])->one();*/

              $html = $html.
              '
              <div class="panel panel-default">

                <div class="panel-heading">

                  <h4 class="panel-title">

                    '. Html::a($item->nombre, ['detalle-documento', 'id'=>$item->idCategoriaDocumento], ['data-role'=>'hola']) .'

                  </h4>


                </div>

                <div class="panel-collapse collapse" id="'.$item->idCategoriaDocumento.'">
                  <div class="panel-body">
                  </div>
                </div>
              </div>
              ';
              $this->creaMenuDocumentos($hijos, $html);
            }
          }
        }
        return $html;
      }

      /**
       * Muestra el detalle de un modelo Documento, con su historial de cambios
       * @param id = identificador del documento
       * @return mixed
       */
        public function actionDetalleDocumento($id)
        {
          $categoriaDocumentoDetalle = CategoriaDocumentoDetalle::find()
          ->with(['objDocumento'])
          ->where("( idCategoriaDocumento =:id )")
          ->addParams([':id'=>$id])->one();

          //var_dump($categoriaDocumentoDetalle);

          $logDocumento = LogDocumento::find()
          ->where("( idDocumento =:id )")
          ->addParams([':id'=> $categoriaDocumentoDetalle->objDocumento->idDocumento])->all();



          return $this->render('detalle-documento',
            [
              'categoriaDocumentoDetalle'=>$categoriaDocumentoDetalle,
              'logDocumento'=> $logDocumento
            ]
          );/**/
        }

}
