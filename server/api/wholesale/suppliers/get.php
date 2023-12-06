<?php
session_start();

include_once(__DIR__. "/../../helper.php");


$user_id = useMiddleware();
$all_filter = $_POST['all_filter'];

$query = "SELECT * FROM pharmtrixw_supplier where user_id=". $user_id ;

if (isset($all_filter)){
    $arr_filter = json_decode($all_filter);
    foreach ($arr_filter as $key => $value) {   
      if (($value !== null) && ($value !== "")) {
        $query .=  ' and '.$key.'= '.$value;
      }
    }
}

if (isset($_POST['supplier_id'])){
    $query .= ' and pharmtrixw_supplier_id='.$_POST['supplier_id'];
}
$supplier_query = mysqli_query($connection, $query);


$all_rows = mysqli_fetch_all($supplier_query, MYSQLI_ASSOC);

sendJson(
    200,
    "",
    (array('data'=> $all_rows))
);
