<?php

use yii\db\Migration;

class m170330_224755_crea_t_FORCO_ContenidoLeidoUsuario extends Migration
{
    public function up()
    {
        $this->createTable('t_FORCO_ContenidoLeidoUsuario', [
            'numeroDocumento' => $this->bigInteger(20)->unsigned()->notNull(),
            'idContenido' => $this->integer(10)->unsigned(),
            'fechaCreacion' => $this->dateTime(),
            'PRIMARY KEY (numeroDocumento, idContenido)'
        ]);

        $this->addForeignKey(
            'fk_t_FORCO_ContenidoLeidoUsuario_m_FORCO_Contenido',
            't_FORCO_ContenidoLeidoUsuario',
            'idContenido',
            'm_FORCO_Contenido',
            'idContenido'
        );

        $this->addForeignKey(
            'fk_t_FORCO_ContenidoLeidoUsuario_m_Usuario',
            't_FORCO_ContenidoLeidoUsuario',
            'numeroDocumento',
            'm_Usuario',
            'numeroDocumento'
        );
    
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_t_FORCO_ContenidoLeidoUsuario_m_FORCO_Contenido',
            't_FORCO_ContenidoLeidoUsuario'
        );

        $this->dropForeignKey(
            'fk_t_FORCO_ContenidoLeidoUsuario_m_Usuario',
            't_FORCO_ContenidoLeidoUsuario'
        );

        $this->dropTable('t_FORCO_ContenidoLeidoUsuario');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
