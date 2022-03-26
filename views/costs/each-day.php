<table class="table table-striped">
    <tr>
        <th>Наименование</th>
        <th>Потрачено</th>
        <th>Отображение по дням</th>
        <th>Редактировать</th>
    </tr>
    <?php if($costs) : ?>
        <?php foreach($costs as $cost) : ?>
            <tr>
                <td><?= $cost->name ?></td>
                <td>
                    <?= $cost->cost ?>
                </td>
                <td>
                    <?= $cost->check_for_days ? 'Да' : 'Нет' ?>
                </td>
                <td>
                    <a href="<?= Yii::$app->urlManager->createUrl(['costs/update', 'id' => $cost->id]) ?>">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
