<?php

use yii\db\Migration;

class m170321_170628_elimina_fechaInicio_fechaFin_m_FORCO_Contenido extends Migration
{
    public function up()
    {
        $this->dropColumn('m_FORCO_Contenido', 'fechaInicio');
        $this->dropColumn('m_FORCO_Contenido', 'fechaFin');
    }

    public function down()
    {
        $this->addColumn('m_FORCO_Contenido', 'fechaInicio', $this->dateTime());
        $this->addColumn('m_FORCO_Contenido', 'fechaFin', $this->dateTime());
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
