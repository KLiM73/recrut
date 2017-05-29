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
            <form method="post" action="../app/db.php">
                <label>Добавление пользователя:</label><br>

                <label for="name">Логин:</label><br>
                <input id="name" name="name"><br>

                <label for="password">Пароль:</label><br>
                <input id="password" name="password"><br>

                <label for="userGroup">Группа пользователя:</label><br>
                <select id="userGroup" name="userGroup">
                    <?
                    foreach ($GLOBALS['userGroups'] as $group) {
                        echo '<option value="'.$group.'">'.$group.'</option>';
                    }
                    ?>
                </select><br>

                <input type="submit" name="userAdd" value="Добавить">
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