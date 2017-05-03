<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_ModuloContenido".
 *
 * @property string $idModulo
 * @property integer $tipo
 * @property string $titulo
 * @property string $descripcion
 * @property string $contenido
 * @property string $fechaRegistro
 * @property string $fechaActualizacion
 *
 * @property GruposModulos[] $GruposModulos
 */
class ModuloContenido extends \yii\db\ActiveRecord {
    const TIPO_HTML = 1;
    const TIPO_DATATABLE = 2;
    const TIPO_GROUP_MODULES = 3;
    const TIPO_DATATABLE_CEDULA = 4;
    const TIPO_GALERIA = 5;

    public $imagenes;

    public static function tableName() {
        return 'm_ModuloContenido';
    }

    public function rules() {
        return [
            [['tipo', 'titulo', 'descripcion',  'fechaRegistro'], 'required'],
            [['tipo'], 'integer'],
            [['contenido'], 'string'],
            [['fechaRegistro', 'fechaActualizacion'], 'safe'],
            [['titulo'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 500],
        ];
    }

    public function attributeLabels() {
        return [
            'idModulo' => 'Id Modulo',
            'tipo' => 'Tipo',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'contenido' => 'Contenido',
            'fechaRegistro' => 'Fecha Registro',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }

    // RELACIONES

    public function getListGruposModulos() {
        return $this->hasMany(GruposModulos::className(), ['idModulo' => 'idModulo']);
    }

    public static function getModulosGrupo($idGrupo) {
        $query = self::find()
                ->joinWith(['listGruposModulos'])
                ->where("t_GruposModulos.idGruposModulos=:grupo")
                ->orderBy('t_GruposModulos.orden ASC')
                ->addParams([':grupo' => $idGrupo]);
        //var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);exit;
        return $query->all();
    }

    public static function getModulo($idModulo) {
        $query = self::find()
                ->where("idModulo=:modulo")
                ->addParams([':modulo' => $idModulo])
                ->one();
        return $query;
    }

    public function getContenido(){
        $contenido = Funciones::reemplazarPatronDocumentoUsuario($this->contenido);
        return $contenido;
    }

    public function getImagenesGaleria()
    {
      return $this->hasMany(ImagenesModuloGaleria::classname(), ['idModulo' => 'idModulo'])->orderBy(['orden' => SORT_ASC]);
    }

    public function guardarImagenes() {

      // $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
      //   if (!empty($this->imagenes)) {

      //       foreach ($this->imagenes['tmp_name'] as $key => $value) {
      //           // var_dump($this->imagenes);
      //           // var_dump($value);
      //           if (is_uploaded_file($value)) {

      //               //$rutaArchivo = Yii::getAlias('@webroot') . "/img/imagenesContenidos/".$this->imagenes['name'][$key];
      //               $rutaGuardarArchivo = Yii::getAlias('@webroot') . "/img/imagenesContenidos/".time().'_'.$numeroDocumento.'_'
      //                 .$this->imagenes['name'][$key];
      //               $contenidoAdjunto = new ContenidoAdjunto;

      //               $contenidoAdjunto->idContenido = $this->idContenido;
      //               $contenidoAdjunto->tipo = ContenidoAdjunto::TIPO_IMAGEN;
      //               $contenidoAdjunto->rutaArchivo = time().'_'.$numeroDocumento.'_'.$this->imagenes['name'][$key];
      //               if (!is_file($rutaGuardarArchivo)) {

      //                   // move_uploaded_file($value, $rutaGuardarArchivo);
      //                   $this->reducirImagen($value, $rutaGuardarArchivo, pathinfo($contenidoAdjunto->rutaArchivo, PATHINFO_EXTENSION));
      //               }

      //               if (!$contenidoAdjunto->save()) {
      //                   throw new \Exception("Error al guardar las imagenes:" . json_encode($contenidoAdjunto->getErrors()), 100);
      //               }
      //           }else{
      //             throw new \Exception("Error al guardar las imagenes" , 100);
      //           }
      //       }
      //   }
    }

}
