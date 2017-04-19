<?php

use yii\db\Migration;

class m170417_191008_agrega_tiempoRequerido_m_FORCO_Contenido extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Contenido', 'tiempoRequerido', $this->integer(10)->unsigned()->notNull());
    }

    public function down()
    {
        $this->dropColumn('m_FORCO_Contenido', 'tiempoRequerido');
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
