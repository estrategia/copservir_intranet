<?php

use yii\db\Migration;

class m170303_164620_agrega_descripcion_titulo_contenido_forcom extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Contenido', 'tituloContenido', $this->string(255)->notNull());
        $this->addColumn('m_FORCO_Contenido', 'descripcionContenido', $this->string(255)->notNull());
    }

    public function down()
    {
        $this->addColumn('m_FORCO_Contenido', 'tituloContenido');
        $this->addColumn('m_FORCO_Contenido', 'descripcionContenido');
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
