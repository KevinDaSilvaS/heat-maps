<?php

$path = '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR;

require_once ($path . 'Validations.php');
require_once ($path . 'HandlerDataBase.php');

$db = new HandlerDataBase();
$validate = new Validations($db);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $userToken = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"token"));

        $currentDate = date('Y-m-d');

        $allLogs = array();

        $selectTodayLogs = $db->selectCountWhere("id","logs","token = '$userToken' 
        AND date = '$currentDate'");
        $allLogs["today"] = $selectTodayLogs;

        $weekStartDate = date('Y-m-d', strtotime($currentDate. ' -7 day'));
        $selectWeekLogs = $db->selectCountWhere("id","logs","token = '$userToken' 
        AND date BETWEEN '$weekStartDate' AND '$currentDate'");
        $allLogs["week-logs"] = $selectWeekLogs;

        $halfMonthStartDate = date('Y-m-d', strtotime($currentDate. ' -15 day'));
        $select15daysLogs = $db->selectCountWhere("id","logs","token = '$userToken' 
        AND date BETWEEN '$halfMonthStartDate' AND '$currentDate'");
        $allLogs["15day-logs"] = $select15daysLogs;

        $oneMonthStartDate = date('Y-m-d', strtotime($currentDate. ' -30 day'));
        $select30daysLogs = $db->selectCountWhere("id","logs","token = '$userToken' 
        AND date BETWEEN '$oneMonthStartDate' AND '$currentDate'");
        $allLogs["30day-logs"] = $select30daysLogs;

        $nextExpireDate = date('Y-m-d', strtotime($currentDate. ' +7 day'));
        $updateExpireDate = $db->update("tokens",
        "expire_date = '$nextExpireDate'","token = '$userToken'");

        echo json_encode($allLogs);
        break;
}
?>