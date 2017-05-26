<?
require '../app/index.php';
$title = "Добавление вакансии";
require '../template/header.php';
?>

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

    <input type="submit" name="insertVacancy" value="Добавить">
</form>
<? require '../template/footer.php'; ?>