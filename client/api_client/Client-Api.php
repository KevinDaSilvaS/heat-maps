<?php

$path = '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR;

require_once ($path . 'Validations.php');
require_once ($path . 'HandlerDataBase.php');

$db = new HandlerDataBase();
$validate = new Validations($db);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        $validate->validateMail($data->email);
        $validate->validateString($data->name);
        $validate->validatePasswords($data->password);

        $lastId = $db->selectLastLineOfTable("id", "tokens", "id");
        if (!is_array($lastId)) {
            $lastId = 1;
        }else {
            $lastId = $lastId[0]['id'] + 1;
        }
        
        $date = date('Y-m-d');
        $expireDate = date('Y-m-d', strtotime($date. ' + 7 day'));
        $email = mysqli_real_escape_string($mysqli_connection,$data->email);
        $token = md5($email . $lastId);
        $name = mysqli_real_escape_string($mysqli_connection,$data->name);
        $password = mysqli_real_escape_string($mysqli_connection,$data->password);
        $password = md5($password);
        $maxPages = 1;

        $fields = "token,expire_date,email,name,max_pages,password";
        $values = "'$token','$expireDate','$email','$name','$maxPages','$password'";

        if (isset($data->phone)) {
            $validate->validateCharacters($data->phone);
            $phone = mysqli_real_escape_string($mysqli_connection,$data->phone);

            $fields = "token,expire_date,email,phone,name,max_pages,password";
            $values = "'$token','$expireDate','$email','$phone','$name','$maxPages','$password'";
        }

        $insertUser = $db->insertFields("tokens",$fields,$values);

        if ($insertUser != 1) {
            header("HTTP/1.1 500 INTERNAL SERVER ERROR");
            echo json_encode(array("response"=>"Unexpected exception happened.\n " . $insertUser));
            exit;
        }

        header("HTTP/1.1 201 CREATED");
        echo json_encode(array("response"=>"New user successfully created."));
        
        break;
}
?>