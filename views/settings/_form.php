<?php
use app\models\ContactForm;
use app\models\Categories;
use app\models\Scores;
use app\models\CostsDefault;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;
use \yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
?>
<h2>Показывать информацию</h2>
<?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]]]) ?>

<!--- Дата от -->
<?= $form->field($model, 'time_begin')->widget(DatePicker::className(), [
    'options' => [
        'value' => $model->time_begin ? date('d-m-Y', $model->time_begin) : date('d-m-Y'),
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-mm-yyyy',
        'todayHighlight' => true,
    ]
]);
?>
<!--- Дата до -->
<?= $form->field($model, 'time_end')->widget(DatePicker::className(), [
    'options' => [
        'value' => $model->time_end ? date('d-m-Y', $model->time_end) : date('d-m-Y'),
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-mm-yyyy',
        'todayHighlight' => true,
    ]
]);
?>

<?= Html::submitButton('Сохранить', ['class' => "btn btn-primary"]) ?>
<?php ActiveForm::end() ?>
