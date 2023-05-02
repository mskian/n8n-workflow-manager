<?php

include 'connection.php';

$msg = [];

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('Content-type:application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
header('X-Robots-Tag: noindex, nofollow', true);

if(isset($_GET['user']) && isset($_GET['status'])){
    if(!empty($_GET['user']) && !empty($_GET['status'])){

        $USER = htmlspecialchars($_GET['user'], ENT_COMPAT);
        $API_DATA = htmlspecialchars($_GET['status'], ENT_COMPAT);

        $check_status = "SELECT `status` FROM `n8n` WHERE `status`=:status";
        $check_status_stmt = $conn->prepare($check_status);
        $check_status_stmt->bindValue(':status', $API_DATA,PDO::PARAM_STR);
        $check_status_stmt->execute();

        if($check_status_stmt->rowCount() > 0) {

          $msg['message'] = 'data exist';
          echo json_encode($msg);
  
        } else {

        $sql = $conn->prepare("INSERT INTO n8n (user, status) VALUES (:user, :status) ON DUPLICATE KEY UPDATE user= :user, status= :status");
        $sql->bindParam(':user', $USER, PDO::PARAM_STR);
        $sql->bindParam(':status',$API_DATA, PDO::PARAM_STR);
        if($sql->execute()){
            $msg['message'] = 'Data successfully Stored';
            echo json_encode($msg);
          } else {
            $msg['message'] = 'Data not stored';
            echo json_encode($msg);
          }
        }
    } else {
        $msg['message'] = 'Oops! empty field detected. Please fill all the fields';
        echo json_encode($msg);
      }
    } else {
        $msg['message'] = 'Please fill all the fields';
        echo json_encode($msg);
}

?>