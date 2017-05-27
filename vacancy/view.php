<?
require '../app/db.php';
$vac;
foreach (dbDoTransaction('select * from vacancy where id = '.$_GET['id']) as $row) {
    $vac = $row;
}

$title = 'Вакансия '.$vac['name'];
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
    ?>

    <div>
        <span>ID: <? echo $vac['id']; ?></span><br>
        <span>Название: <? echo $vac['name']; ?></span><br>
        <span>Описание: <? echo $vac['description']; ?></span><br>
        <span>Инициатор: <? echo $vac['iniciator']; ?></span><br>
        <span>Исполнитель: <? echo $vac['doer']; ?></span><br>
    </div>

    <?
}
require '../template/footer.php';?>
