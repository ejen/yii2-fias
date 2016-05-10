<?php

use yii\db\Migration;

class m160510_195826_nordoc extends Migration
{
    public $tableName = '{{%nordoc}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'normdocid' => 'VARCHAR(36)',
            'docname' => 'TEXT', // "memo" type in dbf file
            'docdate' => 'DATE',
            'docnum' => 'VARCHAR(20)',            
            'doctype' => 'INT',
            'docimgid' => 'INT',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
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
