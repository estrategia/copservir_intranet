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

    public static function tableName() {
        return 'm_ModuloContenido';
    }

    public function rules() {
        return [
            [['tipo', 'titulo', 'descripcion', 'contenido', 'fechaRegistro'], 'required'],
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
                ->addParams([':grupo' => $idGrupo])
                ->all();
        return $query;
    }

}
