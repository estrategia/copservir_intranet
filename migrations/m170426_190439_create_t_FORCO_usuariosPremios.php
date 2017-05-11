<?php

use yii\db\Migration;

class m170426_190439_create_t_FORCO_usuariosPremios extends Migration
{
    public function up()
    {
    	$this->createTable('t_FORCO_UsuariosPremios', [
    			'idUsuarioPremio' => $this->integer(10)->unsigned()->notNull().' NOT NULL AUTO_INCREMENT',
    			'idPremio' => $this->integer(10)->unsigned()->notNull(),
    			'numeroDocumento' => $this->bigInteger(20)->unsigned()->notNull(),
    			'cantidad' => $this->integer(10)->unsigned()->notNull(),
    			'puntosRedimir' => $this->integer(10)->unsigned()->notNull(),
    			'estado' => 'Tinyint not null',
    			'fechaCreacion' =>  $this->dateTime(),
    			'fechaActualizacion' =>  $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    			'PRIMARY KEY (idUsuarioPremio)'
    	]);
    	 
    	$this->addForeignKey(
    			'fk_t_FORCO_UsuariosPremios_m_FORCO_Premio',
    			't_FORCO_UsuariosPremios',
    			'idPremio',
    			'm_FORCO_Premio',
    			'idPremio'
    			);
    	 
    	$this->addForeignKey(
    			'fk_t_FORCO_UsuariosPremios_m_Usuario',
    			't_FORCO_UsuariosPremios',
    			'numeroDocumento',
    			'm_Usuario',
    			'numeroDocumento'
    			);
    	 
    	$this->createTable('t_FORCO_UsuariosPremiosTrazabilidad', [
    			'idTrazabilidad' => $this->integer(10)->unsigned()->notNull().' NOT NULL AUTO_INCREMENT',
    			'idUsuarioPremio' => $this->integer(10)->unsigned()->notNull(),
    			'idPremio' => $this->integer(10)->unsigned()->notNull(),
    			'numeroDocumento' => $this->bigInteger(20)->unsigned()->notNull(),
    			'estado' => 'Tinyint not null',
    			'numeroDocumentoTraza' => $this->bigInteger(20)->unsigned()->notNull(),
    			'fechaRegistro' =>  $this->dateTime() ,
    			'PRIMARY KEY (idTrazabilidad)'
    	]);
    	 
    	$this->addForeignKey(
    			'fk_t_FORCO_UsuariosPremiosTrazabilidad_t_FORCO_UsuariosPremios',
    			't_FORCO_UsuariosPremiosTrazabilidad',
    			'idUsuarioPremio',
    			't_FORCO_UsuariosPremios',
    			'idUsuarioPremio'
    		);
    	
    	$this->addForeignKey(
    			'fk_t_FORCO_UsuariosPremiosTrazabilidad_m_FORCO_Premio',
    			't_FORCO_UsuariosPremiosTrazabilidad',
    			'idPremio',
    			'm_FORCO_Premio',
    			'idPremio'
    		);
    	
    	$this->addForeignKey(
    			'fk_t_FORCO_UsuariosPremiosTrazabilidad_m_Usuario',
    			't_FORCO_UsuariosPremiosTrazabilidad',
    			'numeroDocumento',
    			'm_Usuario',
    			'numeroDocumento'
    			);
    }

    public function down()
    {
    	$this->dropForeignKey(
    			'fk_t_FORCO_UsuariosPremiosTrazabilidad_m_Usuario',
    			't_FORCO_UsuariosPremiosTrazabilidad'
    			);
    	
    	$this->dropForeignKey(
    			'fk_t_FORCO_UsuariosPremiosTrazabilidad_m_FORCO_Premio',
    			't_FORCO_UsuariosPremiosTrazabilidad'
    			);
    	
    	$this->dropForeignKey(
    			'fk_t_FORCO_UsuariosPremiosTrazabilidad_t_FORCO_UsuariosPremios',
    			't_FORCO_UsuariosPremios'
    			);
    	
    	$this->dropTable('t_FORCO_UsuariosPremiosTrazabilidad');
    	
    	$this->dropForeignKey(
    			'fk_t_FORCO_UsuariosPremios_m_Usuario',
    			't_FORCO_UsuariosPremios'
    			);
    	 
    	$this->dropForeignKey(
    			'fk_t_FORCO_UsuariosPremios_m_FORCO_Premio',
    			't_FORCO_UsuariosPremios'
    			);
    	 
    	$this->dropTable('t_FORCO_UsuariosPremios');
    	
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
