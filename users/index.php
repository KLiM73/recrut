<?
require '../app/index.php';
$title = "Пользователи и группы";
require '../template/header.php';
?>
<div class="content">
    <div class="usersList">
        <h3>Пользователи:</h3>
        <ul>
            <? foreach (dbDoTransaction("SELECT * FROM users") as $row) {
                //echo '<li>'.$row['id'].' <a href="./view.php?id='.$row['id'].'">'.$row['name'].'</a></li>';
                echo '<li>'.$row['id'].' '.$row['name'].' '.$row['userGroup'].'</li>';
            }
            ?>
        </ul>
        <?
        if ($_SESSION['group'] == 'Администратор') {
            ?>
            <form>
                <label>Добавление пользователя:</label>

                <label for="login">Логин:</label>
                <input id="login">
            </form>
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