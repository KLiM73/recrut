<?
session_start();

$title = 'Вход';
require './app/db.php';
$message = '';
if (isset($_POST['userLogin'])) {
    $user = userLogin($_POST['login']);
    if ($user['login'] == $_POST['login'] AND $user['password'] == $_POST['password']) {
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['group'] = $user['userGroup'];
        $_SESSION['fio'] = $user['fio'];
        header('Location: http://test/');
        exit;
    } else $message = 'Неверный логин или пароль!';
}

if(@$_SESSION['login']) {
    header('Location: http://test/');
    exit;
}
?>

<html>
<head>
    <title><? echo $title; ?></title>
    <link rel="stylesheet" href="http://test/template/style.css">
</head>
<body>
<header>
    <h1><? echo $title; ?></h1>
</header>
<form method="post" id="frm">
    <label for="login">Логин:</label><br>
    <input name="login" id="login" type="text"><br>
    <label for="password">Пароль:</label><br>
    <input type="password" name="password" id="password"><br>
    <span id="answer"><? echo $message; ?></span><br>
    <input type="submit" name="userLogin" value="Вход">
</form>

<form action="./app/db.php" method="post">
    <input type="submit" name="createDB" value="Создать таблицы">
</form>