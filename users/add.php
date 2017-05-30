<?
require '../app/index.php';
$title = "Добавление пользователя";
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <form method="post" action="../app/db.php">
        <label>Добавление пользователя:</label><br>

        <label for="login">Логин:</label><br>
        <input id="login" name="login"><br>

        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="fio">ФИО:</label><br>
        <input id="fio" name="fio"><br>

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
require '../template/footer.php'; ?>