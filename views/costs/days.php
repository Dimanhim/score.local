<table class="table table-striped">
    <tr>
        <th>Дата</th>
        <th>Потрачено</th>
    </tr>
    <?php if($results) : ?>
        <?php foreach($results as $k => $v) : ?>
            <tr>
                <td><?= date('d.m.Y', $k) ?></td>
                <td><a href="<?= Yii::$app->urlManager->createUrl(['costs/each-day', 'date' => $k]) ?>"><?= $v ?></a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
