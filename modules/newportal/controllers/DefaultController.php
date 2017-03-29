<?php

namespace app\modules\newportal\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\intranet\models\Portal;


/**
 * Default controller for the `newportal` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'index', 'view'
                ],
                'redirectUri' => ['/intranet/usuario/autenticar']
            ],

           //  [
           //      'class' => \app\components\AuthItemFilter::className(),
           //      'only' => [
           //          'index', 'view'
           //      ],
           //      'authsActions' => [
           //          'index' => 'newPortal_admin',
           //          'view' => 'newPortal_admin',
           //      ],
           // ]
        ];
    }
    /**
     * @var \yii\gii\Generator
     */
    public $generator;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        $generator = $this->loadGenerator($id);
        $params = ['generator' => $generator, 'id' => $id];

        $preview = Yii::$app->request->post('preview');
        $generate = Yii::$app->request->post('generate');
        // $answers = Yii::$app->request->post('answers');
        // if ($preview !== null || $generate !== null) {
        //     if ($generator->validate()) {
        //         $generator->saveStickyAttributes();
        //         $files = $generator->generate();
        //         if ($generate !== null && !empty($answers)) {
        //             $params['hasError'] = !$generator->save($files, (array) $answers, $results);
        //             $params['results'] = $results;
        //             $generator->setModuleConfig();
        //             var_dump($answers);
        //         } else {
        //             $params['files'] = $files;
        //             $params['answers'] = $answers;
        //             var_dump($answers);
        //             var_dump($files);
        //         }
        //     }
        // }
        if ($generate !== null) {
            if ($generator->validate()) {
                $generator->saveStickyAttributes();
                $files = $generator->generate();
                $params['files'] = $files;
                $answers = [];
                foreach ($files as $key => $file) {
                    $answers[$file->id] = "1";
                }
                $params['answers'] = $answers;
                if ($generate !== null && !empty($answers)) {
                    $params['hasError'] = !$generator->save($files, (array) $answers, $results);
                    $params['results'] = $results;
                    $generator->setModuleConfig();
                }
            }
        }
        return $this->render('view', $params);
    }

    protected function loadGenerator($id)
    {
        if (isset($this->module->generators[$id])) {
            $this->generator = $this->module->generators[$id];
            $this->generator->loadStickyAttributes();
            $this->generator->load(Yii::$app->request->post());
            return $this->generator;
        } else {
            throw new NotFoundHttpException("Code generator not found: $id");
        }
    }
}
