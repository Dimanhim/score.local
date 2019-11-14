<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Categories extends ActiveRecord
{
    const COST = 0;
    const INCOME = 1;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            [['id', 'date', 'parent', 'source'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'date' => 'Дата создания',
            'parent' => 'Родительская категория',
            'source' => 'Источник',
        ];
    }
    public function getSubCats($id)
    {
        return self::find()->where(['parent' => $id])->all();
    }
    public function getCategoryName($id)
    {
        return self::findOne($id)->name;
    }
    public function getArraySource()
    {
        return [
            self::COST => 'Расходы',
            self::INCOME => 'Доходы',
        ];
    }
    public function getSource()
    {
        if($source == self::COST) return 'Расходы';
        if($source == self::INCOME) return 'Доходы';
        return false;
    }
}

