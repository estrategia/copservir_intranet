<?php

use yii\db\Migration;

class m170620_221329_agrega_prioridad_a_m_FORCO_Curso extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Curso', 'prioridad', $this->integer()->unsigned()->notNull());
    }

    public function down()
    {
        $this->dropColumn('m_FORCO_Curso', 'prioridad');
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
