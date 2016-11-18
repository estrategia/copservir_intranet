<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\modules\intranet\models;

use Yii;

class OpcionesUsuario{

  private $opcionesUsuario = null;
  private $usuario;
  
  public function __construct($usuario) {
      $this->usuario = $usuario;
      $this->opcionesUsuario();
  }

  private function opcionesUsuario(){
    $this->opcionesUsuario = array();
    $listMenuFavorito = Menu::find()
            ->alias('m')
            ->innerJoinWith('objOpcion as o')
            ->where("m.estado=:estado AND m.idMenu NOT IN(SELECT idMenu FROM t_UsuariosMenuInactivo WHERE numeroDocumento=:usuario)", [':estado'=>1, ':usuario'=> $this->usuario])
            ->all();

    foreach($listMenuFavorito as $objMenu){
      $this->opcionesUsuario[] = $objMenu->idMenu;

      $this->buscarPadre($objMenu->objPadre);
    }

  }

  private function buscarPadre($objItem){

    if($objItem!==null && !in_array($objItem->idMenu, $this->opcionesUsuario)){
      $this->opcionesUsuario[] = $objItem->idMenu;

      if($objItem->idPadre!= null){
        $this->buscarPadre($objItem->objPadre);
      }
    }
  }

  public function getOpcionesUsuario(){
      if($this->opcionesUsuario===null){
          $this->opcionesUsuario();
      }
    return $this->opcionesUsuario;
  }
}
