<?php

use yii\db\Migration;

class m170424_163532_crea_m_FORCO_Premios extends Migration
{
    public function up()
    {
    	$this->createTable('m_FORCO_Premio', [
            'idPremio' => $this->integer(10)->unsigned()->notNull() .' NOT NULL AUTO_INCREMENT',
            'nombrePremio' => $this->string(100),
    		'descripcionPremio' => 'LONGTEXT',
            'idCategoria' => $this->integer(10)->unsigned(),
    		'puntosRedimir' => $this->integer()->unsigned(),
    		'estado' => 'TINYINT(1) NOT NULL DEFAULT 1',
    		'cantidad' => $this->integer()->unsigned(),
            'rutaImagen' => $this->string(100),
    		'fechaInicioVigencia' => $this->dateTime(),
    		'fechaFinVigencia' => $this->dateTime(),
            'fechaCreacion' => $this->dateTime(),
            'fechaActualizacion' => $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'PRIMARY KEY (idPremio)'
        ]);
    	// Llaves foraneas
    	$this->addForeignKey(
    			'fk_m_FORCO_Premio_m_FORCO_CategoriasPremios',
    			'm_FORCO_Premio',
    			'idCategoria',
    			'm_FORCO_CategoriasPremios',
    			'idCategoria'
    			);

    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_m_FORCO_Premio_m_FORCO_CategoriasPremios',
            'm_FORCO_Premio'
        );
        $this->dropTable('m_FORCO_Premio');
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
