<?php
session_start();
if(!isset($_SESSION["sa_username"]) && !isset($_SESSION["a_username"]) && !isset($_SESSION["c_username"])) 
{
  header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Failed</title>
  <script src="../assets/js/sweet_alert.js"></script>
</head>
<body style="background-color: #8e0413;">
    <?php 
        if(isset($_SESSION['message_fail'])){
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Failed!!',
                    html: '<h4><?php echo $_SESSION['message_fail']?></h4>',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    confirmButtonText: 'OKAY!'
                }).then(function(){
                    window.close();
                });
            </script>
            <?php

            unset($_SESSION['message_fail']);
        }
    ?>
</body>

</html>

