<?php

namespace ejen\fias\common\helpers;

use ejen\fias\common\models\FiasAddrobj;
use ejen\fias\common\models\FiasHouse;
use ejen\fias\common\models\FiasLandmark;

class FiasHelper
{
    public static function toFullString($id, $separator = ", ")
    {    
        if ($house = FiasHouse::findOne(['houseguid' => $id]))
        {
            $parent = FiasAddrobj::findOne(['aoguid' => $house->aoguid]);
            $result = $house->housenum;
        }
        elseif($landmark = FiasLandmark::findOne(['landguid' => $id]))
        {
            $parent = FiasAddrobj::findOne(['aoguid' => $landmark->aoguid]);
            $result = $landmark->location;
        }
        else
        {
            $current = FiasAddrobj::find()->andWhere(['aoguid' => $id, 'currstatus' => 0])->one();
            $parent  = FiasAddrobj::find()->andWhere(['aoguid' => $current->parentguid, 'currstatus' => 0])->one();
            $result = $current->fullName;
        }


        if ($parent)
        {
            $result = static::toFullString($parent->aoguid, $separator).$separator.$result;
        }

        return $result;
    }

    public static function toString($id, $separator = ", ")
    {    
        if ($house = FiasHouse::findOne(['houseguid' => $id]))
        {
            $parent = FiasAddrobj::findOne(['aoguid' => $house->aoguid]);
            $result = $house->housenum;
        }
        elseif($landmark = FiasLandmark::findOne(['landguid' => $id]))
        {
            $parent = FiasAddrobj::findOne(['aoguid' => $landmark->aoguid]);
            $result = $landmark->location;
        }
        else
        {
            $current = FiasAddrobj::find()->andWhere(['aoguid' => $id, 'currstatus' => 0])->one();
            //$parent  = FiasAddrobj::find()->andWhere(['aoguid' => $current->parentguid, 'currstatus' => 0])->one();
            //$result = $current->name;
            $parent = null;
            $result = $current->fullname;
        }


        if ($parent)
        {
            $result = static::toString($parent->aoguid, $separator).$separator.$result;
        }

        return $result;
    }

}
