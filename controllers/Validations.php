<?php

final class Validations{

    private $db;

    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function validateString(string $message)
    {
        return strlen($message) <= 45 && !is_numeric($message);
    }

    public function validateMail(string $email)
    {
        return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

    public function validateInteger(string $integer)
    {
        return filter_var($integer,FILTER_VALIDATE_INT) && $integer > 0;
    }

    public function existsToken($token)
    {
        if (!$token) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"token cannot be null"));
            exit;
        }
    }

    public function validateToken($token)
    {
        $searchToken = $this->db->selectWhere("expire_date","tokens","token = '$token'");
        if (!is_array($searchToken)) {
            
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"token doens´t exists please check and try again"));
            exit;
        }

        if ($searchToken[0]['expire_date'] < date('Y-m-d')) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"your token is currently expired check if you dont have any debt at:"));
            exit;
        }

        return true;
        
    }

    public function validateClickFields($data)
    {
        if (!$data) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"Expected parameters but null given" . $data));
            exit;
        }

        $errors =  array();
        if (!isset($data->positionX)) {
            array_push($errors,"position X not given.");
        }

        if (!is_int($data->positionX)) {
            array_push($errors,"position X should be integer.");
        }

        if (!isset($data->positionY)) {
            array_push($errors,"position Y not given.");
        }

        if (!is_int($data->positionY)) {
            array_push($errors,"position Y should be integer.");
        }

        if (count($errors) > 0) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"Invalid or null fields",
            "errors"=>$errors));
            exit;
        }

    }

    public function validatePageNumber($pageNumber, $token)
    {
        if (!intval($pageNumber) || $pageNumber < 0) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"invalid page number expecting integer received: " 
            .$pageNumber. ".Please inform a valid integer."));
            exit;
        }

        $getMaxPages = $this->db->selectWhere("max_pages","tokens","token = '$token'");
        if (!is_array($getMaxPages)) {
            
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"token doens´t exists please check and try again"));
            exit;
        }

        if ($pageNumber > $getMaxPages[0]['max_pages']) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(
                array("response"=>"You´ve reached your max pages number: " . 
                $getMaxPages[0]['max_pages'] . " contact us for a upgrade at example.com")
            );
            exit;
        }

        return true;
    }

    public function hasLimit($limit)
    {
        if ($limit) {
            return true;
        }

        return false;
    }

    public function hasPeriod($start, $end)
    {
        if ($start && $end) {
            $format = "Y-m-d";
            $dateStart = DateTime::createFromFormat($format, $start);
            $dateEnd= DateTime::createFromFormat($format, $end);

            if (($dateStart && $dateStart->format($format) == $start) && 
                ($dateEnd && $dateEnd->format($format) == $end)) {
                return true;
            }

            return false;
        }

        return false;
    }
}

?>