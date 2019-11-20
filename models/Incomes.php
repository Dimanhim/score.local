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
}


