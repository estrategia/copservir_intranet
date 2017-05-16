<?php

use yii\db\Migration;

class m170321_143024_agrega_referencia_m_FORCO_Modulo_m_FORCO_Capitulo extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Capitulo', 'idModulo', $this->integer(10)->unsigned()->notNull());

        $this->addForeignKey(
            'fk_m_FORCO_Capitulo_m_FORCO_Modulo',
            'm_FORCO_Capitulo',
            'idModulo',
            'm_FORCO_Modulo',
            'idModulo'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_m_FORCO_Capitulo_m_FORCO_Modulo',
            'm_FORCO_Capitulo'
        );

        $this->dropColumn('m_FORCO_Modulo', 'idModulo');
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
