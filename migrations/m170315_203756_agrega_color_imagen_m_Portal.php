<?php

use yii\db\Migration;

class m170315_203756_agrega_color_imagen_m_Portal extends Migration
{
    public function up()
    {
        $this->addColumn('m_Portal', 'colorPortal', $this->string(10));
        $this->addColumn('m_Portal', 'logoPortal', $this->string(250));
    }

    public function down()
    {
        $this->dropColumn('m_Portal', 'colorPortal');
        $this->dropColumn('m_Portal', 'logoPortal');
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
