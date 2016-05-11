<?php

namespace ejen\fias\console\controllers;

use Yii;

use ejen\fias\common\models\FiasActstat;
use ejen\fias\common\models\FiasAddrobj;
use ejen\fias\common\models\FiasCenterst;
use ejen\fias\common\models\FiasCurentst;
use ejen\fias\common\models\FiasDaddrobj;
use ejen\fias\common\models\FiasDhouse;
use ejen\fias\common\models\FiasDhousint;
use ejen\fias\common\models\FiasDlandmrk;
use ejen\fias\common\models\FiasDnordoc;
use ejen\fias\common\models\FiasEststat;
use ejen\fias\common\models\FiasHouse;
use ejen\fias\common\models\FiasHouseint;
use ejen\fias\common\models\FiasHststat;
use ejen\fias\common\models\FiasIntvstat;
use ejen\fias\common\models\FiasLandmark;
use ejen\fias\common\models\FiasNordoc;
use ejen\fias\common\models\FiasOperstat;
use ejen\fias\common\models\FiasStrstat;
use ejen\fias\common\models\FiasSocrbase;

class FiasController extends \yii\console\Controller
{
    public $region;

    public function options()
    {
        return [
            'region',
        ];
    }

    public function actionImportDbf($filename, $region = false)
    {
        $db = @dbase_open($filename, 0);
        if (!$db)
        {
            $this->stderr("Не удалось открыть DBF файл: '$filename'\n");
            return 1;
        }

        $classMap = [
            '/^.*DADDROBJ\.DBF$/'   => FiasDaddrobj::className(),
            '/^.*ADDROBJ\.DBF$/'    => FiasAddrobj::className(),
            '/^.*LANDMARK\.DBF$/'   => FiasLandmark::className(),
            '/^.*DHOUSE\.DBF$/'     => FiasDhouse::className(),
            '/^.*HOUSE\d\d\.DBF$/'  => FiasHouse::className(),
            '/^.*DHOUSINT\.DBF$/'   => FiasDhousint::className(),
            '/^.*HOUSEINT\.DBF$/'   => FiasHouseint::className(),
            '/^.*DLANDMRK\.DBF$/'   => FiasDlandmrk::className(),
            '/^.*DNORDOC\.DBF$/'    => FiasDnordoc::className(),
            '/^.*NORDOC\d\d\.DBF$/' => FiasNordoc::className(),
            '/^.*ESTSTAT\.DBF$/'    => FiasDhousint::className(),
            '/^.*ACTSTAT\.DBF$/'    => FiasActstat::className(),
            '/^.*CENTERST\.DBF$/'   => FiasCenterst::className(),
            '/^.*ESTSTAT\.DBF$/'    => FiasEststat::className(),
            '/^.*HSTSTAT\.DBF$/'    => FiasHststat::className(),
            '/^.*OPERSTAT\.DBF$/'   => FiasOperstat::className(),
            '/^.*INTVSTAT\.DBF$/'   => FiasIntvstat::className(),
            '/^.*STRSTAT\.DBF$/'    => FiasStrstat::className(),
            '/^.*CURENTST\.DBF$/'   => FiasCurentst::className(),
            '/^.*SOCRBASE\.DBF$/'   => FiasSocrbase::className(),
        ];

        $modelClass = false;
        foreach($classMap as $pattern => $className)
        {
            if (preg_match($pattern, $filename))
            {
                $modelClass = $className;
                break;
            }
        }

        if ($modelClass === false)
        {
            $this->stderr("Не поддерживаемый DBF файл: '$filename'\n");
            return 1;
        }


        $rowsCount = dbase_numrecords($db);
        $this->stdout("Записей в DBF файле '$filename' : $rowsCount\n");

        $j = 0;
        for ($i = 1; $i <= $rowsCount; $i++)
        {

            $row = dbase_get_record_with_names($db, $i);

            if ($modelClass == FiasAddrobj::className() && $this->region && intval($row['REGIONCODE']) != intval($this->region))
            {
                continue;
            }

            if ($j == 0)
            {
                $transaction = Yii::$app->db->beginTransaction();
            }

            $model = new $modelClass;
            foreach($row as $key => $value)
            {
                if ($key == 'deleted') continue;
                $key = strtolower($key);
                $model->{$key} = trim(mb_convert_encoding($value, 'UTF-8', 'CP866'));
            }
            $model->save();
            $j++;
            if ($j == 1000)
            {
                $transaction->commit();
                $j = 0;
                $this->stdout("Обработано $i из $rowsCount записей\n");
            }
        }

        if ($j != 0)
        {
            $transaction->commit();
        }
        return 0;
    }
}
