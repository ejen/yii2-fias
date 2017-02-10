<?php

namespace ejen\fias\common\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

class FiasNestedsetsQuery extends \yii\db\ActiveQuery
{

    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }    

}
