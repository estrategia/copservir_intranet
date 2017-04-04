<?php

use yii\db\Migration;

class m170321_144430_elimina_referencias_no_usadas_m_FORCO_Contenido extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_m_FORCO_Contenido_m_FORCO_Modulo1', 'm_FORCO_Contenido');
        $this->dropColumn('m_FORCO_Contenido', 'idModulo');
        $this->dropForeignKey('fk_m_FORCO_Contenido_m_FORCO_TipoContenido1', 'm_FORCO_Contenido');
        $this->dropColumn('m_FORCO_Contenido', 'idTipoContenido');
    }

    public function down()
    {
        $this->addColumn('m_FORCO_Contenido', 'idModulo', $this->integer(10)->unsigned()->notNull());
        $this->addForeignKey(
            'fk_m_FORCO_Contenido_m_FORCO_Modulo1',
            'm_FORCO_Contenido',
            'idModulo',
            'm_FORCO_Modulo'
        );

        $this->addColumn('m_FORCO_Contenido', 'idTipoContenido', $this->integer(10)->unsigned()->notNull());
        $this->addForeignKey(
            'fk_m_FORCO_Contenido_m_FORCO_TipoContenido1',
            'm_FORCO_Contenido',
            'idTipoContenido',
            'm_FORCO_TipoContenido'
        );
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
