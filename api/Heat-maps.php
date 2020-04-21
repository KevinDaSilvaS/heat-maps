<?php
header("Content-Type: application/json", true);

$path = '..'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR;

require_once ($path . 'Validations.php');
require_once ($path . 'HandlerDataBase.php');

$db = new HandlerDataBase();
$validate = new Validations($db);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
        $userToken = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"token"));
        $validate->existsToken($userToken);
        $validate->validateToken($userToken);

        $data = json_decode(file_get_contents("php://input"));
        $validate->validateClickFields($data);
        $validate->validatePageNumber($data->pageNumber, $userToken);
        
        $positionX = mysqli_real_escape_string($mysqli_connection,$data->positionX);
        $positionY = mysqli_real_escape_string($mysqli_connection,$data->positionY);
        $pageNumber = mysqli_real_escape_string($mysqli_connection,$data->pageNumber);

        $date = date('Y-m-d');
        //$hour = date('H:i:s');
        $fields = "token,date,posX,posY,page_number"; 
        $values = "'$userToken','$date','$positionX','$positionY','$pageNumber'";

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
        $pageNumber = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"pagen"));

        $validate->existsToken($userToken);
        $validate->validateToken($userToken);
        $validate->validatePageNumber($pageNumber, $userToken);

        $start = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"start"));
        $end = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"end"));
        $hasPeriod = $validate->hasPeriod($start, $end);

        $limit = mysqli_real_escape_string($mysqli_connection,filter_input(INPUT_GET,"limit"));
        $hasLimit = $validate->hasLimit($limit);

        $conditional = " posX = posX AND posY = posY AND 
        token = '$userToken' AND page_number = '$pageNumber'";

        if ($hasPeriod) {
            $conditional .= " AND date BETWEEN '$start' AND '$end'";
        }

        $limitQuery = "ORDER BY date DESC LIMIT 150";
        if ($hasLimit) {
            $limitQuery = "ORDER BY date DESC LIMIT " . $limit;
        }

        $fields = "COUNT(id) AS amount,posX,posY ";
        $selectLogs = $db->selectWhere($fields,"logs",$conditional . " GROUP BY posX " . $limitQuery);

        echo json_encode($selectLogs);
        break;


}


?>