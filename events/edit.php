<?
require '../app/index.php';

foreach (dbDoTransaction('select * from vacancyEvent where id = '.$_GET['id']) as $row) {
    $event = $row;
    break;
}
unset($row);
$title = "Изменение собития №".$event['id'];
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <form action="../app/db.php" method="post">
        <input type="hidden" name="id" value="<? echo $_GET['id']; ?>">

        <table>
            <tr>
                <td><label for="date">Дата события</label></td>
                <td><input type="date" id="date" name="date" value="<? echo $event['date']; ?>"></td>
            </tr>
            <tr>
                <td><label for="vacancy_id">Вакансия</label></td>
                <td><select id="vacancy_id" name="vacancy_id">
                        <?
                        foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
                            if ($row['id'] == $event['vacancy_id']) { ?>
                                <option value="<? echo $row['id']; ?>" selected><? echo $row['id'].', '.$row['name']; ?></option>
                            <? } else { ?>
                                <option value="<? echo $row['id']; ?>"><? echo $row['id'].', '.$row['name']; ?></option>
                            <? } } unset($row);?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="candidate_id">Кандидат</label></td>
                <td><select id="candidate_id" name="candidate_id">
                        <?
                        foreach (dbDoTransaction("SELECT * FROM candidate") as $row) {
                            if ($row['id'] == $event['candidate_id']) { ?>
                                <option value="<? echo $row['id']; ?>" selected><? echo $row['id'].', '.$row['fio']; ?></option>
                            <? } else { ?>
                                <option value="<? echo $row['id']; ?>"><? echo $row['id'].', '.$row['fio']; ?></option>
                            <? } } unset($row); ?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="status">Статус</label></td>
                <td><select id="status" name="status">
                        <?
                        foreach ($GLOBALS['candidateStatuses'] as $row) {
                            if ($row == $event['status']) {?>
                                <option value="<? echo $row; ?>" selected><? echo $row; ?></option>
                            <? } else {?>
                                <option value="<? echo $row; ?>"><? echo $row; ?></option>
                            <? } }?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="comments">Комментарии</label></td>
                <td><textarea name="comments" id="comments"><? echo $event['comments']; ?></textarea></td>
            </tr>
        </table>

        <input type="submit" name="updateVacancyEvent" value="Сохранить">
    </form>
    <?
}
require '../template/footer.php'; ?>