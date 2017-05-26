<?
class Vacancy {
    public $ID;
    public $NAME;
    public $DESC;
    public $INICIATOR;
    public $DOER;
}

class Candidate {
    public $FIO;
    public $B_DATE;
    public $ID;
    public $VAC_ID = array();
    public $DESC;
    public $RESUME;
    public $COMMENTS;
}

class Event {
    public $ID;
    public $VACANCY_ID;
    public $CANDIDATE_ID;
    public $STATUS;
    public $COMMENTS;
}

$status = array (
    "1" => "Резюме просматривалось",
    "2" => "Проведено телефонное интервью",
    "3" => "Назначена встреча",
    "4" => "Дано тестовое задание",
    "5" => "Назначена итоговая встреча",
    "6" => "Предложение о работе",
    "7" => "Прием на работу",
    "8" => "Кандидат отказался от предложения о работе",
    "9" => "Отказ кандидату",
    "10" => "Отказ на данную вакансию",
    "11" => "Статус в комментариях"
);

class User {
    public $LOGIN;
}
?>