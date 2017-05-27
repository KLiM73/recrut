<?
if (isset($_POST['createDB']))
{
    dbCreate();
}

if (isset($_POST['insertVacancy']))
{
    dbAddVacancy($_POST['name'], $_POST['description'], $_POST['iniciator'], $_POST['doer']);
}
if (isset($_POST['updateVacancy'])){
    dbUpdateVacancy($_POST['vacancy'], $_POST['name'], $_POST['description'], $_POST['iniciator'], $_POST['doer']);
}
if (isset($_POST['deleteVacancy'])) {
    dbDeleteVacancy($_POST['vacancy']);
}

if (isset($_POST['insertCandidate'])) {
    $strVacId = '';
    foreach ($_POST['vacancies'] as $id) {
        $strVacId .= $id.' ';
    }
    dbAddCandidate($_POST['fio'], $_POST['b_date'], $strVacId, $_POST['description'], 1234, $_POST['comments']);
    echo "\n run \n";
    echo $strVacId;
    echo '<pre>';
    print_r($_POST['vacancies']);
}
if (isset($_POST['updateCandidate'])) {
    $strVacId = '';
    foreach ($_POST['vacancies'] as $id) {
        $strVacId .= $id.' ';
    }
    dbUpdateCandidate($_POST['candidate'], $_POST['fio'], $_POST['b_date'], $strVacId, $_POST['description'], 1234, $_POST['comments']);
}
if (isset($_POST['deleteCandidate'])) {
    dbDeleteCandidate($_POST['candidates']);
}

if (isset($_POST['viewCandidate'])) {
    $view = dbDoTransaction('select * from candidate where id = '.$_POST['candidate']);
    return $view;
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

        $stmt3 = $pdo->query("CREATE TABLE users(
id int(11) NOT NULL AUTO_INCREMENT,
name varchar(45) NOT NULL,
groups varchar(10) NULL,
PRIMAY KEY (id))");

        $stmt4 = $pdo->query("insert into users(name, password, groups) values('admin', 'admin', '0')");

    header("Location: http://test");
}

function userLogin($name) {
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
        $stmt = $pdo->prepare("select * from users where name = :name");
        $stmt->execute(array('name' => $name));
        foreach ($stmt as $row) {
            return $row;
            break;
        }
    } catch (PDOException $e) {
        return NULL;
    }
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
    header("Location: http://test/vacancy");
}
function dbUpdateVacancy($id, $name, $desc, $iniciator, $doer) {
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
        $stmt = $pdo->prepare("UPDATE vacancy SET name = :name, description = :description, iniciator = :iniciator, doer = :doer WHERE id = :id;");
        $stmt->execute(array('name' => $name, 'description' => $desc, 'iniciator' => $iniciator, 'doer' => $doer, 'id' => $id));

    } catch (PDOException $e) {
        die('Ошибка: '.$e->getMessage());
    }
    header("Location: http://test/vacancy");
}
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

function dbAddCandidate($fio, $b_date, $vac_id, $desc, $resume, $comments) {
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

        $stmt = $pdo->prepare("INSERT INTO candidate(fio, b_date, vac_id, description, resume, comments) VALUES(:fio, :b_date, :vac_id, :description, :resume, :comments)");
        $stmt->execute(array('fio' => $fio, 'b_date' => $b_date, 'vac_id' => $vac_id, 'description' => $desc, 'resume' => $resume, 'comments' => $comments));

    } catch (PDOException $e) {
        die('Ошибка: '.$e->getMessage());
    }
    header("Location: http://test/candidates");
}
function dbUpdateCandidate($id, $fio, $b_date, $vac_id, $desc, $resume, $comments) {
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
        $stmt = $pdo->prepare("UPDATE candidate SET fio = :fio, b_date = :b_date, vac_id = :vac_id, description = :description, resume = :resume, comments = :comments WHERE id = :id;");
        $stmt->execute(array('fio' => $fio, 'b_date' => $b_date, 'vac_id' => $vac_id, 'description' => $desc, 'resume' => $resume, 'comments' => $comments, 'id' => $id));

    } catch (PDOException $e) {
        die('Ошибка: '.$e->getMessage());
    }
    header("Location: http://test/candidates");
}
function dbDeleteCandidate($id) {
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

    $stmt = $pdo->prepare("DELETE FROM candidate WHERE id = ?");
    $stmt->execute(array($id));
    header("Location: http://test/candidates/");
}

?>