<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, PUT, GET, OPTIONS, DELETE');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Expose-Headers: Authorization");


include_once("includes/db_connection.php");
include_once('includes/sendJson.php');
include_once('includes/jwtHandler.php');


/**************************************************************/
/*                          Dashboard                         */
/**************************************************************/

if (checkPostType('create-payments-accounts')) {
    $user_id = useMiddleware();

    $data = (object) json_decode($_POST['data']);
    if (
        !isset($data->type) ||
        !isset($data->purpose_type) ||
        !isset($data->name) ||
        !isset($data->acc_number) ||
        !isset($data->routing_number) ||
        !isset($data->address) ||
        empty(trim($data->type)) ||
        empty(trim($data->purpose_type)) ||
        empty(trim($data->name)) ||
        empty(trim($data->acc_number)) ||
        empty(trim($data->routing_number)) ||
        empty(trim($data->address)) 
    ):
        sendJson(
            422,
            'Please fill all the required fields',
        );
    endif;


    $payment_account_type = mysqli_real_escape_string($connection, $data->type);
    $payment_account_purpose = mysqli_real_escape_string($connection, $data->purpose_type);
    $payment_account_name = mysqli_real_escape_string($connection, $data->name);
    $payment_routing = mysqli_real_escape_string($connection, $data->routing_number);
    $payment_account_number = mysqli_real_escape_string($connection, $data->acc_number);
    $payment_billing = mysqli_real_escape_string($connection, $data->address);


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

}
