<?php
session_start();

include_once(__DIR__. "/../../../helper.php");

$user_id = useMiddleware();

    if (
        !isset($_POST['account_id']) 
    ):
        sendJson(
            422,
            'account_id field is required',
        );
    endif;


    $account_id = mysqli_real_escape_string($connection, $_POST['account_id']);




    $query = "DELETE FROM payment_account where payment_account_id = ". $account_id;

    $account_query = mysqli_query($connection, $query);
    if (!$account_query) {
        sendJson(
            422,
            'Something went wrong. Plaease, try again later!'
        );
    } else {
        sendJson(
            200,
            'Payment Account Deleted Successfully!'
        );
    }