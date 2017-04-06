<?php

use yii\db\Migration;

class m170405_222740_agrega_idCurso_m_FORCO_Contenido extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Contenido', 'idCurso', $this->integer(10)->unsigned());
        $this->addForeignKey(
            'fk_m_FORCO_Contenido_m_FORCO_Curso',
            'm_FORCO_Contenido',
            'idCurso',
            'm_FORCO_Curso',
            'idCurso'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_m_FORCO_Contenido_m_FORCO_Curso', 'm_FORCO_Contenido');
        $this->dropColumn('m_FORCO_Contenido', 'idCurso');
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
