<table class="table table-striped">
    <tr>
        <th>Наименование</th>
        <th>Потрачено</th>
    </tr>
    <?php if($costs) : ?>
        <?php foreach($costs as $cost) : ?>
            <tr>
                <td><?= $cost->name ?></td>
                <td><?= $cost->cost ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
