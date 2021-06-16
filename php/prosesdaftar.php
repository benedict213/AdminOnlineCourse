<?php
include 'koneksi.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

if (isset($_POST['btnsignup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmation = $_POST['repassword'];
    $nama = $_POST['nama'];


    $sql1 = "SELECT * FROM `user` WHERE `email`= '$email'";
    $res1 = mysqli_query($conn, $sql1);
    if ($res1) {
        $row1 = mysqli_num_rows($res1);
        if ($row1 < 1) {
           


            if ($password == $confirmation) {
                $sql = "insert into user (`nama`,`email`,`password`) VALUES ('" . $nama . "','" . $email . "','" . md5($password) . "')";
                $res = mysqli_query($conn, $sql);
                if ($res) {
                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'sentimenben@gmail.com';                     //SMTP username
                        $mail->Password   = '260506Ben';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                        //Recipients
                        $mail->setFrom('sentimenben@gmail.com', 'adminben');
                        $mail->addAddress($email, $nama);     //Add a recipient
                        //Name is optional




                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Here is the subject';
                        $mail->Body    = '<!DOCTYPE html>
                        <html lang="en">
                        
                        <head>
                            <meta charset="UTF-8">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Verificatione</title>
                        </head>
                        
                        <body>
                            <center>
                                <h1>Verification <h1>
                                <label for=>"Klik tombol dibawah ini untuk verifikasi"</label>
                                <br>
                                <form action="http://localhost/AdminOnlineSchool/php/prosesverif.php" target="_BLANK" method="post">
                                 <label for="">Your Email : </label>
                                 <input type="text" name="email" value="'.$email.'" readonly>
                                 <br>
                                <button type="submit" >Click Here</button>
                                </form>
                                
                            </center>
                        
                        </body>
                        
                        </html>';

                        $mail->send();
                        echo 'Message has been sent';
                        $message = "Success";
                        echo '<script>
                        window.location = "../login.php?message='.$message.'";
                    </script> ';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            } else {
                $message = "Password and confirmation isn't the same";
                header('Location: ../register.php?message=' . $message);
            }
        } else {
            $message = "The email has been used";
            header('Location:../register.php?message=' . $message);
        }
    }
}
