<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require '../phpmailer/includes/mailer_main.php';


if (isset($_POST['reset-submit'])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "dts.wmsuccs.com/forgot_pass/create-new-pass.php?selector=" . $selector . "&validator=". bin2hex($token);

    $expires = date("U") + 1800;

    include ('database.php');
    include ('alt_db.php');

    $userEmail = $_POST['email'];

    $sql = "SELECT * FROM users WHERE username = ?;";

    $stmt = mysqli_stmt_init($data);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        $_SESSION['message_fail'] = "Unexpected error occured1!";
        header("location: ../forgot_pass/forgot-pass.php?error=true");
        exit();
    }
    else {

        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (!$row = mysqli_fetch_assoc($result)) {
            $_SESSION['message_fail'] = "User does not exist!";
            header("location: ../forgot_pass/forgot-pass.php?user=notexist");
            exit();
        }

        else
        {
            $database = new Connection();
            $db = $database->open();


            try {
                $sql = $db->prepare("DELETE FROM pwdReset WHERE pwdResetEmail = :email;");
            
                //binding of values
                $sql->bindParam(':email', $userEmail);
                

                //sql execute
                $sql->execute();
            }
            catch (PDOException $e) {
                $_SESSION['message_fail'] = $e->getMessage();
                exit();

            }

            try {
                $sql = $db->prepare("INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpire) VALUES (:email, :selector, :token, :expires);");
                
                $hasked_token = password_hash($token, PASSWORD_DEFAULT);

                //binding of values
                $sql->bindParam(':email', $userEmail);
                $sql->bindParam(':selector', $selector);
                $sql->bindParam(':token', $hasked_token);
                $sql->bindParam(':expires', $expires);
                
                //sql execute
                $sql->execute();
            }
            catch (PDOException $e) {
                $_SESSION['message_fail'] = $e->getMessage();
                exit();
            }

            $database->close();

            $to = $userEmail;

            $subject = "Reset your password for WMSU|DTS.";

            $message = "<p> Don't reply here! Hi There! The system received a request of password change. The link to reset your password is below,
                if you did not make this request, please kindly ignore it.</p>";
            $message .= "<p> Here is your reset password link: <br>";
            $message .= "<a href= '".$url."'> ".$url." </a> </p> <br>";

            $message .= "From: WMSU|DTS team <tracking@wmsuccs.com>\r\n";
            $message .= "<br>Reply-To: wmsudts@gmail.com\r\n";
            $message .= "<p>Best regards WMSU|DTS team.</p>";

            $mail->Subject = $subject;
            $mail->setFrom("tracking@wmsuccs.com");
            $mail->isHTML(true);
            $mail->Body = $message;
            $mail->addAddress($to);
           
            if ($mail->Send()) { 
                $_SESSION['message_succ'] = "Instruction on how to reset your password has been sent to your email. <br> Note:Check the inbox/spam tab of your email!";
                header("location: ../forgot_pass/forgot-pass.php?reset=success");
                exit();
            }
            else {
                $_SESSION['message_mail_fail'] = "Unexpected error occured.!";
                header("location: ../forgot_pass/forgot-pass.php?reset=failed".$mail->ErrorInfo);
                exit();
            }

            $mail->smtpClose();
        }
    }

}
else
{
    header("location: ../forgot_pass/forgot-pass.php");
}

?>