<?php

use yii\db\Migration;

class m170503_164708_agrega_idCurso_m_forco_premio extends Migration
{
    public function up()
    {
    	$this->addColumn('m_FORCO_Premio', 'idCuestionario', $this->integer(10)->unsigned()->null());
    	
    	$this->addForeignKey(
    			'fk_m_FORCO_Premio_m_FORCO_Cuestionario',
    			'm_FORCO_Premio',
    			'idCuestionario',
    			'm_FORCO_Cuestionario',
    			'idCuestionario'
    			);
    }

    public function down()
    {
         $this->dropColumn('m_FORCO_Premio', 'idCuestionario');
         $this->dropTable('fk_m_FORCO_Premio_m_FORCO_Cuestionario');
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
