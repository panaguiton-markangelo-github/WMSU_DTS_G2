<?php
session_start();
if(isset($_POST['logout'])) {
    session_abort();
    header("location: ../index.php?new=login");
    exit();
}
?>