<?
require '../app/index.php';

foreach (dbDoTransaction('select * from users where id = '.$_GET['id']) as $row) {
    $user = $row;
    break;
}

$title = "Изменение пользователя ".$user['fio'];
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>
    <form method="post" action="../app/db.php">
        <input type="hidden" name="id" value="<? echo $user['id']; ?>">

        <label for="login">Логин:</label><br>
        <input id="login" name="login" value="<? echo $user['login']; ?>"><br>

        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password" value="<? echo $user['password']; ?>"><br>

        <label for="fio">ФИО:</label><br>
        <input id="fio" name="fio" value="<? echo $user['fio']; ?>"><br>

        <label for="userGroup">Группа пользователя:</label><br>
        <select id="userGroup" name="userGroup">
            <?
            foreach ($GLOBALS['userGroups'] as $group) {
                if ($group == $user['userGroup']) {
                    echo '<option value="'.$group.'" selected>'.$group.'</option>';
                } else {
                    echo '<option value="' . $group . '">' . $group . '</option>';
                }
            }
            ?>
        </select><br>

        <input type="submit" name="userEdit" value="Сохранить">
    </form>
    <?
}
require '../template/footer.php'; ?>
