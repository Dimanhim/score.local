<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Счета';
if($score->is_check == 1) $text = ['checked' => true];
?>
<div class="col-md-6 col-md-offset-3" style="height: 40px; margin-top: 10px">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
    <p class="bg-info" style="padding: 10px; border-radius: 5px"><?php echo Yii::$app->session->getFlash('success'); ?></p>
    <?php endif;?>
</div>

<div class="col-md-6 col-md-offset-3">
    <?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]]]) ?>
    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'summa')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'id_default')->checkbox() ?>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'is_check')->checkbox($text) ?>
    <?= Html::submitButton('Создать', ['class' => "btn btn-primary"]) ?>
    <?php ActiveForm::end() ?>
</div>

