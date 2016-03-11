<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_Menu".
 *
 * @property string $idMenu
 * @property string $descripcion
 * @property string $idPadre
 * @property string $idRaiz
 * @property integer $estado
 */
class Menu extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 't_Menu';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['descripcion', 'estado'], 'required'],
            [['idPadre', 'idRaiz', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'idMenu' => 'Id Menu',
            'descripcion' => 'Descripcion',
            'idPadre' => 'Id Padre',
            'idRaiz' => 'Id Raiz',
            'estado' => 'Estado',
        ];
    }

    public function getListSubMenu() {
        return $this->hasMany(Menu::className(), ['idPadre' => 'idMenu']);
    }

    public function getObjPadre() {
        return $this->hasOne(Menu::className(), ['idMenu' => 'idPadre']);
    }

    public function getObjOpcion() {
        return $this->hasOne(Opcion::className(), ['idMenu' => 'idMenu']);
    }

    public static function menuHtml($menuItem, $opciones = []) {
        
        if (in_array($menuItem->idMenu, $opciones)) {
            if (empty($menuItem->objOpcion)) { // no tiene hipervinculo
                echo '<li > 
                      <a href="javascript:;"> <i class="icon-custom-ui"></i> <span class="title">' . $menuItem->descripcion . '</span> <span class=" arrow" ></span> </a>
                        <ul class="sub-menu">';

                foreach ($menuItem->listSubMenu as $subItem) {
                    self::menuHtml($subItem,$opciones);
                }

                echo '</ul>
                  </li>';
            } else { // tiene hipervinculo
                echo "<li > <a href='" . $menuItem->objOpcion->url . "'> $menuItem->descripcion </a> </li>";
            }
        }
    }
    
    public static function construirArrayMenu(){
        
        $opciones = Menu::find()->where('idPadre is null')->all();
        $opcionArray=[];
        foreach($opciones as $opcion){
            $opcionArray[] = self::obtenerHijosArray($opcion);
        }
       return $opcionArray;
    }
    
    public static function obtenerHijosArray($opcion){
        if(!empty($opcion->objOpcion)){
            return ['title' => "<a href='#'>$opcion->descripcion</a>  <input type='checkbox'  data-role='agregar-opcion' data-id='$opcion->idMenu'></a>"];
        }else{
            $children= [];
            
            foreach($opcion->listSubMenu as $opcion2){
                $children[] = self::obtenerHijosArray($opcion2);
            }
            return ['title' => $opcion->descripcion, 'children' => $children, 'folder' => true];
        }
    }

}
