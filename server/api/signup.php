<?php
session_start();

require_once("helper.php");


    if (
        !isset($_POST['code']) ||
        !isset($_POST['company']) ||
        !isset($_POST['product']) ||
        !isset($_POST['fname']) ||
        !isset($_POST['lname']) ||
        !isset($_POST['email']) ||
        !isset($_POST['password']) ||
        !isset($_POST['confirm_password']) ||
        empty(trim($_POST['code'])) ||
        empty(trim($_POST['company'])) ||
        empty(trim($_POST['product'])) ||
        empty(trim($_POST['fname'])) ||
        empty(trim($_POST['lname'])) ||
        empty(trim($_POST['email'])) ||
        empty(trim($_POST['password']))||
        empty(trim($_POST['confirm_password']))
    ):
        sendJson(
            422,
            'Please fill all the required fields',
        );
    endif;


    $subscription_code = mysqli_real_escape_string($connection, $_POST['code']);
    $subscribe_product = mysqli_real_escape_string($connection, $_POST['product']);
    $subscribe_company_name = mysqli_real_escape_string($connection, $_POST['company']);
    $admin_full_name = mysqli_real_escape_string($connection, $_POST['fname'] . " " . $_POST['lname']);
    $subscribe_email = mysqli_real_escape_string($connection, $_POST['email']);
    $subscribe_password = mysqli_real_escape_string($connection, $_POST['password']);
    $subscribe_confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

    $messages = [];
    $success = false;

    $check_fields = ['subscription_code' => 'Subscription Code', 'admin_full_name' => 'Admin Full Name', 'subscribe_email' => 'Subscription Email', 'subscribe_password' => 'Password', 'subscribe_confirm_password' => 'Confirm Password'];

    foreach ($check_fields as $key => $value) {
        if (empty(${$key})) {
            sendJson(422, $value . ' is empty');
        }
    }

    if ($subscribe_password != $subscribe_confirm_password) {
        sendJson(422, $value . ' Password and Confirm Password does not match');
    }

    //Check if email already registered or not
    $query = "SELECT * from user_login where user_email = '$subscribe_email'";

    $email_exists = $connection->query($query);

    if ($email_exists != false && $email_exists->num_rows > 0) {
        sendJson(
            422,
            'Email already exists!'
        );
    } else {

        $query = "INSERT INTO user_login(user_email,user_password)  ";
        $query .= "VALUES('$subscribe_email','$subscribe_password')";
        $login_query = mysqli_query($connection, $query);
        $user_id = mysqli_insert_id($connection);
        if ($login_query) {
            $query = "INSERT INTO subscription_code_register(user_id,subscription_code,subscribe_product,subscribe_company_name,admin_full_name)  ";
            $query .= "VALUES($user_id, $subscription_code,'$subscribe_product','$subscribe_company_name','$admin_full_name')";

            $subscribe_register_query = mysqli_query($connection, $query);
            if (!$subscribe_register_query) {
                sendJson(
                    422,
                    'Something went wrong. Plaease, try again later!'
                );
            } else {
                sendJson(
                    200,
                    'Registration Successful!'
                );
            }
        } else {
            sendJson(
                422,
                'Something went wrong. Plaease, try again later!'
            );
        }
    }









?>