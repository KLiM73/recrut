<?
require '../app/index.php';
$title = "Кандидаты";
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    if (isset($_GET['do']) == 'delete') {
        dbDeleteCandidate($_GET['id']);
    }

    ?>

    <div class="content">
        <div class="candidateList">
            <h3>Кандидаты:</h3>
            <table>
                <tr>
                    <td>ID</td>
                    <td>ФИО</td>
                    <td>Дата рождения</td>
                    <td>Описание</td>
                </tr>
                <?
                foreach (dbDoTransaction("SELECT * FROM candidate") as $row) {
                    echo '
                    <tr>
                        <td>'.$row['id'].'</td>
                        <td><a href="./view.php?id=' . $row['id'] . '">'.$row['fio'].'</a></td>
                        <td>'.$row['b_date'].'</td>
                        <td>'.$row['description'].'</td>
                        <td><a href="edit.php?id='.$row['id'].'">Изменить</a></td>
                        <td><a href="?do=delete&id='.$row['id'].'">Удалить</a></td>
                    </tr>';
                }
                ?>
            </table>
        </div>
        <a href="add.php">Добавить>></a>
    </div>
    <?
}
require '../template/footer.php'; ?>