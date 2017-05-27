<?
require '../app/index.php';
$title = "Удаление кандидата";
require '../template/header.php';

if (!($_SESSION['group'] == 'Администратор' OR $_SESSION['group'] == 'Менеджер по персоналу')){
    echo 'У вас нет доступа к этому разделу!';
} else {
?>

<form action="../app/db.php" method="post">
    <label for="vacancy">Выберите кандидата для удаления:</label>
    <select name="candidates" id="candidates">
        <?
        foreach (dbDoTransaction("SELECT * FROM candidate") as $row) {
            echo "<option value=".$row['id'].">".$row['id'].", ".$row['fio']."</option>";
        }
        ?>
    </select>
    <input type="submit" value="Удалить" name="deleteCandidate">
</form>
<?
}
require '../template/footer.php'; ?>