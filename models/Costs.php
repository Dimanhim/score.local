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
            [['id', 'category', 'category_child', 'costs_default', 'cost', 'score'], 'integer'],
            [['date'], 'safe'],
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
        $set = new Settings();
        $ids[0] = $id->id;

        foreach(Categories::getSubCats($cat) as $sub_cat) {
            $ids[] = $sub_cat->id;
        }
        foreach(self::find()->where(['category' => $ids])->andWhere(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', $set->endDate])->all() as $cost) {
            $price = $price + $cost->cost;
        }
        return $price;
    }
    public function getCosts() {
        $set = new Settings();
        $price = 0;
        foreach(self::find()->where(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', $set->endDate])->all() as $cost) {
            $price = $price + $cost->cost;
        }
        return $price;
    }
    public function getScore()
    {
        return $this->hasMany(Scores::className(), ['id' => 'score']);
    }
    public function getDateValue()
    {
        $date = date('d.m.Y', $this->date);
        return strtotime($date);
    }

}

