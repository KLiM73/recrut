<?
require '../app/index.php';
$title = "Изменение вакансии";
require '../template/header.php';
?>

<form action="../app/db.php" method="post">
    <label for="vacancy">Выберите вакансию:</label><br>
    <select name="vacancy" id="vacancy"">
        <?
        foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
            echo "<option value=".$row['id'].">".$row['id'].", ".$row['name']."</option>";
        }
        ?>
    </select><br>

    <label for="name">Название</label><br>
    <input id="name" name="name" type="text"><br>

    <label for="description">Описание</label><br>
    <textarea id="description" name="description"></textarea><br>

    <label for="iniciator">Инициатор</label><br>
    <select id="iniciator" name="iniciator">
        <option value="1">test</option>
    </select><br>

    <label for="doer">Исполнитель</label><br>
    <select id="doer" name="doer">
        <option value="1">test</option>
    </select><br>

    <input type="submit" name="updateVacancy" value="Изменить">
</form>
<? require '../template/footer.php'; ?>