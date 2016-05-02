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

    /**
     * Relaciones
     */
    public function getListSubMenu() {
        return $this->hasMany(Menu::className(), ['idPadre' => 'idMenu']);
    }

    public function getObjPadre() {
        return $this->hasOne(Menu::className(), ['idMenu' => 'idPadre']);
    }

    public function getObjOpcion() {
        return $this->hasOne(Opcion::className(), ['idMenu' => 'idMenu']);
    }

    /**
     * Funciones
     */
    public static function menuHtml($menuItem, $opciones = []) {

        if (!empty($opciones) &&in_array($menuItem->idMenu, $opciones)) {
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

    /**
     * Funcion auxiliar estatica donde se crea el menu para el usuario
     * @param $flagAdmin = indica si renderiza el menu al usuario normal o al administrador
     * @return $opcionesArray = arreglo con la estructura del menu
     */
    public static function construirArrayMenu($flagAdmin){

        $opciones = Menu::find()->where('idPadre is null')->all();
        $opcionesUsuario = UsuariosOpcionesFavoritos::find()->where(['=', 'numeroDocumento', Yii::$app->user->identity->numeroDocumento])->all();
        $opcionesUsuarioArray = [];
        $opcionArray=[];

        if ($flagAdmin) {
          foreach($opciones as $opcion){
              $opcionArray[] = self::obtenerHijosArrayAdmin($opcion);
          }
        }else{

          foreach($opcionesUsuario as $opcion){
              $opcionesUsuarioArray[] = $opcion->idMenu;
          }

          foreach($opciones as $opcion){
              $opcionArray[] = self::obtenerHijosArray($opcion,$opcionesUsuarioArray);
          }
        }

       return $opcionArray;
    }

    /**
     * Funcion auxiliar recursiva y estatica donde se crea el menu para el usuario administrador
     * @param $opcion = modelo Menu, $opcionesUsuario = las opciones que el usuario ha escogido
     * @return array con title = titulo ha renderizar en el menu, children = hijos de esa categoria del menu, folder = ?
     */
    public static function obtenerHijosArray($opcion,$opcionesUsuario){
        if(!empty($opcion->objOpcion)){
            $checked = "";

            if(in_array($opcion->idMenu, $opcionesUsuario)){
                $checked = " checked";
            }
            return ['title' => "<a href='".$opcion->objOpcion->url."' class='btn btn-default  btn-xs menu_corporativo'>
  <input type='checkbox' id='$opcion->idMenu' data-role='agregar-opcion' data-id='$opcion->idMenu' $checked> <label style='display: inline;' for='$opcion->idMenu'><span><span></span></span></label> $opcion->descripcion  </a> "];
        }else{
            $children= [];

            foreach($opcion->listSubMenu as $opcion2){
                $children[] = self::obtenerHijosArray($opcion2,$opcionesUsuario);
            }
            return ['title' => "<div class='panel-default'><div class=' panel-heading'> <h6 class='panel-title' style='font-size: 13px;'>$opcion->descripcion </h6></div></div>", 'children' => $children, 'folder' => true];
        }
    }


    /**
     * Funcion auxiliar recursiva y estatica donde se crea el menu para el usuario administrador
     * @param $opcion = modelo Menu
     * @return array con title = titulo ha renderizar en el menu, children = hijos de esa categoria del menu, folder = ?
     */
    public static function obtenerHijosArrayAdmin($opcion)
    {
      $htmlEditar = "<button class='btn btn-mini btn-success' data-role='opcion-menu-render-actualizar' data-opcion='$opcion->idMenu'>
                        Editar
                     </button>";

      if(!empty($opcion->objOpcion)){ // es hoja

        $htmlRelacion = '';

        if (!empty($opcion->objOpcion)) {

          $dataOpcion  = $opcion->objOpcion->idOpcion;
          $htmlRelacion = "<button class='btn btn-mini btn-success' data-role='quitar-enlace-menu'
                          data-opcion='$dataOpcion' >
                            Eliminar enlace
                          </button>";
        }

        return [
          'title' => "
                      <div class='panel-default'>
                        <div class=' panel-heading'>
                         <h6 class='panel-title' style='font-size: 13px;'>
                            $opcion->descripcion
                         </h6>
                         $htmlEditar
                         $htmlRelacion
                        </div>
                      </div>",
        ];

      }else{ // tiene hijos

        $children= [];
        $htmlRelacion = '';

        if (!empty($opcion->listSubMenu)) {

          foreach($opcion->listSubMenu as $opcionHijo){
              $children[] = self::obtenerHijosArrayAdmin($opcionHijo);
          }
        }else{

          $htmlRelacion = "<button class='btn btn-mini btn-success' data-role='agregar-enlace-menu' data-opcion='$opcion->idMenu' >
                            Agregar enlaces
                          </button>";
        }

        return [
          'title' => "
                      <div class='panel-default'>
                        <div class=' panel-heading'>
                         <h6 class='panel-title' style='font-size: 13px;'>
                            $opcion->descripcion
                         </h6>
                         $htmlEditar
                         <button class='btn btn-mini btn-success' data-role='opcion-menu-render-crear' data-padre='$opcion->idMenu'>
                              Agregar
                         </button>
                         $htmlRelacion
                        </div>
                      </div>",
          'children' => $children,
          'folder' => true
        ];
      }

    }

    /**
     * Funcion para asignar el atributo idRaiz al modelo Menu
     * @param
     * @return
     */
    public function setIdRaiz()
    {
      if ($this->esNodoRaiz()) {
        $this->idRaiz = $this->idMenu;
      }else {
        $this->idRaiz = $this->idPadre;
      }
    }

    /**
     * Funcion que indica si un modelo Menu es raiz
     * @param
     * @return bool true || bool false
     */
    public function esNodoRaiz()
    {
      if (is_null($this->idPadre)) {
        return true;
      }else{
        return false;
      }
    }
}
