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
    <table>
        <tr>
            <td>ID</td>
            <td><? echo $cand['id']; ?></td>
        </tr>
        <tr>
            <td>ФИО</td>
            <td><? echo $cand['fio']; ?></td>
        </tr>
        <tr>
            <td>Дата рождения</td>
            <td><? echo $cand['b_date']; ?></td>
        </tr>
        <tr>
            <td>Вакансии</td>
            <td><table>
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
                </table></td>
        </tr>
        <tr>
            <td>Описание</td>
            <td><? echo $cand['description']; ?></td>
        </tr>
        <tr>
            <td>Резюме</td>
            <td><? if(file_exists('../resume/'.$_GET['id'])) { ?>
            <a href="../resume/<? echo $_GET['id']; ?>">Открыть</a><? } else { echo 'Файл не загружен'; }?></td>
        </tr>
        <tr>
            <td>Комментарии</td>
            <td><? echo $cand['comments']; ?></td>
        </tr>
    </table>
    <a href="edit.php?id=<? echo $_GET['id']; ?>">Изменить</a>
    <a href="index.php">К кандидатам</a>
    <?
}
require '../template/footer.php';?>
