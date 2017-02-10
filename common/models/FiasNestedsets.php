<?php

namespace ejen\fias\common\models;

use creocoder\nestedsets\NestedSetsBehavior;

class FiasNestedsets extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%fias_nestedsets}}';
    }

    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                'leftAttribute' => 'left',
                'rightAttribute' => 'right',
                'depthAttribute' => 'level',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new FiasNestedsetsQuery(get_called_class());
    }
}
