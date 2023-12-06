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


    $supplier_code = (int)mysqli_real_escape_string($connection, $_POST['code']);
    $supplier_name = mysqli_real_escape_string($connection, $_POST['name']);
    $supplier_location = mysqli_real_escape_string($connection, $_POST['location']);
    $supplier_city = mysqli_real_escape_string($connection, $_POST['city']);
    $supplier_address = mysqli_real_escape_string($connection, $_POST['address']);
    $supplier_phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $supplier_email = mysqli_real_escape_string($connection, $_POST['email']);
    $supplier_registered_date = mysqli_real_escape_string($connection, $_POST['regdate']);
    $supplier_user = mysqli_real_escape_string($connection, $_POST['user']);


    $check_fields = ['supplier_code' => 'Subscription code', 'supplier_name' => 'Name', 'supplier_location' => 'Location', 'supplier_city' => 'City', 'supplier_address' => 'Address', 'supplier_phone' => 'Phone', 'supplier_email' => 'Email', 'supplier_registered_date' => 'Registration Date', 'supplier_user' => 'Username'];

    foreach ($check_fields as $key => $value) {
        if (empty(${$key})) {
            sendJson(422, $value . ' is empty');
        }
    }



    $query = "INSERT INTO pharmtrixr_supplier(`subscription_code`, `supplier_email`, `supplier_name`, `supplier_city`, `supplier_phone`, `supplier_address`, `supplier_registered_date`, `supplier_user`, `supplier_location`, `supplier_status`,`user_id`)  ";
    $query .= "VALUES($supplier_code, '$supplier_email','$supplier_name','$supplier_city','$supplier_phone','$supplier_address','$supplier_registered_date','$supplier_user','$supplier_location',1,$user_id)";

    $supplier_query = mysqli_query($connection, $query);
    if (!$supplier_query) {
        sendJson(
            422,
            'Something went wrong. Plaease, try again later!'
        );
    } else {
        sendJson(
            200,
            'Supplier Added Successfully!'
        );
    }