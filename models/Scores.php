<?php

namespace app\models;
use Yii;
use app\models\Save;
use app\models\Payments;
use yii\db\ActiveRecord;

class Scores extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            [['id', 'is_check', 'id_default', 'summa'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'id_default' => 'По умолчанию',
            'is_check' => 'Учитывать при подсчете',
            'summa' => 'Сумма',
        ];
    }
    public function getScoreName($id)
    {
        return self::findOne($id)->name;
    }
    public function changeScore($cost, $id)
    {
        $model = self::findOne($id);
        $summa = $model->summa + $cost;
        $model->summa = $summa;
        if($model->save()) return true;
        return false;
    }
    public function getAccessMoney()
    {
        $summa = 0;
        $scores = self::find()->all();
        foreach($scores as $score) {
            if($score->is_check ==1) {
                $summa = $summa + $score->summa;
            }
        }
        $summa = Scores::getActualMoney($summa);
        return $summa;
    }
    public function getActualMoney($summa)
    {
        $count = 0;
        foreach(Save::find()->all() as $v) {
            $count += $v->summa;
        }
        foreach(Payments::find()->all() as $v) {
            $count += $v->summa;
        }
        return $summa - $count;
    }
}
