<?php
session_start();

include_once(__DIR__. "/../../helper.php");


$user_id = useMiddleware();

$query = "SELECT * FROM pharmtrix_w_user where created_by=". $user_id ;
if (isset($_POST['user_id'])){
    $query .= ' and pharmtrixw_user_id='.$_POST['user_id'];
}
$user_query = mysqli_query($connection, $query);

$all_rows = mysqli_fetch_all($user_query, MYSQLI_ASSOC);

sendJson(
    200,
    "",
    (array('data'=> $all_rows))
);
