<?
require '../app/index.php';
$cand;
foreach (dbDoTransaction('select * from candidate where id = '.$_GET['id']) as $row) {
    $cand = $row;
}
unset($row);
$title = 'Кандидат '.$cand['fio'];
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <div>
        <span>ID: <? echo $cand['id']; ?></span><br>
        <span>ФИО: <? echo $cand['fio']; ?></span><br>
        <span>Дата рождения: <? echo $cand['b_date']; ?></span><br>
        <span>Вакансии:</span><br>
        <table>
            <tr>
                <td>ID</td>
                <td>Название</td>
                <td>Статус</td>
                <td>Дата</td>
            </tr>

            <?
            foreach (dbDoTransaction('select * from vacancyEvent where candidate_id = '.$cand['id']) as $row) {
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
        </table>
        <span>Описание: <? echo $cand['description']; ?></span><br>
        <span>Резюме: <? echo $cand['resume']; ?></span><br>
        <span>Комментарий: <? echo $cand['comments']; ?></span>
    </div>

    <?
}
require '../template/footer.php';?>
