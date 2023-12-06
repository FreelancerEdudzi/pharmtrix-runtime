<?php
session_start();

include_once(__DIR__. "/../../helper.php");

$user_id = useMiddleware();

  


    $retailer_id = (int)mysqli_real_escape_string($connection, $_POST['retailer_id']);
    $retailer_name = mysqli_real_escape_string($connection, $_POST['name']);
    $retailer_location = mysqli_real_escape_string($connection, $_POST['location']);
    $retailer_city = mysqli_real_escape_string($connection, $_POST['city']);
    $retailer_address = mysqli_real_escape_string($connection, $_POST['address']);
    $retailer_phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $retailer_email = mysqli_real_escape_string($connection, $_POST['email']);

    $check_fields = ['retailer_id'=>'retailer Id', 'retailer_name' => 'Name', 'retailer_location' => 'Location', 'retailer_city' => 'City', 'retailer_address' => 'Address', 'retailer_phone' => 'Phone', 'retailer_email' => 'Email'];

    foreach ($check_fields as $key => $value) {
        if (empty(${$key})) {
            sendJson(422, $value . ' is empty');
        }
    }



    $query = "UPDATE `pharmtrixw_retailer` SET `retailer_email`='$retailer_email',`retailer_name`='$retailer_name',`retailer_city`='$retailer_city',`retailer_phone`='$retailer_phone',`retailer_address`='$retailer_address',`retailer_location`='$retailer_location' WHERE pharmtrixw_retailer_id = $retailer_id";

    $retailer_query = mysqli_query($connection, $query);
    if (!$retailer_query) {
        sendJson(
            422,
            'Something went wrong. Plaease, try again later!'
        );
    } else {
        sendJson(
            200,
            'Retailer Updated Successfully!'
        );
    }