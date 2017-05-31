<?
$GLOBALS['domain'] = 'http://test';
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
    <link rel="stylesheet" href="<? echo $GLOBALS['domain']; ?>/template/style.css">
</head>
<body>
<header class="clearfix">
    <h1 class="logo"><? echo $title; ?></h1>
    <div class="nameGroup clearfix">
    <?
    if($_SESSION['login']) {
        echo '<h2 class="name">Здравствуйте, '.$_SESSION['fio'].'! <a href="http://'.$_SERVER['HTTP_HOST'].'?do=logout">Выйти</a></h2>';
        echo '<h2 class="group">Ваша группа: '.$_SESSION['group'].'</h2>';
    }
    ?></div>
</header>