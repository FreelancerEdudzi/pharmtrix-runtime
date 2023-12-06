<?php
session_start();

require_once("helper.php");

if(
    !isset($_POST['email']) ||
    !isset($_POST['password']) ||
    empty(trim($_POST['email'])) ||
    empty(trim($_POST['password']))
):
    sendJson(
        422,
        'Please fill all the required fields',
        ['required_fields' => ['email', 'password']]
    );
endif;

$user_email = $_POST['email'];
$user_password = $_POST['password'];
$user_email = mysqli_real_escape_string($connection, $user_email);
$user_password = mysqli_real_escape_string($connection, $user_password);

$query = "SELECT * FROM user_login WHERE user_email = '$user_email' ";
$login_query = mysqli_query($connection, $query);

if(!$login_query) {
    sendJson(
        422,
        'Something went wrong. Plaease, try again later!'
    );
}

while($row = mysqli_fetch_array($login_query)) {
    $db_user_id = $row['user_id'];
    $db_user_email = $row['user_email'];
    $db_user_password = $row['user_password'];
    $db_user_role = $row['user_role'];
}

if(isset($db_user_id)) {
    $query = "SELECT * FROM login_logs where user_id=".$db_user_id;
    $logs_query = mysqli_query($connection, $query);

    $all_rows = mysqli_num_rows($logs_query);

    if($all_rows >= 3) {
        sendJson(
            401,
            'Maximum login attempts exceeded! Please reset your password!'
        );
    }

}
if((isset($db_user_email) && $user_email !== $db_user_email) || (isset($db_user_password) && $user_password !== $db_user_password)) {
    if($user_password !== $db_user_password) {
        $ip = getenv('HTTP_CLIENT_IP') ?:
            getenv('HTTP_X_FORWARDED_FOR') ?:
            getenv('HTTP_X_FORWARDED') ?:
            getenv('HTTP_FORWARDED_FOR') ?:
            getenv('HTTP_FORWARDED') ?:
            getenv('REMOTE_ADDR');
        $query = "INSERT INTO `login_logs`(`user_id`, `ip_address`, `try_time`)  ";
        $date = date('m/d/Y h:i:s a', time());
        $query .= "VALUES($db_user_id, '".$ip."','".$date."')";

        mysqli_query($connection, $query);
    }
    sendJson(
        401,
        'Email or Password is incorrect'
    );
} elseif(isset($db_user_email) && $user_email === $db_user_email && $user_password === $db_user_password) {
    $query = "DELETE FROM `login_logs` where user_id = ".$db_user_id;
    mysqli_query($connection, $query);

    sendJson(200, '', [
        'token' => encodeToken($db_user_id)
    ]);

}

sendJson(
    401,
    'Email or Password is incorrect'
);




















?>