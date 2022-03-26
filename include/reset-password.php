<?php

if (isset($_POST['reset-submit'])) {
   
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $pass = $_POST['pwd'];
    $pass_rep = $_POST['pwd-rep'];

    if (empty($pass) || empty($pass_rep)){
        $_SESSION['message_fail'] = "password fields are empty!";
        header("location: ../forgot_pass/forgot-pass.php?newpass=empty");
        exit();
    }
    else if ($pass != $pass_rep) {
        $_SESSION['message_fail'] = "password fields are not equal!";
        header("location: ../forgot_pass/forgot-pass.php?newpass=notequal");
        exit();
    }

    $currentDate = date("U");

    include ('alt_db.php');

    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector = ? AND pwdResetExpire >= ?;";
    $stmt = mysqli_stmt_init($data);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "there was an error!";
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (!$row = mysqli_fetch_assoc($result)) {
            echo "please resubmit your reset request!";
            exit();
        }
        else {
            $token_bin = hex2bin($validator);
            $token_check = password_verify($token_bin,$row['pwdResetToken']);

            if($token_check === false){
                echo "please resubmit your reset request!";
                exit();
            }

            else if ($token_check === true) {

                $token_email = $row['pwdResetEmail'];

                $sql = "SELECT * FROM users WHERE username = ?;";

                $stmt = mysqli_stmt_init($data);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    $_SESSION['message_fail'] = "Unexpected error occured!";
                    header("location: ../forgot_pass/forgot-pass.php?error=true");
                    exit();
                }
                else {

                    mysqli_stmt_bind_param($stmt, "s", $token_email);
                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);

                    if (!$row = mysqli_fetch_assoc($result)) {
                        $_SESSION['message_fail'] = "User does not exist!";
                        header("location: ../forgot_pass/forgot-pass.php?user=notexist");
                        exit();
                    }
                    else {
                        $sql = "UPDATE users SET password = ? WHERE username = ?;";

                        $stmt = mysqli_stmt_init($data);

                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            echo "there was an error!";
                            exit();
                        }
                        else {
                            $new_pwd_hash = password_hash($pass, PASSWORD_DEFAULT);
        
                            mysqli_stmt_bind_param($stmt, "ss", $new_pwd_hash,$token_email);
                            mysqli_stmt_execute($stmt);


                            include ('database.php');
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

                            $database->close();                     
                        }
                        
                        header("location: ../index.php?newpwd=updated");

                    }

                }

            }
        }
    }





}

else{
    header("location: ../forgot_pass/forgot-pass.php");
}