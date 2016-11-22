<?php

namespace app\modules\intranet\models;

use Yii;
use yii\helpers\VarDumper;

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
    
    public static function tiempoTranscurridos($fecha_i, $fecha_f){
        $fecha1 = new \DateTime("$fecha_i 00:00:00");
        $fecha2 = new \DateTime("$fecha_f 00:00:00");
        $fecha = $fecha1->diff($fecha2);
        return [
            'Y' => $fecha->y,
            'm' => $fecha->m,
            'd' => $fecha->d,
            'H' => $fecha->h,
            'i' => $fecha->i,
        ];
    }

    public static function reemplazarPatronDocumentoUsuario($contenido) {
        $numeroDocumento = "__GUEST__";
        $numeroDocumentoEncriptado = "__GUEST__";

        if (!\Yii::$app->user->isGuest) {
            $numeroDocumento = \Yii::$app->user->identity->numeroDocumento;
            $numeroDocumentoEncriptado = md5(\Yii::$app->user->identity->numeroDocumento);
        }

        $patrones = array('@usuario_numeroDocumento@', '@usuario_numeroDocumentoCifrado@');
        $reemplazo = array($numeroDocumento, $numeroDocumentoEncriptado);
        return str_replace($patrones, $reemplazo, $contenido);
    }

    public static function getErrors($model) {
        $response = "";

        foreach ($model->getErrors() as $key => $arr) {
            foreach ($arr as $key => $value) {
                $response .= $value . ", ";
            }
        }

        return substr($response, 0, -2);
    }

    public function getUrl($url) {
        $urlEnlace = "#";

        if (!empty($url)) {
            if (strpos($url, 'https://') !== false || strpos($url, 'http://') !== false) {
                $urlEnlace = Funciones::reemplazarPatronDocumentoUsuario($url);
            } else {
                $urlEnlace = [$url];
            }
        }

        return $urlEnlace;
    }

    public static function getHtmlLink($url, $contenido="") {
        if($url!==null){
            $url = trim($url);
        }

        if (empty($url)) {
            echo "<a href='#'>$contenido</a>";
        } else {
            if (strpos($url, 'https://') !== false || strpos($url, 'http://') !== false) {
                $urlMenu = self::reemplazarPatronDocumentoUsuario($url);
                echo "<a target='_blank' href='$urlMenu'>$contenido</a>";
            } else {
                echo \yii\bootstrap\Html::a($contenido, [$url]);
            }
        }
    }
    
    public static function getNumeric($val) {
    	if (is_numeric($val)) {
    		return $val + 0;
    	}
    	return 0;
    }

    public static function generatePass($length) {
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena = strlen($cadena);
        $pass = "";
        $longitudPass = $length;

        for ($i = 1; $i <= $longitudPass; $i++) {
            $pos = rand(0, $longitudCadena - 1);
            $pass .= substr($cadena, $pos, 1);
        }
        return $pass;
    }

    /**
     * @param string module->id
     * @return bool
     * Chequea si un modulo es descediente de otro
     */
    public static function esSubmodulo($moduloHijo)
    {   
        $modulosDelPadre = Yii::$app->controller->module->modules;
        return Funciones::findKey($modulosDelPadre, $moduloHijo);
    }

    public function findKey($array, $keySearch)
    {
        foreach ($array as $key => $item) {
            if ($key == $keySearch) {
                return true;
            }
            else {
                if (is_array($item) && Funciones::findKey($item, $keySearch)) {
                    return true;
                }
            }
        }
        return false;
    }
}
