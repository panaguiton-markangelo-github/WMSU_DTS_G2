<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create New Password</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../assets/img/wmsu_logo.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../assets/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../assets/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/loading.css">
	<script src="assets/js/sweet_alert.js"></script>
<!--===============================================================================================-->
</head>
<body>
    <div id="preloader">
    </div>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

                <?php

                $selector = $_GET['selector'];
                $validator = $_GET['validator'];

                if (empty($selector) || empty($validator)){
                    echo "could not validate your request!";
                }
                else {
                    if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ){
                    ?>

                        <form class="login100-form validate-form" method="POST" action="../include/reset-password.php">
                            <input type="hidden" name="selector" value="<?php echo $selector;?>">
                            <input type="hidden" name="validator" value="<?php echo $validator;?>">

                            <span class="login100-form-title p-b-26">
                                Create New Password
                            </span>
                            <span class="login100-form-title p-b-48">
                                <img src="../assets/img/wmsu_logo.png" width="60px" height="60px" alt="logo">
                            </span>

                            <div class="wrap-input100 validate-input" data-validate = "Password">
                                <input class="input100" type="password" name="pwd">
                                <span class="focus-input100" data-placeholder="Enter your new password:"></span>
                            </div>

                            <div class="wrap-input100 validate-input" data-validate = "Password">
                                <input class="input100" type="password" name="pwd-rep">
                                <span class="focus-input100" data-placeholder="Confirm your new password:"></span>
                            </div>
                    

                            <div class="container-login100-form-btn">
                                <div class="wrap-login100-form-btn">
                                    <div class="login100-form-bgbtn"></div>
                                    <button type="submit" name="reset-submit" class="login100-form-btn">
                                        Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>

                    <?php
                    }
                }
                ?>
				
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>

    <script>
        var loader =  document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
	</script>
	
<!--===============================================================================================-->
	<script src="../assets/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/vendor/bootstrap/js/popper.js"></script>
	<script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="../assets/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="../assets/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../assets/js/main.js"></script>

</body>
</html>