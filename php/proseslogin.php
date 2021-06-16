<?php
include 'koneksi.php';

if (isset($_POST['btnlogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    if (preg_match('/^[A-Za-z0-9@.]*$/', $email) && preg_match('/^[A-Za-z0-9]*$/', $password)) {
        $sql = "SELECT * FROM `user` WHERE `email`= '$email' AND `password` = md5('$password') ";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            $row = mysqli_num_rows($res);
            if ($row > 0) {
                $rows = mysqli_fetch_array($res);
                session_start();

                $_SESSION['nama'] = $rows['nama'];
                $_SESSION['email'] = $rows['email'];
                $_SESSION['id_user'] = $rows['id_user'];
                $_SESSION['status'] = $rows['status'];

                header('Location: ../index.php');
            } else {
                header('Location: ../login.php?return=emailOrPasswordIncorrect');
            }
        } else {
            header('Location: ../login.php?return=querygagal');
        }
    } else {
        header("Location: ../login.php?return=loginincorect");
    }
}
