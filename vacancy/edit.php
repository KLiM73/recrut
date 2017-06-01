<?
require '../app/index.php';

foreach (dbDoTransaction('select * from vacancy where id = '.$_GET['id']) as $row) {
    $vacancy = $row;
    break;
}
$title = "Изменение вакансии ".$vacancy['name'];
require '../template/header.php';

$message = '';
if (isset($_POST['updateVacancy'])){
    if (empty($_POST['name'])) {
        $message = 'Неверно заполнена форма!';
    } else {
        dbUpdateVacancy($_POST['id'], $_POST['name'], $_POST['description'], $_POST['iniciator'], $_POST['doer']);
    }
}


if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <form action="" method="post">
        <input type="hidden"  name="id" value="<? echo $_GET['id']; ?>">

        <table>
            <tr>
                <td><label for="name">Название</label></td>
                <td><input id="name" name="name" type="text" value="<? echo $vacancy['name']; ?>"></td>
            </tr>
            <tr>
                <td><label for="description">Описание</label></td>
                <td><textarea id="description" name="description"><? echo $vacancy['description']; ?></textarea></td>
            </tr>
            <tr>
                <td><label for="iniciator">Инициатор</label></td>
                <td><select id="iniciator" name="iniciator">
                        <?
                        foreach (dbDoTransaction('select * from users') as $user) {
                            if ($vacancy['iniciator'] == $user['id']) {
                                echo '<option value="'.$user['id'].'" selected>'.$user['fio'].'</option>';
                            } else {
                                echo '<option value="' . $user['id'] . '">' . $user['fio'] . '</option>';
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="doer">Исполнитель</label></td>
                <td><select id="doer" name="doer">
                        <?
                        foreach (dbDoTransaction('select * from users') as $user) {
                            if ($vacancy['doer'] == $user['id']) {
                                echo '<option value="'.$user['id'].'" selected>'.$user['fio'].'</option>';
                            } else {
                                echo '<option value="' . $user['id'] . '">' . $user['fio'] . '</option>';
                            }
                        }
                        ?>
                    </select></td>
            </tr>
        </table>
        <span id="answer"><? echo $message; ?></span><br><br>
        <input type="submit" name="updateVacancy" value="Сохранить">
    </form>
    <a href="index.php">К вакансиям</a>
    <?
}
require '../template/footer.php'; ?>