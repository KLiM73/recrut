<?
require '../app/index.php';

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

    <form action="../app/db.php" method="post">

    <input type="hidden" name="id" value="<? echo $_GET['id']; ?>">

    <label for="fio">ФИО</label><br>
    <input id="fio" name="fio" type="text" value="<? echo $candidate['fio']; ?>"><br>

    <label for="b_date">Дата рождения</label><br>
    <input type="date" id="b_date" name="b_date" value="<? echo $candidate['b_date']; ?>"><br>

    <label for="vacancies">Вакансии</label><br>
        <table>
            <tr>
                <td>ID, Название</td>
                <td>Статус</td>
                <td>Дата</td>
            </tr>
            <? foreach (dbDoTransaction('select * from vacancyEvent where candidate_id = '.$candidate['id']) as $item) { ?>
                <tr>
                    <td><select>
                            <? foreach (dbDoTransaction('select * from vacancy') as $row) {
                                if ($item['vacancy_id'] == $row['id']) { ?>
                            <option value="<? echo $row['id']; ?>" selected><? echo $row['id'].', '. $row['name']; ?></option><? } else { ?>
                                    <option value="<? echo $row['id']; ?>"><? echo $row['id'].', '. $row['name']; ?> <? } } ?>
                        </select></td>
                    <td><select>
                            <? foreach ($GLOBALS['candidateStatuses'] as $candidateStatus) {
                                if ($item['status'] == $candidateStatus) { ?>
                                <option value="<? echo $candidateStatus; ?>" selected><? echo $candidateStatus; ?></option> <? } else {?>
                                    <option value="<? echo $candidateStatus; ?>"><? echo $candidateStatus; ?></option><? } ?>
                            <?}?>
                        </select></td>
                    <td><input type="date" value="<? echo $item['date']; ?>"></td>
                    <td><input type="button" value="Удалить"></td>
                </tr>
        <? } ?>

        </table>
        <input type="button" value="Добавить"><br>


    <? /*<select id="vacancies" name="vacancies[]" multiple>
    <?
    $arVac = explode(' ', $candidate['vac_id']);
    foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
        $sel = false;
        foreach ($arVac as $vac) {
            if ($vac == $row['id']) {
                $sel = true;
            }
        }
        if ($sel) {
            echo "<option value=" . $row['id'] . " selected>" . $row['id'] . ", " . $row['name'] . "</option>";
        } else {
            echo "<option value=" . $row['id'] . ">" . $row['id'] . ", " . $row['name'] . "</option>";
        }
    }
            ?>
    </select><br> */?>

        <label for="description">Описание</label><br>
        <textarea name="description" id="description"><? echo $candidate['description']; ?></textarea><br>

        <label for="resume">Резюме</label><br>
        <input type="file" id="resume" name="resume"><br>

        <label for="comments">Комментарии</label><br>
        <textarea name="comments" id="comments"><? echo $candidate['comments']; ?></textarea><br>

        <input type="submit" name="updateCandidate" value="Сохранить">
    </form>
    <?
}
require '../template/footer.php'; ?>