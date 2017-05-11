<?php 
  namespace app\controllers;

  use Yii;
  use yii\web\Controller;
  use app\modules\intranet\models\Portal;

  /**
  * 
  */
  abstract class PortalController extends Controller
  {

    public $logoPortal;
    public $colorPortal;

    // public function init()
    // {
    //     $this->getLogoPortal();
    //     $this->getColorPortal();
    //     parent::init();
    // }

    public function getLogoPortal()
    {
      $nombrePortal = Yii::$app->controller->module->id;
      if (!isset(Yii::$app->session['logoPortal.' . $nombrePortal])) {
        $portal = Portal::find()->where(['nombrePortal' => $nombrePortal])->one();
        Yii::$app->session['logoPortal.' . $nombrePortal] = $portal->logoPortal;
      }
      return Yii::$app->session['logoPortal.' . $nombrePortal];
    }

    public function getColorPortal()
    {
      $nombrePortal = Yii::$app->controller->module->id;
      if (!isset(Yii::$app->session['colorPortal.' . $nombrePortal])) {
        $portal = Portal::find()->where(['nombrePortal' => $nombrePortal])->one();
        Yii::$app->session['colorPortal.' . $nombrePortal] = $portal->colorPortal;
      }
      return Yii::$app->session['colorPortal.' . $nombrePortal];
    }
  }
?>