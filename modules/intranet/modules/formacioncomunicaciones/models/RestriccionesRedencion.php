<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "t_FORCO_RestriccionesRedencion".
 *
 * @property string $numeroDocumento
 * @property string $fechaCreacion
 */
class RestriccionesRedencion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_RestriccionesRedencion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento'], 'required'],
            [['numeroDocumento'], 'integer'],
            [['fechaCreacion'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numeroDocumento' => 'Numero Documento',
            'fechaCreacion' => 'Fecha Creacion',
        ];
    }

    public static function cargarExcel($rutaAchivo)
    {
        $tipoArchivo = \PHPExcel_IOFactory::identify($rutaAchivo);
        $objectReader = \PHPExcel_IOFactory::createReader($tipoArchivo);
        $objectPHPExcel = $objectReader->load($rutaAchivo);
        $hoja = $objectPHPExcel->getActiveSheet();
        $numerosDocumento = [];
        $numeroDocumento = null;
        for ($indiceFila=2; true; $indiceFila++) { 
            $numeroDocumento = $hoja->getCell('A'.$indiceFila)->getValue();
            if (is_null($numeroDocumento)) {
                break;
            }
            $numerosDocumento[] = ['numeroDocumento' => $numeroDocumento];
        }

        // \yii\helpers\VarDumper::dump($numerosDocumento,10,true);
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            \Yii::$app->db->createCommand()->batchInsert(self::tableName(),
                ['numeroDocumento'], $numerosDocumento)->execute();
            
            $transaction->commit();
        }catch (\Exception $exc){
            $transaction->rollBack();
            throw new \Exception($exc->getMessage() . " - " . $exc->getCode() . " -", 310);
        }
        return true;
    }

    public function getObjUsuario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    public function getObjUsuarioIntranet()
    {
        return $this->hasOne(\app\modules\intranet\models\UsuarioIntranet::className(), ['numeroDocumento' => 'numeroDocumento']);
    }
}
