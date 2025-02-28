$_db = new PDO('mysql:dbname=db5', 'root', '', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);

select statement
$stm = $_db->prepare('SELECT * FROM student WHERE name LIKE ?');
$stm->execute(["%$name%"]);
$arr= $stm->fetchAll();

<table>
<?php foreach ($arr as $s): ?>
    <tr>
        <td><?= $s->id ?></td>
        <td><?= $s->name ?></td>
        <td><?= $s->gender ?></td>
        <td><?= $s->program_id ?></td>
    </tr>
    <?php endforeach ?>
</table>
