<?php
session_start();

if(isset($_POST['reset-submit'])) {
    $pass = $_POST['pwd'];
    $pass_rep = $_POST['pwd-rep'];
    $id = $_POST['id'];

    if (empty($pass) || empty($pass_rep)){
        $_SESSION['message_fail'] = "password fields are empty!";
        header("location: ../index.php?newpass=empty");
        exit();
    }
    else if ($pass != $pass_rep) {
        $_SESSION['message_fail'] = "password fields are not equal!";
        header("location: ../index.php?newpass=notmatch");
        exit();
    }

    include ('alt_db.php');

    $sql = "UPDATE users SET password = ? WHERE id = ?;";

    $stmt = mysqli_stmt_init($data);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "there was an error!";
        exit();
    }
    else {
        $new_pwd_hash = password_hash($pass, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ss", $new_pwd_hash, $id);
        mysqli_stmt_execute($stmt);

        $_SESSION['upd_mess'] = "Super admin password has been successfully changed!";
        header("location: ../index.php?newpass=success");
        exit();
    }


}
else{
    header("location: ../index.php");
}