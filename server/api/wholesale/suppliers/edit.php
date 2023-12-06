<?php
session_start();

include_once(__DIR__. "/../../helper.php");

$user_id = useMiddleware();

  


    $supplier_id = (int)mysqli_real_escape_string($connection, $_POST['supplier_id']);
    $supplier_name = mysqli_real_escape_string($connection, $_POST['name']);
    $supplier_location = mysqli_real_escape_string($connection, $_POST['location']);
    $supplier_city = mysqli_real_escape_string($connection, $_POST['city']);
    $supplier_address = mysqli_real_escape_string($connection, $_POST['address']);
    $supplier_phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $supplier_email = mysqli_real_escape_string($connection, $_POST['email']);

    $check_fields = ['supplier_id'=>'Supplier Id', 'supplier_name' => 'Name', 'supplier_location' => 'Location', 'supplier_city' => 'City', 'supplier_address' => 'Address', 'supplier_phone' => 'Phone', 'supplier_email' => 'Email'];

    foreach ($check_fields as $key => $value) {
        if (empty(${$key})) {
            sendJson(422, $value . ' is empty');
        }
    }



    $query = "UPDATE `pharmtrixw_supplier` SET `supplier_email`='$supplier_email',`supplier_name`='$supplier_name',`supplier_city`='$supplier_city',`supplier_phone`='$supplier_phone',`supplier_address`='$supplier_address',`supplier_location`='$supplier_location' WHERE pharmtrixw_supplier_id = $supplier_id";

    $supplier_query = mysqli_query($connection, $query);
    if (!$supplier_query) {
        sendJson(
            422,
            'Something went wrong. Plaease, try again later!'
        );
    } else {
        sendJson(
            200,
            'Supplier Updated Successfully!'
        );
    }