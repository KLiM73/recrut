<?
require './app/index.php';
$title = "Учет кандидатов";
require './template/header.php';
$GLOBALS['countVacancies'] = 0;
$GLOBALS['countCandidates'] = 0;
foreach (dbDoTransaction('SELECT * FROM vacancy') as $row) {
    $GLOBALS['countVacancies'] += 1;
}
foreach (dbDoTransaction('SELECT * FROM candidate') as $row) {
    $GLOBALS['countCandidates'] += 1;
}
?>

<div class="content">
<div class="menu">
    <ul>
        <?
        if (($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
        ?>
        <li><a href="./vacancy/">Вакансии (<? echo $GLOBALS['countVacancies']; ?>)</a></li>
        <li><a href="./candidates/">Кандидаты (<? echo $GLOBALS['countCandidates']; ?>)</a></li>
        <li><a href="./events/">События</a></li>
        <? } ?>
        <li><a href="./users/">Пользователи и группы</a></li>
    </ul>
</div>
</div>
<footer>
</footer>
</body>
</html>