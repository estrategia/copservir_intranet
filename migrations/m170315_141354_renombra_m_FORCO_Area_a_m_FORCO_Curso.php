<?php

use yii\db\Migration;

class m170315_141354_renombra_m_FORCO_Area_a_m_FORCO_Curso extends Migration
{
    // public function up()
    // {

    // }

    // public function down()
    // {
    //     echo "m170315_141354_renombra_m_FORCO_Area_a_m_FORCO_Curso cannot be reverted.\n";

    //     return false;
    // }

    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->dropForeignKey('fk_m_FORCO_Contenido_m_FORCO_Area1', 'm_FORCO_Contenido');
        $this->dropTable('m_FORCO_Area');
        $this->createTable('m_FORCO_Curso', [
            'idCurso' => $this->primaryKey(),
            'nombreCurso' => $this->string(45),
            'presentacionCurso' => $this->string(250),
            'estadoCurso' => 'TINYINT(1) NOT NULL DEFAULT 1',
            'fechaCreacion' => $this->dateTime(),
            'fechaActualizacion' => $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->alterColumn('m_FORCO_Curso', 'idCurso', $this->integer(10)->unsigned() .' NOT NULL AUTO_INCREMENT');
    }

    public function safeDown()
    {
        $this->dropTable('m_FORCO_Curso');
        $this->createTable('m_FORCO_Area', [
            'idAreaConocimiento' => $this->primaryKey(),
            'nombreCurso' => $this->string(45),
            'presentacionCurso' => $this->string(250),
            'estadoArea' => 'TINYINT(1) NOT NULL DEFAULT 1',
            'fechaCreacion' => $this->dateTime(),
            'fechaActualizacion' => $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->alterColumn('m_FORCO_Area', 'idAreaConocimiento', $this->integer(10)->unsigned() .' NOT NULL AUTO_INCREMENT');
        $this->addForeignKey(
            'fk_m_FORCO_Contenido_m_FORCO_Area1',
            'm_FORCO_Contenido',
            'idAreaConocimiento',
            'm_FORCO_Area',
            'idAreaConocimiento'
        );
    }
    
}
