<?

require '../app/index.php';
$title = "Вакансии";
require '../template/header.php';
if (($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){

    if (isset($_GET['do']) == 'delete') {
        dbDeleteVacancy($_GET['id']);
    }
    ?>

    <div class="content">
        <div class="vacancyList">
            <h3>Вакансии:</h3>
            <table>
                <tr>
                    <td>ID</td>
                    <td>Название</td>
                    <td>Инициатор:</td>
                    <td>Исполнитель:</td>
                </tr>
                <? foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
                    echo '<tr>
                            <td>'.$row['id'].'</td>
                            <td><a href="view.php?id='.$row['id'].'">'.$row['name'].'</a></td>';

                    foreach (dbDoTransaction('select * from users') as $user) {
                        if ($user['id'] == $row['iniciator']) {
                            echo '<td>'.$user['fio'].'</td>';
                        }
                    }
                    unset($user);
                    foreach (dbDoTransaction('select * from users') as $user) {
                        if ($user['id'] == $row['doer']) {
                            echo '
                            <td>'.$user['fio'].'</td>
                            <td><a href="edit.php?id='.$row['id'].'">Изменить</a></td>
                            <td><a href="?do=delete&id='.$row['id'].'">Удалить</a></td>
                             </tr>';
                        }
                    }

                }
                ?>
            </table>
        </div>
        <a href="add.php">Добавить>></a>
    </div>
    <?

} else {
    echo 'У вас нет доступа к этому разделу!';
}
require '../template/footer.php'; ?>