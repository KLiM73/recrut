<?
session_start();
if($_GET) {
    if (@$_GET['do'] == 'logout') {
        unset($_SESSION['login']);
        session_destroy();
    }
}

if(!$_SESSION['login']) {
    header("Location: http://test/login.php");
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

    <?
    if($_SESSION['login']) {
        echo '<h2>Здравствуйте, '.$_SESSION['login'].'! <a href="http://'.$_SERVER['HTTP_HOST'].'?do=logout">Выйти</a></h2>';
    }
    ?>
</header>