<?
require '../app/index.php';
$title = "Кандидаты";
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <div class="content">
        <div class="candidateList">
            <h3>Кандидаты:</h3>
            <ul>
                <? foreach (dbDoTransaction("SELECT * FROM candidate") as $row) {
                    echo '<li>' . $row['id'] . ' <a href="./view.php?id=' . $row['id'] . '">' . $row['fio'] . '</a> ' . $row['b_date'] . ' ' . $row['description'] . '</li>';
                }
                ?>
            </ul>
        </div>
        <a href="add.php">Добавить>></a>
        <a href="edit.php">Изменить>></a>
        <a href="delete.php">Удалить>></a>
        <a href="view.php">просмотр>></a>
    </div>
    <?
}
require '../template/footer.php'; ?>