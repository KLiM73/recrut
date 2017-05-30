<?
require '../app/index.php';
$title = "Добавление вакансии";
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <form action="../app/db.php" method="post">
        <label for="name">Название</label>
        <input id="name" name="name" type="text"><br>

        <label for="description">Описание</label>
        <textarea id="description" name="description"></textarea><br>

        <label for="iniciator">Инициатор</label>
        <select id="iniciator" name="iniciator">
            <?
            foreach (dbDoTransaction('select * from users') as $user) {
                echo '<option value="'.$user['id'].'">'.$user['fio'].'</option>';
            }
            ?>
        </select><br>

        <label for="doer">Исполнитель</label>
        <select id="doer" name="doer">
            <?
            foreach (dbDoTransaction('select * from users') as $user) {
                echo '<option value="'.$user['id'].'">'.$user['fio'].'</option>';
            }
            ?>
        </select><br>

        <input type="submit" name="insertVacancy" value="Добавить">
    </form>
    <?
}
require '../template/footer.php'; ?>