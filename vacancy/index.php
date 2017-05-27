<?

require '../app/index.php';
$title = "Вакансии";
require '../template/header.php';
if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {

    ?>

    <div class="content">
        <div class="vacancyList">
            <h3>Вакансии:</h3>
            <ul>
                <? foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
                    echo '<li>' . $row['id'] . ' <a href="./view.php?id=' . $row['id'] . '">' . $row['name'] . '</a> ' . $row['iniciator'] . "</li>";
                }
                ?>
            </ul>
        </div>
        <a href="add.php">Добавить>></a>
        <a href="edit.php">Изменить>></a>
        <a href="delete.php">Удалить>></a>
    </div>
    <?
}
require '../template/footer.php'; ?>