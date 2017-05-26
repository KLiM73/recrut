<?
if (isset($_POST['createDB']))
{
    dbCreate();
}
if (isset($_POST['insertVacancy']))
{
    dbAddVacancy($_POST['name'], $_POST['description'], $_POST['iniciator'], $_POST['doer']);
}
if (isset($_POST['deleteVacancy'])) {
    dbDeleteVacancy($_POST['vacancy']);
}
function dbCreate() {
    $host = '127.0.0.1:3306';
    $db = 'uchet';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);

        $stmt = $pdo->query("CREATE TABLE vacancy(
id int(11) NOT NULL AUTO_INCREMENT, 
name varchar(45) NOT NULL, 
description varchar(1000) NULL, 
iniciator int(11) NOT NULL, 
doer int(11) NULL, 
PRIMARY KEY (id))");

        $stmt1 = $pdo->query("CREATE TABLE candidate(
id int(11) NOT NULL AUTO_INCREMENT, 
fio varchar(60) NOT NULL, 
b_date DATE NOT NULL, 
vac_id varchar(60) NULL,
description varchar(500) NULL,
resume varchar(50) NULL,
comments varchar(500) NULL,
PRIMARY KEY (id))");

        $stmt2 = $pdo->query("CREATE TABLE vacancyEvent(
id int(11) NOT NULL AUTO_INCREMENT,
vacancy_id int(11) NOT NULL,
candidate_id int(11) NOT NULL,
status int(1) NOT NULL,
comments varchar(500) NULL,
PRIMARY KEY (id))");
}

function dbAddVacancy($name, $desc, $iniciator, $doer) {
    try {
        $host = '127.0.0.1:3306';
        $db = 'uchet';
        $user = 'root';
        $pass = '';
        $charset = 'utf8';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $opt);
        $stmt = $pdo->prepare("INSERT INTO vacancy(name, description, iniciator, doer) VALUES(:name, :desc, :iniciator, :doer)");
        $stmt->execute(array('name' => $name, 'desc' => $desc, 'iniciator' => $iniciator, 'doer' => $doer));

    } catch (PDOException $e) {
        die('Ошибка: '.$e->getMessage());
    }
    header("Location: http://test/vacancy/");
}

function dbEditVacancy() {}

function dbDeleteVacancy($id) {
    $host = '127.0.0.1:3306';
    $db = 'uchet';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);

    $stmt = $pdo->prepare("DELETE FROM vacancy WHERE id = ?");
    $stmt->execute(array($id));
    header("Location: http://test/vacancy/");
}

function dbDoTransaction($transaction) {
    $host = '127.0.0.1:3306';
    $db = 'uchet';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);
    $stmt = $pdo->prepare($transaction);
    $stmt->execute();
    return $stmt;
}
?>