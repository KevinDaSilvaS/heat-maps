<?php

$path = '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR;

require_once ($path . 'Validations.php');
require_once ($path . 'HandlerDataBase.php');

$db = new HandlerDataBase();
$validate = new Validations($db);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        
        break;
}
?>