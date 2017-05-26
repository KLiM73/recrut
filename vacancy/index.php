<?
require '../app/index.php';
$title = "Вакансии";
require '../template/header.php';
?>

<div class="content">
    <div class="vacancyList">
        <ul>
            <? foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
                echo "<li>".$row['id'].' '.$row['name'].' '.$row['iniciator'].' '.$row['doer'].' '.$row['description']."</li>";
            }
            ?>
        </ul>
    </div>
    <a href="add.php">Добавить>></a>
    <a href="edit.php">Изменить</a>
    <a href="delete.php">Удалить>></a>
</div>
<footer>

</footer>
</body>
</html>