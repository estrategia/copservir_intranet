<?php

use yii\db\Migration;

class m170308_221419_crea_t_FORCO_ContenidoGruposInteres extends Migration
{
    public function up()
    {
        $this->createTable('t_FORCO_ContenidoGruposInteres', [
            'idGrupoInteres' => $this->integer(10)->unsigned()->notNull(),
            'idContenido' => $this->integer(10)->unsigned()->notNull(),
            'PRIMARY KEY (idGrupoInteres, idContenido)'
        ]);

        $this->addForeignKey(
            'fk_t_FORCO_ContenidoGruposInteres_m_GrupoInteres',
            't_FORCO_ContenidoGruposInteres',
            'idGrupoInteres',
            'm_GrupoInteres',
            'idGrupoInteres'
        );

        $this->addForeignKey(
            'fk_t_FORCO_ContenidoGruposInteres_m_FORCO_Contenido',
            't_FORCO_ContenidoGruposInteres',
            'idContenido',
            'm_FORCO_Contenido',
            'idContenido'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_t_FORCO_ContenidoGruposInteres_m_GrupoInteres',
            't_FORCO_ContenidoGruposInteres'
        );

        $this->dropForeignKey(
            'fk_t_FORCO_ContenidoGruposInteres_m_FORCO_Contenido',
            't_FORCO_ContenidoGruposInteres'
        );

        $this->dropTable('t_FORCO_ContenidoGruposInteres');
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
