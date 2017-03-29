<?php

use yii\db\Migration;

class m170327_134318_agrega_referencia_m_FORCO_TipoContenido_m_FORCO_Curso extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Curso', 'idTipoContenido', $this->integer(10)->unsigned()->notNull());

        $this->addForeignKey(
            'fk_m_FORCO_Curso_m_FORCO_TipoContenido',
            'm_FORCO_Curso',
            'idTipoContenido',
            'm_FORCO_TipoContenido',
            'idTipoContenido'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_m_FORCO_Curso_m_FORCO_TipoContenido',
            'm_FORCO_Curso'
        );

        $this->dropColumn('m_FORCO_Curso', 'idTipoContenido');
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
