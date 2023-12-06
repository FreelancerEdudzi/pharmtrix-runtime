<?php
session_start();

include_once(__DIR__. "/../../helper.php");


$user_id = useMiddleware();

$data=[
    'suppliers'=>0,
    'retailers' => 0
];

$query = "SELECT * FROM pharmtrixr_supplier where user_id=". $user_id ;
$suppliers_query = mysqli_query($connection, $query);

$all_rows_supplier = mysqli_fetch_all($suppliers_query, MYSQLI_ASSOC);

$query = "SELECT * FROM pharmtrixw_retailer where user_id=". $user_id ;
$retailers_query = mysqli_query($connection, $query);

$all_rows_retailer = mysqli_fetch_all($retailers_query, MYSQLI_ASSOC);


$data['suppliers'] = count($all_rows_supplier);
$data['retailers'] = count($all_rows_retailer);



sendJson(
    200,
    "",
    (array('data'=> $data))
);
