<?
require '../app/index.php';
$title = "Добавление кандидата";
require '../template/header.php';
?>

<form action="../app/db.php" method="post">
    <label for="fio">ФИО</label><br>
    <input id="fio" name="fio" type="text"><br>

    <label for="b_date">Дата рождения</label><br>
    <input type="date" id="b_date" name="b_date"><br>

    <label for="vacancies">Вакансии</label><br>
    <select id="vacancies" name="vacancies[]" multiple>
        <?
        foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
            echo "<option value=".$row['id'].">".$row['id'].", ".$row['name']."</option>";
        }
        ?>
    </select><br>

    <label for="description">Описание</label><br>
    <textarea name="description" id="description"></textarea><br>

    <label for="resume">Резюме</label><br>
    <input type="file" id="resume" name="resume"><br>

    <label for="comments">Комментарии</label><br>
    <textarea name="comments" id="comments"></textarea><br>

    <input type="submit" name="insertCandidate" value="Добавить">
</form>
<? require '../template/footer.php'; ?>