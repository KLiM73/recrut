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
    <table>
        <tr>
            <td>ID</td>
            <td><? echo $vac['id']; ?></td>
        </tr>
        <tr>
            <td>Название</td>
            <td><? echo $vac['name']; ?></td>
        </tr>
        <tr>
            <td>Описание</td>
            <td><? echo $vac['description']; ?></td>
        </tr>
        <tr>
            <td>Инициатор</td>
            <td><? foreach (dbDoTransaction('select fio from users where id = '.$vac['iniciator']) as $row) { echo $row['fio']; } ?></td>
        </tr>
        <tr>
            <td>Исполнитель</td>
            <td><? foreach (dbDoTransaction('select fio from users where id = '.$vac['doer']) as $row) { echo $row['fio']; } ?></td>
        </tr>
    </table>
    <a href="edit.php?id=<? echo $_GET['id']; ?>">Изменить</a>
    <?
}
require '../template/footer.php';?>
