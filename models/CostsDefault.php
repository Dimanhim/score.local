<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class CostsDefault extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['id', 'category'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'category' => 'Категория',
        ];
    }
}


