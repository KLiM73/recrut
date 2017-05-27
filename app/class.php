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

$GLOBALS['candidateStatuses'] = array (
    'Резюме просматривалось',
    'Проведено телефонное интервью',
    'Назначена встреча',
    'Дано тестовое задание',
    'Назначена итоговая встреча',
    'Предложение о работе',
    'Прием на работу',
    'Кандидат отказался от предложения о работе',
    'Отказ кандидату',
    'Отказ на данную вакансию',
    'Статус в комментариях'
);

$GLOBALS['userGroups'] = array (
    'Администратор',
    'Руководитель',
    'Менеджер по персоналу',
    'Пользователь'
);

class User {
    public $LOGIN;
}


?>