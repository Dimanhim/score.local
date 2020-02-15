<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Incomes extends ActiveRecord
{
    public function rules()
    {
        return [
            [['income'], 'required'],
            [['name'], 'string'],
            [['id', 'category', 'income_default', 'score', 'date'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'income' => 'Сумма',
            'income_default' => 'Название по умолчанию',
            'category' => 'Категория',
            'score' => 'Добавить на счет',
            'date' => 'Дата',
        ];
    }
    public function getCatCosts($cat) {
        $price = 0;
        $ids = [];
        $id = Categories::findOne($cat);
        $set = new Settings();
        $ids[0] = $id->id;

        foreach(Categories::getSubCats($cat) as $sub_cat) {
            $ids[] = $sub_cat->id;
        }
        foreach(self::find()->where(['category' => $ids])->andWhere(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', $set->endDate])->all() as $cost) {
            $price = $price + $cost->income;
        }
        return $price;
    }
    public function getIncomes() {
        $set = new Settings();
        $price = 0;
        foreach(self::find()->where(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', $set->endDate])->all() as $cost) {
            $price = $price + $cost->income;
        }
        return $price;
    }
}


