<?
require '../app/index.php';
$title = "Добавление события";
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <form action="../app/db.php" method="post">
        <table>
            <tr>
                <td><label for="date">Дата события</label></td>
                <td><input type="date" id="date" name="date" value="<? echo date('Y-m-d'); ?>"></td>
            </tr>
            <tr>
                <td><label for="vacancy_id">Вакансия</label></td>
                <td><select id="vacancy_id" name="vacancy_id">
                        <?
                        foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
                            echo "<option value=" . $row['id'] . ">" . $row['id'] . ", " . $row['name'] . "</option>";
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="candidate_id">Кандидат</label></td>
                <td><select id="candidate_id" name="candidate_id">
                        <?
                        foreach (dbDoTransaction("SELECT * FROM candidate") as $row) {
                            echo "<option value=" . $row['id'] . ">" . $row['id'] . ", " . $row['fio'] . "</option>";
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="status">Статус</label></td>
                <td><select id="status" name="status">
                        <?
                        foreach ($GLOBALS['candidateStatuses'] as $row) { ?>
                            <option value="<? echo $row; ?>"><? echo $row; ?></option>
                        <? } ?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="comments">Комментарии</label></td>
                <td><textarea name="comments" id="comments"></textarea></td>
            </tr>
        </table>

        <input type="submit" name="insertVacancyEvent" value="Добавить">
    </form>
    <a href="index.php">К событиям</a>
    <?
}
require '../template/footer.php'; ?>