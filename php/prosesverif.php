<?php
include 'koneksi.php';

$email = $_POST['email'];
$sql = "UPDATE `user` SET `status` = '1' WHERE `user`.`email` = '$email';";
$res = mysqli_query($conn, $sql);
if($res){
    echo "selamat akun anda telah terverifikasi";
} else {
    echo "akun anda gagal untuk terverifikasi";
}
