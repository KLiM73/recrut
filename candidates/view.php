<?
require '../app/index.php';
$cand;
foreach (dbDoTransaction('select * from candidate where id = '.$_GET['id']) as $row) {
    $cand = $row;
}

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
        <span>Вакансии: <? echo $cand['vac_id']; ?></span><br>
        <span>Описание: <? echo $cand['description']; ?></span><br>
        <span>Резюме: <? echo $cand['resume']; ?></span><br>
        <span>Комментарий: <? echo $cand['comments']; ?></span>
    </div>

    <?
}
require '../template/footer.php';?>
