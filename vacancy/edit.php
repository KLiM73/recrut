<?
require '../app/index.php';
$title = "Изменение вакансии";
require '../template/header.php';

?>
<script>
    function takeData() {
        var select = document.getElementsByName('vacancy').value;
        
    }
</script>
<form action="../app/db.php" method="post">
    <label for="vacancy">Выберите вакансию:</label>
    <select name="vacancy" id="vacancy" onselect="takeData()">
        <?
        foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
            echo "<option value=".$row['id'].">".$row['id'].", ".$row['name']."</option>";
        }
        ?>
    </select>
</form>

<form action="../app/db.php" method="post">
    <label for="name">Название</label>
    <input id="name" name="name" type="text"><br>

    <label for="description">Описание</label>
    <textarea id="description" name="description"></textarea><br>

    <label for="iniciator">Инициатор</label>
    <select id="iniciator" name="iniciator">
        <option value="1">test</option>
    </select><br>

    <label for="doer">Исполнитель</label>
    <select id="doer" name="doer">
        <option value="1">test</option>
    </select><br>

    <input type="submit" name="updateVacancy" value="Добавить">
</form>
