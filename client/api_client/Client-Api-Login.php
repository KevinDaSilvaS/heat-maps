<?php

$path = '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR;

require_once ($path . 'Validations.php');
require_once ($path . 'HandlerDataBase.php');

$db = new HandlerDataBase();
$validate = new Validations($db);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->email)) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>
            "Email not passed or passed in a 
            incorrect format make sure your requuisition is post and the name is email."));
            exit;
        }

        if (!isset($data->password)) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>
            "Password not passed or passed in a 
            incorrect format make sure your requisition is post and the name is password."));
            exit;
        }

        $email = mysqli_real_escape_string($mysqli_connection,$data->email);
        $password = mysqli_real_escape_string($mysqli_connection,$data->password);
        $password = md5($password);

        $searchLogin = $db->selectWhere("token","tokens","email='$email' AND password='$password'");
        
        if (is_array($searchLogin)) {
            $token = $searchLogin[0]["token"];
            header("HTTP/1.1 201 CREATED");
            echo json_encode(array(
                "response"=>"User logged sucessfully.",
                "token"=>$token,
            ));
            exit;
        }

        header("HTTP/1.1 400 BAD REQUEST");
        echo json_encode(array("response"=>
        "User not find to add a new user use example.com/Client-Api."));

        break;
}
?>