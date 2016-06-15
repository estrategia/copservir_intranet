<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use app\modules\intranet\models\DataTableForm;
use yii\web\UploadedFile;
use \app\modules\intranet\models\MenuPortales;
//use yii\rbac\Role;
use yii\helpers\VarDumper;
use app\modules\intranet\models\AuthItem;
use app\modules\intranet\models\AuthItemChild;
use app\modules\intranet\models\AuthAssignment;

class TestController extends Controller {

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => ['index'],
            ],
        ];
    }
    
    public function actionUrl(){
        echo Yii::getAlias('@webroot');
        //echo \yii\helpers\Url::to("['/intranet/calendario']");
    }

    public function actionMenu() {
        $menuPortales = MenuPortales::traerMenuPortalesIndex('intranet');
        foreach ($menuPortales as $itemMenu) {
            VarDumper::dump($itemMenu->attributes, 10, true);
            echo "<br/>";
            echo "<br/>";
        }
    }

    public function actionDatatable() {
        return $this->render("datatable");
    }

    public function actionPermiso() {
                  
        $listPermisos = AuthItem::find()
                ->alias('permiso')
                ->joinWith(['parents as rol', 'parents.authAssignments as rolasignacion'])
                ->where("permiso.type=:tipoPermiso AND rol.name=:rol AND rolasignacion.user_id=:usuario")
                ->addParams([':tipoPermiso' => 2, ':rol' => 'intranet_admin', ':usuario' => 1113618983])
                ->all();

        foreach (AuthItem::consultarPermisosXRol(Yii::$app->user->identity->numeroDocumento) as $objPermiso) {
            echo "$objPermiso->name - $objPermiso->type - $objPermiso->title - $objPermiso->url<br>";
        }

        //var_dump($listPermisos->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        exit();

        //\Yii::$app->authManager->defaultRoles = ['usuario'];

        /* $permiso = Yii::$app->user->identity->tienePermiso('intranet_usuario');
          \yii\helpers\VarDumper::dump($permiso);
          echo "<br>";echo "<br>";

          echo "Roles<br>";
          $roles = Yii::$app->user->identity->getRoles();
          \yii\helpers\VarDumper::dump($roles);
          echo "<br>";echo "<br>";

          echo "default roles<br>";
          \yii\helpers\VarDumper::dump(\Yii::$app->authManager->defaultRoles,10,true);
          echo "<br>";
          echo "<br>";

          foreach ($roles as $role){
          \yii\helpers\VarDumper::dump($role->name);
          echo "<br>";
          } */
    }
    
    public function actionCargartable() {

        $model = new DataTableForm;

        if ($model->load(Yii::$app->request->post())) {
            $archivo = UploadedFile::getInstance($model, 'archivo');
            
            if (!is_null($archivo)) {
                $archivo->saveAs('contenidos/documentos/' . $archivo->baseName . '.' . $archivo->extension);
                $rutaDocumento = $archivo->baseName . '.' . $archivo->extension;
                
                $extension['xlsx'] = '\PHPExcel_Reader_Excel2007';
                $extension['xls'] = '\PHPExcel_Reader_Excel5';
                $objReader = new $extension[$archivo->extension];
                $objPHPExcel = $objReader->load('contenidos/documentos/' . $archivo->baseName . '.' . $archivo->extension);

                $nHojas = $objPHPExcel->getSheetCount();
                $hojas = $objPHPExcel->getSheetNames();
                $idModulo = 54;

                $dataTableHTML = $this->renderPartial('datatable_read', ['objPHPExcel' => $objPHPExcel, 'nHojas' => $nHojas, 'hojas' => $hojas, 'idModulo' => $idModulo]);
                echo $dataTableHTML;
                exit();
            }
        }

        

        return $this->render('datatableForm', ['model' => $model]);



    }

    public function actionCargartableOld() {

        $model = new DataTableForm;

        //if ($model->load(Yii::$app->request->post())) {
        //$archivo = UploadedFile::getInstance($model, 'archivo');
        //if (!is_null($archivo)) {
        //$archivo->saveAs('contenidos/documentos/' . $this->file->baseName . '.' . $this->file->extension);
        //$this->rutaDocumento = $this->file->baseName . '.' . $this->file->extension;
        //echo "<p>$archivo->baseName</p>";

        $extension['xlsx'] = '\PHPExcel_Reader_Excel2007';
        $extension['xls'] = '\PHPExcel_Reader_Excel5';
        //$objReader = new $extension[$archivo->getExtension()];
        $objReader = new \PHPExcel_Reader_Excel2007;
        $objPHPExcel = $objReader->load("/Users/eiso/masm/COPSERVIR/multiportal/documentacion/datatable_.xlsx");

        //$objWorksheet = $objPHPExcel->getSheet(0)->toArray(null, true, true, true);
        //\yii\helpers\VarDumper::dump($objWorksheet,10,true);
        //echo $objPHPExcel->getSheetCount() . ' worksheet<br><br>';
        /* $loadedSheetNames = $objPHPExcel->getSheetNames();
          foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
          echo $sheetIndex,' -> ',$loadedSheetName,'<br />';
          } */


        /* echo "<table border='1'>";

          foreach ($objWorksheet as $registro => $objCelda) {
          echo "<tr>";
          foreach($objCelda as $column => $value){
          echo "<td>". $value . "</td>";
          //echo "<td>". $objCelda['B'] . "</td>";
          }

          echo "</tr>";
          }


          echo "</table>"; */
        //}
        //}

        $nHojas = $objPHPExcel->getSheetCount();
        $hojas = $objPHPExcel->getSheetNames();
        $idModulo = 54;

        //if($nHojas>1){
        return $this->render('datatable_read', ['objPHPExcel' => $objPHPExcel, 'nHojas' => $nHojas, 'hojas' => $hojas, 'idModulo' => $idModulo]);
        //}
    }

}
