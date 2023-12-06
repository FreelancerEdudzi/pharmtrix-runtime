<?php
session_start();

include_once(__DIR__. "/../../helper.php");


$user_id = useMiddleware();
$all_filter = $_POST['all_filter'];

$query = "SELECT * FROM pharmtrixw_retailer where user_id=". $user_id ;


if (isset($all_filter)){
    $arr_filter = json_decode($all_filter);
    foreach ($arr_filter as $key => $value) {   
      if (($value !== null) && ($value !== "")) {
        $query .=  ' and '.$key.'= '.$value;
      }
    }
}


if (isset($_POST['retailer_id'])){
    $query .= ' and pharmtrixw_retailer_id ='.$_POST['retailer_id'];
}
$retailer_query = mysqli_query($connection, $query);

$all_rows = mysqli_fetch_all($retailer_query, MYSQLI_ASSOC);

sendJson(
    200,
    "",
    (array('data'=> $all_rows))
);
