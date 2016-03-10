<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\intranet\models;

use Yii;

class OpcionesUsuario{
    
    private $opcionesUsuario;
    
    public function opcionesUsuario($usuario){
        $opcionesUsuario = UsuariosOpcionesFavoritos::find()->where(['=', 'idUsuario', $usuario])->all();
        
        foreach($opcionesUsuario as $opcion){
            $this->opcionesUsuario[] = $opcion->idMenu;
            
            $this->buscarPadre($opcion->objMenu->objPadre);
        }
            
    }
    
    private function buscarPadre($objItem){
        
        if(!in_array($objItem->idMenu, $this->opcionesUsuario)){
            $this->opcionesUsuario[] = $objItem->idMenu;
            
            if($objItem->idPadre!= null){
                $this->buscarPadre($objItem->objPadre);
            }
        }
    }
    
    public function getOpcionesUsuario(){
        return $this->opcionesUsuario;
    }
}