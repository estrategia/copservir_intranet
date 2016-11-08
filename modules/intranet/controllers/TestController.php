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
use app\modules\intranet\models\PublicacionesCampanas;
use app\modules\intranet\models\GrupoInteresCargo;
use app\modules\intranet\models\CumpleanosPersona;
use app\modules\intranet\models\CumpleanosLaboral;
use app\modules\intranet\models\LoginForm;

class TestController extends Controller {
    //tiempo
    public function actionTiempo(){
        $fecha_i = "2014-08-18";
        $fecha_f = "2016-08-17";
        $result = \app\modules\intranet\models\Funciones::tiempoTranscurridos($fecha_i, $fecha_f);
        //VarDumper::dump($result, 10, true);
    }
    
    public function actionCumple($index=1){
        $listGrupos = \app\modules\intranet\models\GrupoInteres::find()->all();
        echo "Listar grupos [".count($listGrupos)."]: <br>";
        foreach($listGrupos as $objGrupo){
            VarDumper::dump($objGrupo->attributes, 10, true);
            echo "<br>";
        }
        echo "<br>";
        
        $listGruposCargos = GrupoInteresCargo::find()->all();
        echo "Listar grupos cargos [".count($listGruposCargos)."]: <br>";
        foreach($listGruposCargos as $objGrupoCargo){
            VarDumper::dump($objGrupoCargo->attributes, 10, true);
            echo "<br>";
        }
        echo "<br>";
        
        
        $userCiudad = Yii::$app->user->identity->getCiudadCodigo();
        $userGrupos = Yii::$app->user->identity->getGruposCodigos();
        echo "Ciudad: $userCiudad";
        echo "<br>";
        echo "Cargo: ". Yii::$app->user->identity->getCargoCodigo();
        echo "<br>";
        echo "Grupos : " . VarDumper::dumpAsString($userGrupos, 10, true);
        echo "<br><br>";
        
        // cumpleaños y aniversarios
        $listCumpleLaboral = array();
        $fecha = new \DateTime();
        $anho1 = $fecha->format("Y");
        $mes1 = $fecha->format("m");
        $fecha->modify("+1 month");
        $anho2 = $fecha->format("Y");
        $mes2 = $fecha->format("m");
        
        if($index){
            $listCumpleLaboral = CumpleanosLaboral::getAniversariosIndex();
        }else{
            $listCumpleLaboral = CumpleanosLaboral::find()->where("fecha>=:fecha1 AND fecha<:fecha2", [':fecha1'=>"$anho1-$mes1-01",':fecha2'=>"$anho2-$mes2-01"])->orderBy("fecha")->all();
        }
        
        echo "Listar cumple laboral [".count($listCumpleLaboral)."]: <br>";
        foreach($listCumpleLaboral as $objCumpleLaboral){
            VarDumper::dump($objCumpleLaboral->attributes, 10, true);
            echo "<br>";
        }
        
        $listCumplePersonal = array();
        
        if($index){
            $listCumplePersonal = CumpleanosPersona::getCumpleanosIndex();
        }else{
            $listCumplePersonal = CumpleanosPersona::find()->where("fecha>=:fecha1 AND fecha<:fecha2", [':fecha1'=>"$anho1-$mes1-01",':fecha2'=>"$anho2-$mes2-01"])->orderBy("fecha")->all();
        }
        
        echo "<br>Listar cumple personal [".count($listCumplePersonal)."]: <br>";
        foreach($listCumplePersonal as $objCumplePersonal){
            VarDumper::dump($objCumplePersonal->attributes, 10, true);
            echo "<br>";
        }
        
        //$models = \app\modules\intranet\models\CumpleanosLaboral::getAniversariosVerTodos();
    }

    public function actionBanner(){
        $userCiudad = Yii::$app->user->identity->getCiudadCodigo();
        $userGrupos = Yii::$app->user->identity->getGruposCodigos();
        $cargoNombre = Yii::$app->user->identity->getCargoNombre();
        $cargoCodigo = Yii::$app->user->identity->getCargoCodigo();

        echo "Cargo [$cargoCodigo: $cargoNombre]<br>";
        echo "Ciudad: $userCiudad<br>";
        echo "<br>";
        echo "Grupos<br>";
        VarDumper::dump($userGrupos,10,true);
        echo "<br><br>";

        $db = Yii::$app->db;
        $banners = $db->createCommand('select distinct pc.idImagenCampana, pc.rutaImagen, pc.urlEnlaceNoticia
        from t_CampanasDestino as pcc, t_PublicacionesCampanas as pc
        where (pcc.idImagenCampana = pc.idImagenCampana and pc.fechaInicio<=:fecha and pc.fechaFin >=:fecha and pc.estado=:estado and pc.posicion =:posicion
        and (( pcc.idGrupoInteres IN(:userGrupos) and pcc.codigoCiudad =:userCiudad) or ( pcc.idGrupoInteres =:todosGrupos and pcc.codigoCiudad =:todosCiudad) or (pcc.idGrupoInteres IN(:userGrupos) and pcc.codigoCiudad =:todosCiudad) or (pcc.idGrupoInteres =:todosGrupos and pcc.codigoCiudad =:userCiudad)  )  )
        order by rand()')
        ->bindValue(':userCiudad', $userCiudad)
        ->bindValue(':userGrupos', implode(',', $userGrupos))
        ->bindValue(':estado', PublicacionesCampanas::ESTADO_ACTIVO)
        ->bindValue(':posicion', PublicacionesCampanas::POSICION_ARRIBA)
        ->bindValue(':fecha', date('Y-m-d H:i:s'))
        ->bindValue('todosCiudad', \Yii::$app->params['ciudad']['*'])
        ->bindValue('todosGrupos', \Yii::$app->params['grupo']['*']);

        var_dump($banners->rawSql);

        echo "<br><br>";


        $listGrupoInteresCargo = GrupoInteresCargo::find()->all();

        echo "Grupos Cargos:<br>";
        foreach ($listGrupoInteresCargo as $objGrupoCargo){
            VarDumper::dump($objGrupoCargo->attributes);echo "<br>";
        }
         echo "<br><br>";

        //tareas
        $bannerArriba = PublicacionesCampanas::getCampana($userCiudad, $userGrupos, PublicacionesCampanas::POSICION_ARRIBA);
        VarDumper::dump($bannerArriba,10,true);

    }

    public function actionUsuario($cedula, $pass=null){
    	echo "<br>Persona<br>";
        $infoUsuario = \app\models\Usuario::callWSInfoPersona($cedula);
        VarDumper::dump($infoUsuario,10,true);
        
        if(!empty($pass)){
        	echo "<br><br>Login:<br>";
        	$resultWebServicesLogin = LoginForm::callWSLogin($cedula, $pass);
        	VarDumper::dump($resultWebServicesLogin,10,true);
        }
    }
    
    public function actionUser($cedula, $login=true){
        $usuario = null;
        
        if($cedula==null){
            $usuario = \app\models\Usuario::find()->all();
        }else{
            if($login){
                $usuario = \app\models\Usuario::findByUsername($cedula);
            }else{
                $usuario = \app\models\Usuario::find()->where("numeroDocumento=:documento",[":documento"=>$cedula])->one();
            }
        }
        
        
        VarDumper::dump($usuario,5,true);
        echo "<br><br>";
        
        if (!$usuario) {
            echo "NO USUARIO";
        }else{
            echo "SI USUARIO";
        }
    }

    public function actionLogin($username,$password){
        $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            'cache_wsdl' => WSDL_CACHE_NONE
        ));

        $result = $client->getLogin($username, sha1($password));

        VarDumper::dump($result,10,true);
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
