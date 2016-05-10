<?php

namespace ejen\fias\console\controllers;

use Yii;

use ejen\fias\common\models\FiasAddrobj;
use ejen\fias\common\models\FiasHouse;

class FiasController extends \yii\console\Controller
{
    public function actionImportDbf($filename)
    {
        $db = @dbase_open($filename, 0);
        if (!$db)
        {
            $this->stderr("Не удалось открыть DBF файл: '$filename'\n");
            return 1;
        }

        if (preg_match('/^.*ADDROBJ\.DBF$/', $filename))
        {
            $modelClass = FiasAddrobj::className();
        }
        elseif (preg_match('/^.*HOUSE\d\d\.DBF$/', $filename))
        {
            $modelClass = FiasHouse::className();
        }
        else
        {
            $this->stderr("Не поддерживаемый DBF файл: '$filename'\n");
            return 1;
        }


        $rowsCount = dbase_numrecords($db);
        $this->stdout("Записей в DBF файле '$filename' : $rowsCount\n");

        $j = 0;
        for ($i = 1; $i != $rowsCount; $i++)
        {
            if ($j == 0)
            {
                $transaction = Yii::$app->db->beginTransaction();
            }

            $row = dbase_get_record_with_names($db, $i);

            //$regionCode = (int) $row['REGIONCODE'];
            //if ($regionCode != 60) continue;

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
                $this->stdout("Импортировано $i из $rowsCount записей\n");
            }
        }

        if ($j != 0)
        {
            $transaction->commit();
        }
        return 0;
    }
}
