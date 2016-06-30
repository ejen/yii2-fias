<?php

namespace ejen\fias\common\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

use ejen\fias\common\helpers\FiasHelper;
use ejen\fias\common\models\FiasAddrobj;
use ejen\fias\common\models\FiasHouse;
use ejen\fias\common\models\FiasLandmark;

use kartik\select2\Select2;

class FiasSelector extends \yii\widgets\InputWidget
{
    private $_level = 3;

    public function run()
    {
        $id = Html::getInputId($this->model, $this->attribute);
        $name = Html::getInputName($this->model, $this->attribute);

        Pjax::begin([
            'id' => $id,
            'enablePushState' => false,
        ]);

        if ($this->model->{$this->attribute})
        {
            echo $this->renderAddrobj($this->model->{$this->attribute});
            echo $this->renderChildren($this->model->{$this->attribute});
            // Выводит в скрытый инпут полное наименование для дальнейшего использования в гугл картах
            echo Html::hiddenInput(null, FiasHelper::toFullString($this->model->{$this->attribute}), ['class' => 'full-name']);
        }
        else
        {
            // Выводит в скрытый инпут полное наименование для дальнейшего использования в гугл картах
            echo Html::hiddenInput(null, null, ['class' => 'full-name']);
            $query = FiasAddrobj::find();
            $query->andWhere([
                'parentguid' => 'f6e148a1-c9d0-4141-a608-93e3bd95e6c4', // Псковская область
                'currstatus' => 0,
            ]);
            $query->orderBy('formalname');
            $data = ArrayHelper::map($query->all(), 'aoguid', 'name');
            echo $this->renderDropDownList($data);
        }            


        echo Html::activeHiddenInput($this->model, $this->attribute, ['id' => null]);

        $this->view->registerJs("

            $('#".$id." select').change(function(){
                
                $.pjax.defaults.data = {
                    '$name': $(this).val(),
                };

                $.pjax.reload('#".$id."', {
                    type: 'POST'
                });

            });
        ");

        Pjax::end();
    }

    private function renderAddrobj($id)
    {
        if ($house = FiasHouse::findOne(['houseguid' => $id]))
        {
            $parent = FiasAddrobj::findOne(['aoguid' => $house->aoguid]);
        }
        elseif($landmark = FiasLandmark::findOne(['landguid' => $id]))
        {
            $parent = FiasAddrobj::findOne(['aoguid' => $landmark->aoguid]);
        }
        else
        {
            $current = FiasAddrobj::find()->andWhere(['aoguid' => $id, 'currstatus' => 0])->one();
            $parent  = FiasAddrobj::find()->andWhere(['aoguid' => $current->parentguid, 'currstatus' => 0])->one();
        }

        if ($parent && $parent->aoguid != 'f6e148a1-c9d0-4141-a608-93e3bd95e6c4')
        {
            echo $this->renderAddrobj($parent->aoguid);
        }

        // Адресные объекты        
        $query = FiasAddrobj::find();
        $query->andWhere([
            'parentguid' => $parent->aoguid,
            'currstatus' => 0,
        ]);
        $query->orderBy('formalname');
        $data = ArrayHelper::map($query->all(), 'aoguid', 'name');
        
        // Дома
        $query = FiasHouse::find();
        $query->andWhere([
            'aoguid' => $parent->aoguid,
        ]);
        $query->orderBy(new \yii\db\Expression('housenum + 0'));
        $data = ArrayHelper::merge($data, ArrayHelper::map($query->all(), 'houseguid', 'housenum'));                

        // Места
        $query = FiasLandmark::find();
        $query->andWhere([
            'aoguid' => $parent->aoguid,
        ]);
        $query->orderBy('location');
        $data = ArrayHelper::merge($data, ArrayHelper::map($query->all(), 'landguid', 'location'));                

        echo $this->renderDropDownList($data, $id);
    }

    private function renderDropDownList($data, $value = null)
    {
        if (!count($data)) return;

        return Select2::widget([
            'id' => md5(Html::getInputId($this->model, $this->attribute).mt_rand(0, 999999999).mt_rand(0,999999999)),
            'name' => '',
            'value' => $value,
            'data' => array_merge([ 0 => '...'], $data),
            'language' => 'ru',
        ]);
    }

    private function renderChildren($id)
    {
        $data = [];

        if ($house = FiasHouse::findOne(['houseguid' => $id]))
        {
            $current = null;
            $parent = FiasAddrobj::findOne(['aoguid' => $house->aoguid]);
        }
        elseif($landmark = FiasLandmark::findOne(['landguid' => $id]))
        {
            $current = null;
            $parent = FiasAddrobj::findOne(['aoguid' => $landmark->aoguid]);
        }
        else
        {
            $current = FiasAddrobj::find()->andWhere(['aoguid' => $id, 'currstatus' => 0])->one();
            $parent = FiasAddrobj::find()->andWhere(['aoguid' => $current->parentguid, 'currstatus' => 0])->one();
        }

        if ($current)
        {
            // Улицы
            $query = FiasAddrobj::find();
            $query->andWhere([
                'parentguid' => $current->aoguid,
                'currstatus' => 0,
            ]);
            $query->orderBy('formalname');
            $data = ArrayHelper::merge($data, ArrayHelper::map($query->all(), 'aoguid', 'name'));

            // Дома
            $query = FiasHouse::find();
            $query->andWhere([
                'aoguid' => $current->aoguid,
            ]);
            $query->orderBy(new \yii\db\Expression('housenum + 0'));
            $data = ArrayHelper::merge($data, ArrayHelper::map($query->all(), 'houseguid', 'housenum'));                

            // Места
            $query = FiasLandmark::find();
            $query->andWhere([
                'aoguid' => $current->aoguid,
            ]);
            $query->orderBy('location');
            $data = ArrayHelper::merge($data, ArrayHelper::map($query->all(), 'landguid', 'location'));               

            echo $this->renderDropDownList($data); 
        }
    }
}
