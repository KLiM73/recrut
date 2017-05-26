<?
require './app/index.php';
$title = "Главная";
require './template/header.php';
?>

<div class="content">
<div class="menu">
    <ul>
        <li><a href="./vacancy/">Вакансии (0)</a></li>
        <li><a href="./candidates/">Кандидаты (0)</a></li>
    </ul>
</div>
</div>
<footer>
    <form action="./app/db.php" method="post">
        <input type="submit" name="createDB" value="Создать таблицы">
    </form>
</footer>
</body>
</html>