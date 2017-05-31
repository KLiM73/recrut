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
    dbUpdateVacancy($_POST['id'], $_POST['name'], $_POST['description'], $_POST['iniciator'], $_POST['doer']);
}

if (isset($_POST['insertCandidate'])) {
    dbAddCandidate($_POST['fio'], $_POST['b_date'], $_POST['description'], $_POST['comments']);
    echo 'select * from candidate where fio = "'.$_POST['fio'].'";';
    foreach (dbDoTransaction('select * from candidate where fio = "'.$_POST['fio'].'";') as $row) {
        $id = $row['id'];
        break;
    }
    if(is_uploaded_file($_FILES['resume']['tmp_name'])) {
        move_uploaded_file($_FILES['resume']['tmp_name'], '/home/klim/Projects/test/resume/'.$id);
    }
    header("Location: http://test/candidates");
}
if (isset($_POST['updateCandidate'])) {
    dbUpdateCandidate($_POST['id'], $_POST['fio'], $_POST['b_date'], $_POST['description'], $_POST['id'], $_POST['comments']);
    if(is_uploaded_file($_FILES['resume']['tmp_name'])) {
        move_uploaded_file($_FILES['resume']['tmp_name'], '/home/klim/Projects/test/resume/'.$_POST['id']);
    }
    echo $_FILES['resume']['name'];
    header("Location: http://test/candidates");
}

if (isset($_POST['userAdd'])) {
    userAdd($_POST['login'], $_POST['fio'], $_POST['password'], $_POST['userGroup']);
}
if (isset($_POST['userEdit'])) {
    userUpdate($_POST['id'], $_POST['login'], $_POST['password'], $_POST['userGroup'], $_POST['fio']);
}

if (isset($_POST['insertVacancyEvent'])) {
    dbAddVacancyEvent($_POST['vacancy_id'], $_POST['date'], $_POST['candidate_id'], $_POST['status'], $_POST['comments']);
    header('Location: '.$GLOBALS['domain'].'/events');
}
if (isset($_POST['updateVacancyEvent'])) {
    dbUpdateVacancyEvent($_POST['id'], $_POST['date'], $_POST['vacancy_id'], $_POST['candidate_id'], $_POST['status'], $_POST['comments']);
    header('Location: '.$GLOBALS['domain'].'/events');
}


function dbCreate() {
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
date DATE NOT NULL,
vacancy_id int(11) NOT NULL,
candidate_id int(11) NOT NULL,
status varchar(50) NOT NULL,
comments varchar(500) NULL,
PRIMARY KEY (id))");

        $stmt3 = $pdo->query("CREATE TABLE users(
id int(11) NOT NULL AUTO_INCREMENT,
login varchar(45) NOT NULL,
fio varchar(60) NOT NULL,
password varchar(45) NOT NULL,
userGroup varchar(30) NULL,
PRIMARY KEY (id))");

        $stmt4 = $pdo->query("insert into users(login, password, fio, userGroup) values('admin', 'admin', 'Администратор', 'Администратор')");
        header('Location: http://test');
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        echo 'Таблицы уже созданы!';
        require '../template/footer.php';
    }
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
        $stmt = $pdo->prepare("select * from users where login = :login");
        $stmt->execute(array('login' => $name));
        foreach ($stmt as $row) {
            return $row;
            break;
        }
    } catch (PDOException $e) {
        return NULL;
    }
}
function userAdd($login, $fio, $password, $userGroup) {
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
    $stmt = $pdo->prepare("insert into users(login, password, fio, userGroup) values(:login, :password, :fio, :userGroup)");
    $stmt->execute(array('login' => $login, 'password' => $password, 'fio' => $fio, 'userGroup' => $userGroup));
    header('Location: http://test/users');
}
function userUpdate($id, $login, $password, $userGroup, $fio) {
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
        $stmt = $pdo->prepare("UPDATE users SET login = :login, password = :password, fio = :fio, userGroup = :userGroup WHERE id = :id;");
        $stmt->execute(array('id' => $id, 'login' => $login, 'password' => $password, 'fio' => $fio, 'userGroup' => $userGroup));
        header("Location: http://test/users");

    } catch (PDOException $e) {
        die('Ошибка: '.$e->getMessage());
    }

}
function userDelete($id) {
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

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute(array($id));
    header("Location: http://test/users/");
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

function dbAddCandidate($fio, $b_date, $desc, $comments) {
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

        $stmt = $pdo->prepare("INSERT INTO candidate(fio, b_date, description, comments) VALUES(:fio, :b_date, :description, :comments)");
        $stmt->execute(array('fio' => $fio, 'b_date' => $b_date, 'description' => $desc, 'comments' => $comments));

    } catch (PDOException $e) {
        die('Ошибка: '.$e->getMessage());
    }

}
function dbUpdateCandidate($id, $fio, $b_date, $desc, $resume, $comments) {
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
        $stmt = $pdo->prepare("UPDATE candidate SET fio = :fio, b_date = :b_date, description = :description, resume = :resume, comments = :comments WHERE id = :id;");
        $stmt->execute(array('fio' => $fio, 'b_date' => $b_date, 'description' => $desc, 'resume' => $resume, 'comments' => $comments, 'id' => $id));

    } catch (PDOException $e) {
        die('Ошибка: '.$e->getMessage());
    }
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

function dbAddVacancyEvent($vac_id, $date, $candidate_id, $status, $comments) {
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
    $stmt = $pdo->prepare("INSERT INTO vacancyEvent(date, vacancy_id, candidate_id, status, comments) VALUES(:date, :vacancy_id, :candidate_id, :status, :comments)");
    $stmt->execute(array('date' => $date, 'vacancy_id' => $vac_id, 'candidate_id' => $candidate_id, 'status' => $status, 'comments' => $comments));
}
function dbUpdateVacancyEvent($id, $date, $vacancy_id, $candidate_id, $status, $comments) {
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
    $stmt = $pdo->prepare("UPDATE vacancyEvent SET date = :date, vacancy_id = :vacancy_id, candidate_id = :candidate_id, status = :status, comments = :comments WHERE id = :id;");
    $stmt->execute(array('id' => $id, 'date' => $date, 'vacancy_id' => $vacancy_id, 'candidate_id' => $candidate_id, 'status' => $status, 'comments' => $comments));

}
function dbDeleteVacancyEvent($id) {
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

    $stmt = $pdo->prepare("DELETE FROM vacancyEvent WHERE id = ?");
    $stmt->execute(array($id));
    header("Location: http://test/events/");
}
?>