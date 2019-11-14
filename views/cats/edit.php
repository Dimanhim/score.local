<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\Categories;
use app\models\ContactForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'Категория';
?>
<div class="col-md-6 col-md-offset-3" style="height: 40px; margin-top: 10px">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <p class="bg-info" style="padding: 10px; border-radius: 5px"><?php echo Yii::$app->session->getFlash('success'); ?></p>
    <?php endif;?>
</div>

<div class="col-md-6 col-md-offset-3">
    <?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]]]) ?>
    <?= $form->field($model, 'name')->textInput(['value' => $category->name]) ?>
    <?= $form->field($model, 'description')->textInput(['value' => $category->description]) ?>
    <?php
    $items = [];
    foreach(Categories::find()->all() as $cat) {
        $items[$cat->id] = $cat->name;
    }
    $params = [
        'options' =>[
            $cat->parent => ['Selected' => true]
        ],
        'prompt' => 'Выбрать...'];
    ?>
    <?= $form->field($model, 'parent')->dropdownList($items, $params) ?>

    <?php
    $items = [];
    foreach($model->arraySource as $k => $v) {
        $items[$k] = $v;
    }
    $params = [
        'options' =>[
            $cat->source => ['Selected' => true]
        ],
        'prompt' => 'Выбрать...'];
    ?>
    <?= $form->field($model, 'source')->dropdownList($items, $params) ?>

    <?= Html::submitButton('Сохранить', ['class' => "btn btn-primary"]) ?>
    <br />
    <?= Html::a('Вернуться к списку категорий', Yii::$app->urlManager->createUrl(['cats/index']), ['class' => "btn btn-default", 'style' => 'margin-top: 10px']) ?>
    <?php ActiveForm::end() ?>
</div>



