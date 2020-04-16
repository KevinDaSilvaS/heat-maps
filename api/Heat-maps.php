<?php
header("Content-Type: application/json", true);
require_once ('Validations.php');
require_once ('HandlerDataBase.php');

$db = new HandlerDataBase();
$validate = new Validations($db);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $userToken = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"token"));
        $validate->existsToken($userToken);
        $validate->validateToken($userToken);

        $data = json_decode(file_get_contents("php://input"));
        $validate->validateClickFields($data);

        $hasDate = $validate->hasDate($data);
        
        $fields = "token,posX,posY"; 
        $positionX = mysqli_real_escape_string($mysqli_connection,$data->positionX);
        $positionY = mysqli_real_escape_string($mysqli_connection,$data->positionY);
        $values = "'$userToken','$positionX','$positionY'";

        if ($hasDate) {
            $date = mysqli_real_escape_string($mysqli_connection,$data->date);
            $fields = "token,date,posX,posY"; 
            $values = "'$userToken','$date','$positionX','$positionY'";
        }

        $insertLog = $db->insertFields("logs",$fields,$values);

        if ($insertLog != 1) {
            header("HTTP/1.1 500 INTERNAL SERVER ERROR");
            echo json_encode(array("response"=>"Unexpected exception happened.\n " . $insertLog));
            exit;
        }

        header("HTTP/1.1 201 CREATED");
        echo json_encode(array("response"=>"New log successfully created."));
        break;

    case 'GET':
        $userToken = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"token"));
        $validate->existsToken($userToken);
        $validate->validateToken($userToken);

        $start = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"start"));
        $end = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"end"));
        $hasPeriod = $validate->hasPeriod($start, $end);

        $limit = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"limit"));
        $hasLimit = $validate->hasLimit($limit);

        $conditional = " posX = posX AND posY = posY AND token = '$userToken' ";

        if ($hasPeriod) {
            $conditional .= " AND date BETWEEN '$start' AND '$end'";
        }

        $limitQuery = '';
        if ($hasLimit) {
            $limitQuery = "ORDER BY date DESC LIMIT " . $limit;
        }

        $fields = "COUNT(id) AS amount,posX,posY ";
        $selectLogs = $db->selectWhere($fields,"logs",$conditional . " GROUP BY posX " . $limitQuery);

        echo json_encode($selectLogs);
        break;

    
}


?>