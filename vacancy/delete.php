<?
require '../app/index.php';
$title = "Удаление вакансии";
require '../template/header.php';
?>

<form action="../app/db.php" method="post">
    <label for="vacancy">Выберите вакансию для удаления:</label>
    <select name="vacancy" id="vacancy">
        <?
        foreach (dbDoTransaction("SELECT * FROM vacancy") as $row) {
            echo "<option value=".$row['id'].">".$row['id'].", ".$row['name']."</option>";
        }
        ?>
    </select>
    <input type="submit" value="Удалить" name="deleteVacancy">
</form>