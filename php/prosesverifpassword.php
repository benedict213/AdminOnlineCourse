<?php
include 'koneksi.php';

if (isset($_POST['btnsavepassword'])) {
    $repassword = $_POST['repassword'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if ($password == $repassword) {
        $sql = "UPDATE `user` SET `password` = "."'". md5($password) . "'"." WHERE `user`.`email` = '$email';";
        $res = mysqli_query($conn, $sql);
        if ($res) {
           
          header('Location: ../login.php?return=successpasswordchanged');
        } else {
            header('Location: ../login.php?return=failedchangepassword');

        }
    } else{
       
        header('Location: ../login.php?return=passwordtidaksama');
    }
    
}
