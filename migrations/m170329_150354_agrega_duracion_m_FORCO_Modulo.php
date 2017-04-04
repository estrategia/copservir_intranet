<?php

use yii\db\Migration;

class m170329_150354_agrega_duracion_m_FORCO_Modulo extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Modulo','duracionDias', $this->integer(3)->unsigned()->notNull());
        $this->addColumn('m_FORCO_Modulo','fechaInicio', $this->dateTime());
        $this->addColumn('m_FORCO_Modulo','fechaFin', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('m_FORCO_Modulo','duracionDias');
        $this->dropColumn('m_FORCO_Modulo','fechaInicio');
        $this->dropColumn('m_FORCO_Modulo','fechaFin');
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
