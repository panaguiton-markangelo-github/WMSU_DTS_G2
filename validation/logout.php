<?php
session_start();
if(isset($_POST['logout'])) {
    session_unset();
    session_abort();
    session_destroy();
    header("Cache-Control", "no-cache, no-store, must-revalidate");
    header("location: ../index.php?new=login");
    exit();
}
?>