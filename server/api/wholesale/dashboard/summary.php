<?php
session_start();

include_once(__DIR__. "/../../helper.php");


$user_id = useMiddleware();

$data=[
    'suppliers'=>0,
    'retailers' => 0
];

$query = "SELECT * FROM pharmtrixw_supplier where user_id=". $user_id ;
$suppliers_query = mysqli_query($connection, $query);

$all_rows_supplier = mysqli_fetch_all($suppliers_query, MYSQLI_ASSOC);

$query = "SELECT * FROM pharmtrixw_retailer where user_id=". $user_id ;
$retailers_query = mysqli_query($connection, $query);

$all_rows_retailer = mysqli_fetch_all($retailers_query, MYSQLI_ASSOC);


$query = "SELECT * FROM pharmtrix_w_user where created_by=". $user_id ;
$users_query = mysqli_query($connection, $query);

$all_rows_user = mysqli_fetch_all($users_query, MYSQLI_ASSOC);



$data['suppliers'] = count($all_rows_supplier);
$data['retailers'] = count($all_rows_retailer);
$data['users'] = count($all_rows_user);



sendJson(
    200,
    "",
    (array('data'=> $data))
);
