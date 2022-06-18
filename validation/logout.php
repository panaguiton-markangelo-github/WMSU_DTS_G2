<?php
session_start();
if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: ../index.php?new=login");
    exit();
}
?>