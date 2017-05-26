<?
require '../app/index.php';
$title = "Кандидаты";
require '../template/header.php';
?>

<div class="content">
    <div class="candidateList">
        <ul>
            <? foreach (dbDoTransaction("SELECT * FROM candidate") as $row) {
                echo "<li>".$row['id'].' '.$row['fio'].' '.$row['b_date'].' '.$row['description']."</li>";
            }
            ?>
        </ul>
    </div>
    <a href="add.php">Добавить>></a>
    <a href="edit.php">Изменить</a>
    <a href="delete.php">Удалить>></a>
</div>
<? require '../template/footer.php'; ?>