<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_usuario".
 *
 * @property string $idUsuario
 * @property string $numeroDocumento
 * @property string $alias
 * @property integer $estado
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_Usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'estado'], 'required'],
            [['numeroDocumento', 'estado'], 'integer'],
            [['alias'], 'string', 'max' => 60],
            [['numeroDocumento'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idUsuario' => 'Id Usuario',
            'numeroDocumento' => 'Numero Documento',
            'alias' => 'Alias',
            'estado' => 'Estado',
            'imagenPerfil' => 'Imagen Perfil',
        ];
    }


    /**
    * Consulta una lista de usuarios que sera cargada en el selector de enviar a un amigo
    * @param none
    * @return array usuarios
    */
    public static function listaUsuariosEnviarAmigo($idContenido)
    {
      //Usuario::find()->where([ 'estado' => 1])->andWhere(['<>', 'numeroDocumento', Yii::$app->user->identity->numeroDocumento])->all();
      $idUsuario = Yii::$app->user->identity->numeroDocumento;
      $fecha = Date("Y-m-d H:i:s");

      $query = self::find()
            ->where("(
                estado=:estado
                and numeroDocumento not in (select numeroDocumentoDirigido from `t_ContenidoRecomendacion`
				        where (`fechaRegistro` <=:fechaRegistro) and (`idContenido`=:idContenido))
                and numeroDocumento !=:idUsuario )")
            ->addParams([':estado' => 1,':idUsuario'=>$idUsuario, ':fechaRegistro'=>$fecha, ':idContenido'=>$idContenido])->all();

      return $query;
    }



}
