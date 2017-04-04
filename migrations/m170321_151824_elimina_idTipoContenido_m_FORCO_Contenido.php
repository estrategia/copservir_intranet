<?php

use yii\db\Migration;

class m170321_151824_elimina_idTipoContenido_m_FORCO_Contenido extends Migration
{
    public function up()
    {
        $this->dropColumn('m_FORCO_Contenido', 'idAreaConocimiento');
    }

    public function down()
    {
        $this->addColumn('m_FORCO_Contenido', 'idTipoContenido', $this->integer(10)->unsigned()->notNull());
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
