<?
require '../app/index.php';
$title = "Добавление кандидата";
require '../template/header.php';
$message = '';

if (isset($_POST['insertCandidate'])) {
    if (empty($_POST['fio'])) {
        $message = "Форма заполнена неверно!";
    } else {

        dbAddCandidate($_POST['fio'], $_POST['b_date'], $_POST['description'], $_POST['comments']);
        echo 'select * from candidate where fio = "' . $_POST['fio'] . '";';
        foreach (dbDoTransaction('select * from candidate where fio = "' . $_POST['fio'] . '";') as $row) {
            $id = $row['id'];
            break;
        }
        if (is_uploaded_file($_FILES['resume']['tmp_name'])) {
            $path = pathinfo($_FILES['resume']['tmp_name']);
            move_uploaded_file($_FILES['resume']['tmp_name'], '/home/klim/Projects/test/resume/' . $id);
        }
        header("Location: http://test/candidates");
    }
}

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="fio">ФИО</label></td>
                <td><input id="fio" name="fio" type="text"></td>
            </tr>
            <tr>
                <td><label for="b_date">Дата рождения</label></td>
                <td><input type="date" id="b_date" name="b_date"></td>
            </tr>
            <tr>
                <td><label for="description">Описание</label></td>
                <td><textarea name="description" id="description"></textarea></td>
            </tr>
            <tr>
                <td><label for="resume">Резюме</label></td>
                <td><input type="file" id="resume" name="resume"></td>
            </tr>
            <tr>
                <td><label for="comments">Комментарии</label></td>
                <td><textarea name="comments" id="comments"></textarea></td>
            </tr>
        </table>
        <span id="answer"><? echo $message; ?></span><br><br>
        <input type="submit" name="insertCandidate" value="Добавить">
    </form>
    <a href="index.php">К кандидатам</a>
    <?
}
require '../template/footer.php'; ?>