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
            [['id', 'category', 'costs_default', 'cost', 'score', 'date'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'cost' => 'Сумма',
            'costs_default' => 'Название по умолчанию',
            'category' => 'Категория',
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

