<?php
session_start();

include_once(__DIR__. "/../../helper.php");

$user_id = useMiddleware();

    // if (
    //     !isset($_POST['code']) ||
    //     !isset($_POST['name']) ||
    //     !isset($_POST['location']) ||
    //     !isset($_POST['city']) ||
    //     !isset($_POST['address']) ||
    //     !isset($_POST['phone']) ||
    //     !isset($_POST['email']) ||
    //     !isset($_POST['regdate']) ||
    //     !isset($_POST['user']) ||
    //     empty(trim($_POST['code'])) ||
    //     empty(trim($_POST['name'])) ||
    //     empty(trim($_POST['location'])) ||
    //     empty(trim($_POST['city'])) ||
    //     empty(trim($_POST['address'])) ||
    //     empty(trim($_POST['phone'])) ||
    //     empty(trim($_POST['email'])) ||
    //     empty(trim($_POST['regdate'])) ||
    //     empty(trim($_POST['user'])) 
    // ):
    //     sendJson(
    //         422,
    //         'Please fill all the required fields',
    //     );
    // endif;


    $retailer_code = (int)mysqli_real_escape_string($connection, $_POST['code']);
    $retailer_name = mysqli_real_escape_string($connection, $_POST['name']);
    $retailer_location = mysqli_real_escape_string($connection, $_POST['location']);
    $retailer_city = mysqli_real_escape_string($connection, $_POST['city']);
    $retailer_address = mysqli_real_escape_string($connection, $_POST['address']);
    $retailer_phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $retailer_email = mysqli_real_escape_string($connection, $_POST['email']);
    $retailer_registered_date = mysqli_real_escape_string($connection, $_POST['regdate']);
    $retailer_user = mysqli_real_escape_string($connection, $_POST['user']);


    $check_fields = ['retailer_code' => 'Subscription code', 'retailer_name' => 'Name', 'retailer_location' => 'Location', 'retailer_city' => 'City', 'retailer_address' => 'Address', 'retailer_phone' => 'Phone', 'retailer_email' => 'Email', 'retailer_registered_date' => 'Registration Date', 'retailer_user' => 'Username'];

    foreach ($check_fields as $key => $value) {
        if (empty(${$key})) {
            sendJson(422, $value . ' is empty');
        }
    }



    $query = "INSERT INTO pharmtrixw_retailer(`subscription_code`, `retailer_email`, `retailer_name`, `retailer_city`, `retailer_phone`, `retailer_address`, `retailer_registered_date`, `retailer_user`, `retailer_location`, `retailer_status`,`user_id`)  ";
    $query .= "VALUES($retailer_code, '$retailer_email','$retailer_name','$retailer_city','$retailer_phone','$retailer_address','$retailer_registered_date','$retailer_user','$retailer_location',1,$user_id)";

    $retailer_query = mysqli_query($connection, $query);
    if (!$retailer_query) {
        sendJson(
            422,
            'Something went wrong. Plaease, try again later!'
        );
    } else {
        sendJson(
            200,
            'Retailer Added Successfully!'
        );
    }