<?php
session_start();

include_once(__DIR__. "/../../../helper.php");

$user_id = useMiddleware();

    // if (
    //     !isset($_POST['type']) ||
    //     !isset($_POST['purpose_type']) ||
    //     !isset($_POST['name']) ||
    //     !isset($_POST['acc_number']) ||
    //     !isset($_POST['routing_number']) ||
    //     !isset($_POST['address']) ||
    //     empty(trim($_POST['type'])) ||
    //     empty(trim($_POST['purpose_type'])) ||
    //     empty(trim($_POST['name'])) ||
    //     empty(trim($_POST['acc_number'])) ||
    //     empty(trim($_POST['routing_number'])) ||
    //     empty(trim($_POST['address'])) 
    // ):
    //     sendJson(
    //         422,
    //         'Please fill all the required fields',
    //     );
    // endif;


    $payment_account_type = mysqli_real_escape_string($connection, $_POST['type']);
    $payment_account_purpose = mysqli_real_escape_string($connection, $_POST['purpose_type']);
    $payment_account_name = mysqli_real_escape_string($connection, $_POST['name']);
    $payment_routing = mysqli_real_escape_string($connection, $_POST['routing_number']);
    $payment_account_number = mysqli_real_escape_string($connection, $_POST['acc_number']);
    $payment_billing = mysqli_real_escape_string($connection, $_POST['address']);


    $check_fields = ['payment_account_type' => 'Type', 'payment_account_purpose' => 'Purpose', 'payment_account_name' => 'Holder\'s Name', 'payment_routing' => 'Routing Number', 'payment_billing' => 'Billing', 'payment_account_number' => 'Account Number'];

    foreach ($check_fields as $key => $value) {
        if (empty(${$key})) {
            sendJson(422, $value . ' is empty');
        }
    }



    $query = "INSERT INTO payment_account(payment_account_type,payment_account_purpose,payment_account_name,payment_routing,payment_billing,payment_account_number,user_id)  ";
    $query .= "VALUES('$payment_account_type', '$payment_account_purpose','$payment_account_name','$payment_routing','$payment_billing','$payment_account_number',$user_id)";

    $account_query = mysqli_query($connection, $query);
    if (!$account_query) {
        sendJson(
            422,
            'Something went wrong. Plaease, try again later!'
        );
    } else {
        sendJson(
            200,
            'Payment Account Added Successfully!'
        );
    }