<?
require '../app/index.php';
$title = "События";
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    if (isset($_GET['do']) == 'delete') {
        dbDeleteVacancyEvent($_GET['id']);
    }

    ?>

    <div class="content">
        <div class="candidateList">
            <h3>События:</h3>
            <table>
                <tr>
                    <td>ID</td>
                    <td>Дата</td>
                    <td>Вакансия</td>
                    <td>Кандидат</td>
                    <td>Статус</td>
                </tr>
                <?
                foreach (dbDoTransaction("SELECT * FROM vacancyEvent") as $row) {
                    ?>
                    <tr>
                        <td><a href="./view.php?id=<? echo $row['id']; ?>"><? echo $row['id']; ?></a></td>
                        <td><? echo $row['date']; ?></td>

                        <? foreach (dbDoTransaction('select * from vacancy where id = '.$row['vacancy_id']) as $vac) {?>
                        <td><a href="../vacancy/view.php?id=<? echo $vac['id']; ?>"><? echo $vac['name']; }?></a></td>

                        <? foreach (dbDoTransaction('select * from candidate where id = '.$row['candidate_id']) as $can) {?>
                        <td><a href="../candidates/view.php?id=<? echo $can['id']; ?>"><? echo $can['fio']; }?></a></td>
                        <td><? echo $row['status']; ?></td>
                        <td><a href="edit.php?id=<? echo $row['id']; ?>">Изменить</a></td>
                        <td><a href="?do=delete&id=<? echo $row['id']; ?>">Удалить</a></td>
                    </tr>
                    <? } ?>
            </table>
        </div>
        <a href="add.php">Добавить>></a>
    </div>
    <?
}
require '../template/footer.php'; ?>