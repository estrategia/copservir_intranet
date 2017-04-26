<?php

use yii\db\Migration;

class m170425_172812_premios_newColumns_chooseType extends Migration
{
    public function up()
    {
    	$this->addColumn('m_FORCO_Premio', 'tipoRedimir', 'tinyInt not null');
    	$this->addColumn('m_FORCO_Premio', 'numeroPremios', $this->integer(10)->null());
    }

    public function down()
    {
        $this->dropColumn('m_FORCO_Premio', 'idPuntoSincronizado');
        $this->dropColumn('m_FORCO_Premio', 'numeroPremios');
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
