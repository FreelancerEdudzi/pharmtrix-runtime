<?php
session_start();

include_once(__DIR__. "/../../../helper.php");


$user_id = useMiddleware();

$query = "SELECT * FROM payment_account where user_id=". $user_id ;
$payment_query = mysqli_query($connection, $query);

$all_rows = mysqli_fetch_all($payment_query, MYSQLI_ASSOC);

sendJson(
    200,
    "",
    (array('data'=> $all_rows))
);
