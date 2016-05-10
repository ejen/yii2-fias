<?php

use yii\db\Migration;

class m160510_195845_socrbase extends Migration
{
    public $tableName = '{{%socrbase}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'level' => 'INT',
            'scname' => 'VARCHAR(10)',
            'socrname' => 'VARCHAR(50)',
            'kod_t_st' => 'VARCHAR(4)',
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
