<?php

namespace ejen\fias\common\models;

class FiasAddrobj extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%fias_addrobj}}';
    }

    public function getFullName()
    {
        switch ($this->aolevel)
        {
            // Регион
            case 1:
                if ($this->shortname == 'обл') return $this->formalname." область";
                break;
            // Район
            case 3:
                if ($this->shortname == 'р-н') return $this->formalname." район";
                break;
            case 4:
                if ($this->shortname == 'г') return "город ".$this->formalname;
                break;
            // Населенный пункт
            case 6:
                if ($this->shortname == 'д') return "деревня ".$this->formalname;
                if ($this->shortname == 'с') return "село ".$this->formalname;
                if ($this->shortname == 'рп') return "рабочий поселок ".$this->formalname;
                break;
        }
        return $this->formalname." ".$this->shortname;
    }

    public function getName()
    {
        return $this->formalname." ".$this->shortname;
    }
}
