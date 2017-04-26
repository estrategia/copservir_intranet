<?php

use yii\db\Migration;

class m170426_165936_crea_mforco_puntostotal extends Migration
{
    public function up()
    {
    	$this->createTable('t_FORCO_PuntosTotales', [
    			'numeroDocumento' => $this->bigInteger(20)->unsigned()->notNull(),
    			'puntos' => $this->integer(10)->unsigned()->notNull(),
    			'fechaActualizacion' =>  $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    			'PRIMARY KEY (numeroDocumento)'
    	]);
    	
    	$this->addForeignKey(
    			'fk_t_FORCO_PuntosTotales_m_Usuario',
    			't_FORCO_PuntosTotales',
    			'numeroDocumento',
    			'm_Usuario',
    			'numeroDocumento'
    	);
    }

    public function down()
    {
         $this->dropForeignKey(
            't_FORCO_PuntosTotales',
            'fk_t_FORCO_PuntosTotales_m_Usuario'
        );

        $this->dropTable('t_FORCO_PuntosTotales');
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
