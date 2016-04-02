<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_Notificaciones".
 *
 * @property string $idNotificacion
 * @property string $idUsuarioDirige
 * @property string $idUsuarioDirigido
 * @property string $descripcion
 * @property string $idTipoNotificacion
 * @property integer $estadoNotificacion
 * @property string $fechaRegistro
 */
class Notificaciones extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    const NOTIFICACION_MEGUSTA = 1;
    const NOTIFICACION_COMENTARIO = 2;
    const NOTIFICACION_RECOMENDACION = 3;
    const ESTADO_CREADA = 1;
    const ESTADO_VISTA = 2;

    public static function tableName() {
        return 't_Notificaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['idUsuarioDirige', 'idUsuarioDirigido', 'tipoNotificacion', 'estadoNotificacion', 'idContenido'], 'integer'],
            [['idUsuarioDirigido', 'descripcion', 'tipoNotificacion', 'estadoNotificacion', 'idContenido'], 'required'],
            [['descripcion', 'fechaRegistro'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'idNotificacion' => 'Id Notificacion',
            'idUsuarioDirige' => 'Id Usuario Dirige',
            'idUsuarioDirigido' => 'Id Usuario Dirigido',
            'descripcion' => 'Descripcion',
            'tipoNotificacion' => 'Tipo Notificacion',
            'estadoNotificacion' => 'Estado Notificacion',
            'fechaRegistro' => 'Fecha Registro',
            'idContenido' => 'Id Contenido',
        ];
    }

    public function consultarTiempo() {
        $dateFin = new \DateTime;

        //echo $dateFin->format('Y-m-d H:i:s');
        //echo "<br/>";

        if ($dateFin->format('H:i:s') == '23:59:00') {
            $dateFin->modify('+1 minute');
        }

        $dateInicio = \DateTime::createFromFormat('Y-m-d H:i:s', $this->fechaRegistro);
        //echo $dateInicio->format('Y-m-d H:i:s');
        //echo "<br/>";

        if ($dateInicio->format('H:i:s') == '23:59:00') {
            $dateInicio->modify('+1 minute');
        }

        $diff = $dateFin->diff($dateInicio);
        $horas = ($diff->d * 24 + $diff->h);
        $minutos = ($diff->i); //($diff->d * 24 * 60 + $diff->h * 60 + $diff->i);

        return [$horas, $minutos];
    }

    public static function consultarNotificaciones($usuario, $dataProvider = false) {
        if ($dataProvider) {
            $query = self::find()
                    ->joinWith(['objUsuarioDirige', 'objContenido'])
                    ->where("idUsuarioDirigido=:usuario")
                    ->addParams([':usuario' => $usuario])
                    ->orderBy('fechaRegistro DESC');
        } else {
            $query = self::find()
                            ->joinWith(['objUsuarioDirige', 'objContenido'])
                            ->where("idUsuarioDirigido=:usuario")
                            ->addParams([':usuario' => $usuario])
                            ->limit(\Yii::$app->params['notificaciones']['limiteVisualizar'])
                            ->orderBy('fechaRegistro DESC')->all();
        }

        return $query;

        //var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        //exit();
    }

    public function getObjUsuarioDirige() {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'idUsuarioDirige']);
    }

    public function getObjContenido() {
        return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenido']);
    }

}
