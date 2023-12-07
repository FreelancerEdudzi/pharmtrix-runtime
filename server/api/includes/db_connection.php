<?php

$db['db_host'] = 'localhost';
$db['db_user'] = 'if0_35572464';
$db['db_pass'] = 'zakir%%$';
$db['db_name'] = 'if0_35572464_ntubed_global_db';


foreach($db as $key => $value){
    
   define(strtoupper($key),$value); 
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(!$connection){
    die("Database query failed" . mysqli_error($connection));
}
?>