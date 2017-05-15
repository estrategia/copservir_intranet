<?php

use yii\db\Migration;

class m170306_220716_elimina_notnull_idContenidoCopia extends Migration
{
    public function up()
    {
        $this->alterColumn('m_FORCO_Contenido', 'idContenidoCopia', $this->integer(10)->unsigned()->null()->defaultValue(null));
    }

    public function down()
    {
        $this->alterColumn('m_FORCO_Contenido', 'idContenidoCopia', $this->integer(10)->unsigned()->notNull());
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
