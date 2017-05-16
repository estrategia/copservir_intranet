<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_ImagenesModuloGaleria".
 *
 * @property integer $idImagenModuloGaleria
 * @property integer $idModulo
 * @property string $nombreImagen
 * @property string $rutaImagen
 *
 * @property MModuloContenido $idModulo0
 */
class ImagenesModuloGaleria extends \yii\db\ActiveRecord
{

    public $imagen;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_ImagenesModuloGaleria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idModulo', 'orden', 'nombreImagen'], 'required'],
            [['idImagenModuloGaleria', 'idModulo', 'orden'], 'integer'],
            [['nombreImagen'], 'string', 'max' => 60],
            [['rutaImagen'], 'string', 'max' => 255],
            [['imagen'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif'],
            [['idModulo'], 'exist', 'skipOnError' => true, 'targetClass' => ModuloContenido::className(), 'targetAttribute' => ['idModulo' => 'idModulo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idImagenModuloGaleria' => 'Id Imagen Modulo Galeria',
            'idModulo' => 'Id Modulo',
            'nombreImagen' => 'Nombre Imagen',
            'rutaImagen' => 'Ruta Imagen',
            'orden' => 'Orden',
        ];
    }

    public function guardarImagen()
    {
        if ($this->validate()) {
            $ruta = Yii::getAlias('@webroot') . "/img/imagenesModuloGaleria/{$this->idModulo}";
            $nombreArchivo = "/{$this->imagen->baseName}.{$this->imagen->extension}";
            if (!is_dir($ruta)) {
               mkdir($ruta, 0777, true);         
            }
            $this->imagen->saveAs($ruta . $nombreArchivo);
            $this->imagen = null;
            return true;
        } else {
            return false;
        }
    }

    public function getUrlImagen()
    {
        return \Yii::$app->request->BaseUrl . "/img/imagenesModuloGaleria/{$this->idModulo}/{$this->rutaImagen}";
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdModulo()
    {
        return $this->hasOne(ModuloContenido::className(), ['idModulo' => 'idModulo']);
    }
}
