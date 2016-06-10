<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use app\modules\intranet\models\Portal;
use app\modules\intranet\models\Contenido;
use app\modules\intranet\models\ContenidoSearch;

abstract class CController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        $flagVerMas = false;
        $contenidoModels = Contenido::traerNoticiasIndexPortal($this->module->id, $flagVerMas);

        return $this->render('index', [
                    'contenidoModels' => $contenidoModels,
                    'flagVerMas' => $flagVerMas,
        ]);
    }

    public function actionVerTodasNoticias() {
        $searchModel = new ContenidoSearch();
        $searchModel->load(Yii::$app->request->post());

        $dataProviderNoticias = $searchModel->searchNoticiasPortal(Yii::$app->request->queryParams, $this->module->id);

        return $this->render('//common/noticias/todas-noticias', [
                    'dataProviderNoticias' => $dataProviderNoticias,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDetalleNoticia($idNoticia) {
        $contenidoModel = Contenido::traerNoticiaPortal($this->module->id, $idNoticia);

        if ($contenidoModel === null) {
            throw new \yii\web\HttpException(404, 'Contenido no existente');
        }

        return $this->render('//common/noticias/detalle-noticia', [
                    'contenidoModel' => $contenidoModel,
        ]);
    }

    public function actionContenido() {
        if(isset($_GET['menu'])){
            return $this->verMenu($_GET['menu']);
        }else if(isset($_GET['modulo'])){
            return $this->verModulo($_GET['modulo']);
        }
        
        throw new \yii\web\HttpException(404, 'Solicitud inv&aacute;lida');
    }
    
    private function verMenu($idMenu){
        $objMenu = \app\modules\intranet\models\MenuPortales::traerMenuPortal($this->module->id,$idMenu);
        
        if($objMenu===null){
            throw new \yii\web\HttpException(404, 'Contenido no disponible en ' . $this->module->id);
        }
        
        $listModulos = \app\modules\intranet\models\ModuloContenido::getModulosGrupo($objMenu->urlMenu);
        
        if (empty($listModulos)) {
            throw new \yii\web\HttpException(404, 'Contenido no disponible');
        }
        
        return $this->render('//common/contenido/modulos', array(
            'listModulos' => $listModulos
        ));
    }
    
    private function verModulo($idModulo){
        
    }

}
