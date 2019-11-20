<?php

/* @var $this yii\web\View */

use app\models\Categories;
use app\models\Scores;
use app\models\Costs;

$this->title = 'Главная';
?>
<?php


?>
<table class="table">
    <tr>
        <td>Всего доступных средств</td>
        <td><b><?= Scores::getAccessMoney() ?></b></td>
    </tr>
    <?php foreach($scores as $score) { ?>
        <?php if($score->is_check == 1) { ?>
    <tr>
        <td><?= $score->name ?></td>
        <td><?= $score->summa ?> руб.</td>
    </tr>
        <?php } ?>
    <?php } ?>
</table>
<h2>Расходы по категориям с 20.10.2019 - 18.11.2019</h2>
<table class="table">
    <?php foreach($cats as $m) { ?>
        <?php if($m->parent == 0) { ?>
            <tr>
                <td>
                    <?php
                    if($m->source == Categories::INCOME) echo "<b>".$m->name."</b>";
                    else echo $m->name;
                    ?>
                </td>
                <td>
                    <ul>
                        <?php foreach(Categories::getSubCats($m->id) as $v) { ?>
                            <li><a href="<?= Yii::$app->urlManager->createUrl(['cats/view', 'id' => $v->id]) ?>"><?= $v->name ?> (<?= Costs::getCatCosts($v->id) ?> руб.)</a></li>
                        <?php } ?>
                    </ul>
                </td>
                <td>
                    <?= Costs::getCatCosts($m->id) ?> руб.
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
</table>

