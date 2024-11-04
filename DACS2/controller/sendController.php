<?php
    session_start();    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
?>

<head>
    <link rel="stylesheet" href="../view/css/errorMessage.css">
</head>
<body>
<?php

    if(isset($_POST['verification'])){
        $otp_digit1 = $_POST['otp_digit1'];
        $otp_digit2 = $_POST['otp_digit2'];
        $otp_digit3 = $_POST['otp_digit3'];
        $otp_digit4 = $_POST['otp_digit4'];

        $userCode = $otp_digit1.$otp_digit2.$otp_digit3.$otp_digit4;

        if($_SESSION['verification_code'] == $userCode && time() <= $_SESSION['verification_code_expire']){
            header('Location ../index.php');
            exit();
        }else{
            echo "<div class= 'message'>
                <p>";
                    echo "Mã xác minh không hợp lệ hoặc đã hết hạn.";
                    echo "<button onclick='history.back()' class='btn'>Go Back</button>";
            echo "</p>
                </div>";
        }

    }

    function sendVerification($verificationCode, $toEmail){
            $mail = new PHPMailer(true); 
            $mail->CharSet = 'UTF-8'; 

        try {

            // Cấu hình Server
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'doanvanduy0702@gmail.com';
            $mail->Password = 'egwuwxcbbvasnktw';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // users setting
            $mail->setFrom('doanvanduy0702@gmail.com', 'sender');
            $mail->addAddress($toEmail, 'receiver');
            //$mail->addReplyTo('info@example.com', 'Information'); // Địa chỉ để phản hồi
            //$mail->addCC('cc@example.com'); // Thêm địa chỉ CC
            //$mail->addBCC('bcc@example.com'); // Thêm địa chỉ BCC

            $mail->isHTML(true);
            $mail->Subject = 'Mã xác nhận của bạn';
            $mail->Body = 'Mã xác nhận của bạn là : <b>' . $verificationCode . '</b>. Mã này có hiệu lực trong 60 giây.';
            $mail->AltBody = 'Mã xác nhận của bạn là : ' . $verificationCode . '. Mã này có hiệu lực trong 60 giây.';


            $mail->send();
            return true;
        
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}"); 

            return false;
        }
    }

?>
   
</body>
</html>

