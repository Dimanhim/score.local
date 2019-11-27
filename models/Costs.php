<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Costs extends ActiveRecord
{
    public function rules()
    {
        return [
            [['cost', 'score'], 'required'],
            [['name'], 'string'],
            [['id', 'category', 'category_child', 'costs_default', 'cost', 'score', 'date'], 'integer'],
        ];
    }
    public function attributes()
    {
        return [
            'id',
            'name',
            'cost',
            'costs_default',
            'category',
            'category_child',
            'score',
            'date',
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'cost' => 'Сумма',
            'costs_default' => 'Название по умолчанию',
            'category' => 'Категория',
            'category_child' => 'Подкатегория',
            'score' => 'Списать со счета',
            'date' => 'Дата',
        ];
    }
    public function getCatCosts($cat) {
        $price = 0;
        $ids = [];
        $id = Categories::findOne($cat);
        $ids[0] = $id->id;

        foreach(Categories::getSubCats($cat) as $sub_cat) {
            $ids[] = $sub_cat->id;
        }
        foreach(self::find()->where(['category' => $ids])->all() as $cost) {
            $price = $price + $cost->cost;
        }
        return $price;
    }

}

