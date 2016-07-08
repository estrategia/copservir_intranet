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
use app\modules\intranet\models\Menu;
//use app\modules\intranet\models\UsuariosOpcionesFavoritos;
use app\modules\intranet\models\OpcionesUsuario;

class TestController extends Controller {
    
    public function actionUsuario(){
        $infoUsuario = \app\models\Usuario::callWSInfoPersona(1033746784);
        VarDumper::dump($infoUsuario,10,true);
        
    }
    
    public function actionOpcionesusuario() {
       /*$opcionesUsuario = UsuariosOpcionesFavoritos::find()->where(['=', 'numeroDocumento', 1113618983])->all();
       
       VarDumper::dump($opcionesUsuario,10,true);*/
        //$opciones = new OpcionesUsuario(1113618983);
        
        //VarDumper::dump($opciones->getOpcionesUsuario(),10,true);
        
    //$opcionesUsuario = Menu::find()->alias('m')->innerJoinWith('objOpcion as o')->where("m.estado=:estado AND m.idMenu NOT IN(SELECT idMenu FROM t_UsuariosOpcionesFavoritos WHERE numeroDocumento=:usuario)", [':estado'=>1, ':usuario'=> 1113618983]);
        
        
        
    //var_dump($opcionesUsuario->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        
    }
    
    public function actionMenu(){
        $listMenu = Menu::find()->with('activeListSubMenu')->where('estado=1 AND idPadre is NULL')->orderBy('orden')->all();
        //var_dump($listMenu->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        
        foreach($listMenu as $objMenu){
            echo "$objMenu->idMenu: $objMenu->descripcion<br>";
            foreach($objMenu->activeListSubMenu as $objSubmenu1){
                echo "--- $objSubmenu1->idMenu: $objSubmenu1->descripcion<br>";
                foreach($objSubmenu1->activeListSubMenu as $objSubmenu2){
                    echo "------ $objSubmenu2->idMenu: $objSubmenu2->descripcion<br>";
                    foreach($objSubmenu2->activeListSubMenu as $objSubmenu3){
                        echo "--------- $objSubmenu3->idMenu: $objSubmenu3->descripcion<br>";
                    }
                }
            }
            echo "<br>";
        }
        
        
        //VarDumper::dump($listMenu->all(),10,true);
    }
    
    public function actionMenuconstruir(){
        $listMenu = Menu::construirArrayMenu(false,Yii::$app->user->identity->numeroDocumento);
        
        VarDumper::dump($listMenu,10,true);
    }
    
    public function actionAut(){
        echo Yii::getAlias('@webroot');exit();
        
        //$resultWebServicesLogin = \app\modules\intranet\models\LoginForm::callWSLogin("91250721", "91250721");
        //VarDumper::dump($resultWebServicesLogin,10,true);
        
        $usuario = new \app\models\Usuario;
        $usuario->numeroDocumento = 91250721;
        
        $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
          "trace" => 1,
          "exceptions" => 0,
          'connection_timeout' => 5,
          'cache_wsdl' => WSDL_CACHE_NONE
      ));

      $result = $client->getPersonaWithModel($usuario->numeroDocumento = 91250721, true, null);
      
      VarDumper::dump($result,10,true);
      
        
    }
    
    public function actionReplace(){
        $letters = array('@_numeroDocumento_', '@_numeroDocumentoEncriptado_');
        $fruit   = array('apple', 'pear');
        $text    = 'url @_numeroDocumento_ y encriptado @_numeroDocumentoEncriptado_';
        $output  = str_replace($letters, $fruit, $text);
        echo $output;
    }
    
    public function actionZone(){
        //$user = Yii::$app->user->identity;
        //if ($user && $user->timezone) {
            VarDumper::dump(Yii::$app->getTimeZone(),10,true);
            echo "<br><br>";
            echo date("Y-m-d H:i:s");
        //}
    }
    
    public function actionTabs(){
        return $this->render('tabs');
    }
    
    public function actionUrlTest(){
        echo Yii::$app->controller->module->id . "/" . Yii::$app->controller->id . "/" . Yii::$app->controller->action->id;
        //echo Yii::getAlias('@webroot');
        //echo \yii\helpers\Url::to("['/intranet/calendario']");
    }

    public function actionMenuportal() {
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
                  
        /*$listPermisos = AuthItem::find()
                ->alias('permiso')
                ->joinWith(['parents as rol', 'parents.authAssignments as rolasignacion'])
                ->where("permiso.type=:tipoPermiso AND rol.name=:rol AND rolasignacion.user_id=:usuario")
                ->addParams([':tipoPermiso' => 2, ':rol' => 'intranet_admin', ':usuario' => 1113618983])
                ->all();*/
        
             
             $listPermisos = AuthItem::consultarPermisos('1113618983');

        foreach ($listPermisos as $objPermiso) {
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
