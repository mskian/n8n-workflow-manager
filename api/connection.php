<?php

include '../class/store.php';
(new DevCoder\DotEnv('../.env'))->load();

$db_host = getenv('DBHOST');
$db_name = getenv('DBNAME');
$db_username = getenv('DBUSERNAME');
$db_password = getenv('DBPASSWORD');
        
try {
        $conn = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_username,$db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    catch(PDOException $e) {
        echo "Connection error ".$e->getMessage(); 
        exit;
    }

?>