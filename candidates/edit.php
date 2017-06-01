<?
require '../app/index.php';
$message = '';
if (isset($_POST['updateCandidate'])) {
    if (empty($_POST['fio'])) {
        $message = "Форма заполнена неверно!";
    } else {

        dbUpdateCandidate($_POST['id'], $_POST['fio'], $_POST['b_date'], $_POST['description'], $_POST['id'], $_POST['comments']);
        if (is_uploaded_file($_FILES['resume']['tmp_name'])) {
            move_uploaded_file($_FILES['resume']['tmp_name'], '/home/klim/Projects/test/resume/' . $_POST['id']);
        }
        echo $_FILES['resume']['name'];
        header("Location: http://test/candidates");
    }
}

foreach (dbDoTransaction('select * from candidate where id = '.$_GET['id']) as $row) {
    $candidate = $row;
    break;
}
unset($row);
$title = "Изменение кандидата ".$candidate['fio'];
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<? echo $_GET['id']; ?>">

        <table>
            <tr>
                <td><label for="fio">ФИО</label></td>
                <td><input id="fio" name="fio" type="text" value="<? echo $candidate['fio']; ?>"></td>
            </tr>
            <tr>
                <td><label for="b_date">Дата рождения</label></td>
                <td><input type="date" id="b_date" name="b_date" value="<? echo $candidate['b_date']; ?>"></td>
            </tr>
            <tr>
                <td><label>Вакансии (изменение возможно через раздел "События"!)</label></td>
                <td><table>
                        <tr>
                            <td>ID</td>
                            <td>Название</td>
                            <td>Статус</td>
                            <td>Дата</td>
                        </tr>

                        <?
                        foreach (dbDoTransaction('select * from vacancyEvent where candidate_id = '.$candidate['id']) as $row) {
                            ?>
                            <tr>
                                <td><? echo $row['vacancy_id']; ?></td>
                                <td><? foreach (dbDoTransaction('select * from vacancy where id = '.$row['vacancy_id']) as $vac) { echo $vac['name']; } ?></td>
                                <td><? echo $row['status']; ?></td>
                                <td><? echo $row['date']; ?></td>
                            </tr>
                            <?
                        }
                        ?>
                    </table></td>
            </tr>
            <tr>
                <td><label for="description">Описание</label></td>
                <td><textarea name="description" id="description"><? echo $candidate['description']; ?></textarea></td>
            </tr>
            <tr>
                <td><label for="resume">Резюме</label></td>
                <td><input type="file" id="resume" name="resume"></td>
            </tr>
            <tr>
                <td><label for="comments">Комментарии</label></td>
                <td><textarea name="comments" id="comments"><? echo $candidate['comments']; ?></textarea></td>
            </tr>
        </table>
        <span id="answer"><? echo $message; ?></span><br><br>
        <input type="submit" name="updateCandidate" value="Сохранить">
    </form>
    <a href="index.php">К кандидатам</a>
    <?
}
require '../template/footer.php'; ?>