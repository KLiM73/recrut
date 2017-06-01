<?
require '../app/index.php';
$cand;
foreach (dbDoTransaction('select * from vacancyEvent where id = '.$_GET['id']) as $row) {
    $event = $row;
}
unset($row);
$title = 'Просмотр события №'.$event['id'];
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>
        <table>
            <tr>
                <td>ID</td>
                <td><? echo $event['id']; ?></td>
            </tr>
            <tr>
                <td>Дата</td>
                <td><? echo $event['date']; ?></td>
            </tr>
            <tr>
                <td>Вакансия</td>
                <td><? foreach(dbDoTransaction('select name from vacancy where id = '.$event['vacancy_id']) as $vac) { echo $vac['name']; } ?></td>
            </tr>
            <tr>
                <td>Кандидат</td>
                <td><? foreach(dbDoTransaction('select fio from candidate where id = '.$event['candidate_id']) as $can) { echo $can['fio']; } ?></td>
            </tr>
            <tr>
                <td>Статус</td>
                <td><? echo $event['status']; ?></td>
            </tr>
            <tr>
                <td>Комментарии</td>
                <td><? echo $event['comments']; ?></td>
            </tr>
        </table>
    <a href="edit.php?id=<? echo $_GET['id']; ?>">Изменить</a>
    <a href="index.php">К событиям</a>
    <?
}
require '../template/footer.php';?>
