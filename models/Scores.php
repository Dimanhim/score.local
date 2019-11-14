<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Scores extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            [['id', 'id_default', 'summa'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'id_default' => 'По умолчанию',
            'summa' => 'Сумма',
        ];
    }
    public function getScoreName($id)
    {
        return self::findOne($id)->name;
    }
}
