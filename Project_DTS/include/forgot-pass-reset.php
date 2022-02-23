<?php

if (isset($_POST['reset-login'])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "wmsu-dts.epizy.com/forgot-pass/create-new-pass.php?selector=" . $selector . "&validator=". bin2hex($token);

    $expires = date("U") + 1800;

    include ('database.php');

    $userEmail = $_POST['email'];

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

    $message = "<p> Hi There! The system received a request of password change. The link to reset your password is below,
        if you did not make this request, please kindly ignore it. Best regards WMSU|DTS team.</p>";
    $message .= "<p> Here is your reset password link: <br>";
    $message .= "<a href= '".$url."'> ".$url." </a> </p>";

    $headers = "From: WMSU|DTS team <wmsudts_noreply@gmail.com>\r\n";
    $headers .= "Reply-To: gt201900139@wmsu.edu.ph\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $headers);

    header("location: ../forgot_pass/forgot-pass.php?reset=success");
}
else
{
    header("location: ../forgot_pass/forgot-pass.php");
}
