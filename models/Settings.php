<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Settings extends ActiveRecord
{
    public function rules()
    {
        return [
            [['id', 'time_begin', 'time_end'], 'safe'],
        ];
    }
    public function attributes()
    {
        return [
            'id',
            'time_begin',
            'time_end',
        ];
    }
    public function attributeLabels()
    {
        return [
            'time_begin' => 'С даты',
            'time_end' => 'До даты',
        ];
    }
    public function getBeginDate()
    {
        return self::find()->one()->time_begin;
    }
    public function getEndDate()
    {
        return self::find()->one()->time_end;
    }

}


