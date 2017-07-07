<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use Yii;
use app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoLeidoUsuario;
use app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoLeidoUsuarioSearch;
use app\modules\intranet\modules\formacioncomunicaciones\models\CursosUsuario;
use app\modules\intranet\modules\formacioncomunicaciones\models\CursosUsuarioSearch;
use app\modules\intranet\modules\formacioncomunicaciones\models\Puntos;
use app\modules\intranet\modules\formacioncomunicaciones\models\PuntosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TippContenidoController implements the CRUD actions for TipoContenido model.
 */
class ReportesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'redirectUri' => ['/intranet/usuario/autenticar']
            ],
            [
                'class' => \app\components\AuthItemFilter::className(),
                'only' => [
                    'contenidos-leidos'
                ],
                'authsActions' => [
                    'contenidos-leidos' => 'formacionComunicaciones_reportes_contenidosLeidos'
                ],
           ],

        ];
    }

    /**
     * Lists all TipoContenido models.
     * @return mixed
     */
    public function actionContenidosLeidos()
    {
        $searchModel = new ContenidoLeidoUsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('contenidosLeidos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCursosTerminados()
    {
        $searchModel = new CursosUsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('cursosLeidos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRenderModalPuntosUsuario()
    {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $puntos = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalPuntosUsuario', [
                'puntos' => Puntos::puntosDiscriminadosUsuario($numeroDocumento)
            ])
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $puntos;
    }

    public function actionMisPuntos()
    {
        $searchModelPuntos = new PuntosSearch();
        $queryParams['misPuntos'] = true;
        $dataProviderPuntos = $searchModelPuntos->search($queryParams);
        
        return $this->render('misPuntos', [
            'searchModelPuntos' => $searchModelPuntos,
            'dataProviderPuntos' => $dataProviderPuntos,
        ]);
    }

    /**
     * Finds the TipoContenido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TipoContenido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoContenido::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
