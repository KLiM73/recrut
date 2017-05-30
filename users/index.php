<?
require '../app/index.php';
$title = "Пользователи и группы";
require '../template/header.php';

if (isset($_GET['do']) == 'delete') {
    userDelete($_GET['id']);
}
?>
<div class="content">
    <div class="usersList">
        <h3>Пользователи:</h3>
        <table>
            <tr>
                <td>ID</td>
                <td>Логин</td>
                <td>ФИО</td>
                <td>Группа</td>
            </tr>
            <?
            foreach (dbDoTransaction("SELECT * FROM users") as $row) {
                echo '
                <tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['login'].'</a></td>
                    <td>'.$row['fio'].'</td>
                    <td>'.$row['userGroup'].'</td>';
                if ($_SESSION['group'] == 'Администратор') {
                echo '<td><a href="edit.php?id='.$row['id'].'">Изменить</a></td>
                    <td><a href="?do=delete&id='.$row['id'].'">Удалить</a></td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
        <?
        if ($_SESSION['group'] == 'Администратор') {
            ?>
            <a href="add.php">Добавить</a>
            <?
        }
        ?>
        <h3>Группы пользователей:</h3>
        <ul>
            <?
            foreach ($GLOBALS['userGroups'] as $userGroup) {
                echo '<li>'.$userGroup.'</li>';
            }
            ?>
        </ul>
    </div>
</div>
<? require '../template/footer.php'; ?>