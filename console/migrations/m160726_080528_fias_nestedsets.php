<?php

use yii\db\Migration;

class m160726_080528_fias_nestedsets extends Migration
{
    public $tableName = '{{%fias_nestedsets}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'aoguid' => $this->string()->notNull(),
            // Nested Sets
            'tree' => $this->integer(),
            'level' => $this->integer()->notNull(),
            'left' => $this->integer()->notNull(),
            'right' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
