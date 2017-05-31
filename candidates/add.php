<?
require '../app/index.php';
$title = "Добавление кандидата";
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <form action="../app/db.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="fio">ФИО</label></td>
                <td><input id="fio" name="fio" type="text"></td>
            </tr>
            <tr>
                <td><label for="b_date">Дата рождения</label></td>
                <td><input type="date" id="b_date" name="b_date"></td>
            </tr>
            <?/*<tr>
                <td><label for="vacancies">Вакансии</label></td>
                <td><select id="vacancies" name="vacancies[]" multiple>
                        <?
                        foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
                            echo "<option value=" . $row['id'] . ">" . $row['id'] . ", " . $row['name'] . "</option>";
                        }
                        ?>
                    </select></td>
            </tr>*/?>
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
        <input type="submit" name="insertCandidate" value="Добавить">
    </form>
    <?
}
require '../template/footer.php'; ?>