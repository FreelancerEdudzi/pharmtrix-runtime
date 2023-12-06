<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, PUT, GET, OPTIONS, DELETE');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header("Access-Control-Allow-Credentials: true");

include_once("includes/db_connection.php");
include_once('includes/sendJson.php');
include_once('includes/jwtHandler.php');


function useMiddleware(){
   
    $headers = getallheaders();
   if (array_key_exists('Authorization', $headers) && preg_match('/Bearer\s(\S+)/m', $headers['Authorization'], $matches)) {
       $data = decodeToken($matches[1]);
        $userId = (int) $data;
     if (!is_numeric($data)) sendJson(401, 'Invalid User!');   
        return $userId;
   }else{
    die();
    sendJson(403, "Authorization Token is Missing!");

   }
  
}

function checkGetType($type){
    return isset($_POST['type']) && $_POST['type'] == $type ;
}