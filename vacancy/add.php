<?
require '../app/index.php';
$title = "Добавление вакансии";
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <form action="../app/db.php" method="post">
        <table>
            <tr>
                <td><label for="name">Название</label></td>
                <td><input id="name" name="name" type="text"></td>
            </tr>
            <tr>
                <td><label for="description">Описание</label></td>
                <td><textarea id="description" name="description"></textarea></td>
            </tr>
            <tr>
                <td><label for="iniciator">Инициатор</label></td>
                <td><select id="iniciator" name="iniciator">
                        <?
                        foreach (dbDoTransaction('select * from users') as $user) {
                            echo '<option value="'.$user['id'].'">'.$user['fio'].'</option>';
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="doer">Исполнитель</label></td>
                <td><select id="doer" name="doer">
                        <?
                        foreach (dbDoTransaction('select * from users') as $user) {
                            echo '<option value="'.$user['id'].'">'.$user['fio'].'</option>';
                        }
                        ?>
                    </select></td>
            </tr>
        </table>
        <input type="submit" name="insertVacancy" value="Добавить">
    </form>
    <?
}
require '../template/footer.php'; ?>