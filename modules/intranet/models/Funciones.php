<?php

namespace app\modules\intranet\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Funciones
 *
 * @author eiso
 */
class Funciones {

    //dias transcurridos entre 2 fechas
    public static function diasTranscurridos($fecha_i, $fecha_f) {
        $dias = (strtotime($fecha_i) - strtotime($fecha_f)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);
        return $dias;
    }
    
    public static function reemplazarPatronDocumentoUsuario($contenido){
        $numeroDocumento = "__GUEST__";
        $numeroDocumentoEncriptado = "__GUEST__";
        
        if (!\Yii::$app->user->isGuest) {
            $numeroDocumento=\Yii::$app->user->identity->numeroDocumento;
            $numeroDocumentoEncriptado = md5(\Yii::$app->user->identity->numeroDocumento);
        }
        
        $patrones = array('@usuario_numeroDocumento@', '@usuario_numeroDocumentoCifrado@');
        $reemplazo   = array($numeroDocumento, $numeroDocumentoEncriptado);
        return str_replace($patrones, $reemplazo, $contenido);
    }
    
    public static function getErrors($model){
        $response = "";

        foreach ($model->getErrors() as $key => $arr) {
            foreach ($arr as $key => $value) {
                $response .= $value . ", ";
            }
        }

        return substr($response, 0, -2);
    }

}
