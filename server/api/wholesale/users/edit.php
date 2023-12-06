<?php
session_start();

include_once(__DIR__. "/../../helper.php");

$user_id = useMiddleware();


    $selected_user_id = (int)mysqli_real_escape_string($connection, $_POST['user_id']);
    $user_email = mysqli_real_escape_string($connection, $_POST['email']);
    $user_fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
    $user_title = mysqli_real_escape_string($connection, $_POST['title']);
    $user_role = mysqli_real_escape_string($connection, $_POST['role']);
    $user_username = mysqli_real_escape_string($connection, $_POST['username']);
    $user_phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $user_password = mysqli_real_escape_string($connection, $_POST['password']);
    $user_access = mysqli_real_escape_string($connection, $_POST['access']);
    $user_regDate = mysqli_real_escape_string($connection, $_POST['regDate']);
    $user_registrar = mysqli_real_escape_string($connection, $_POST['registrar']);
    $user_status = (int)(bool)mysqli_real_escape_string($connection, $_POST['status']);


    $check_fields = [
        'selected_user_id' => 'User Id',
        'user_email' => 'Email', 
        'user_fullname' => 'User\'s Fullname', 
        'user_title' => 'Title', 
        'user_role' => 'Role', 
        'user_username' => 'User\'s Username', 
        'user_phone' => 'Phone', 
        'user_password' => 'Password', 
        'user_access' => 'User Access', 
        'user_regDate' => 'Registration Date', 
        'user_registrar' => 'Registrar', 
    ];

    foreach ($check_fields as $key => $value) {
        if (empty(${$key})) {
            sendJson(422, $value . ' is empty');
        }
    }

    $query = "UPDATE `pharmtrix_w_user` SET `first_name`='$user_fullname',`wholesale_user_title`='$user_title',`wholesale_user_role`='$user_role',`wholesale_username`='$user_username',`wholesale_user_password`='$user_password',`wholesale_user_email`='$user_email',`wholesale_user_phone`='$user_phone',`wholesale_user_access`='$user_access',";
    $query .="`wholesale_dated`='$user_regDate',`wholesale_user_registrar`='$user_registrar',`wholesale_user_status`=$user_status where `pharmtrixw_user_id`= $selected_user_id";


    $user_query = mysqli_query($connection, $query);
    if (!$user_query) {
        sendJson(
            422,
            'Something went wrong. Plaease, try again later!'
        );
    } else {
        sendJson(
            200,
            'User Updated Successfully!'
        );
    }