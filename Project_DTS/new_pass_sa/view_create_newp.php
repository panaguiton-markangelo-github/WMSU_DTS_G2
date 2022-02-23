<!DOCTYPE html>
<html lang="en">
<head>
	<title>Change password</title>
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
	<script src="assets/js/sweet_alert.js"></script>
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

            <form class="login100-form validate-form" method="POST" action="../include/new-sa-pwd.php">

                <span class="login100-form-title p-b-26">
                    New password for super admin
                </span>
                <span class="login100-form-title p-b-48">
                    <img src="../assets/img/wmsu_logo.png" width="60px" height="60px" alt="logo">
                </span>

                <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">

                <div class="wrap-input100 validate-input" data-validate = "Password">
                    <input class="input100" type="password" name="pwd">
                    <span class="focus-input100" data-placeholder="Enter your new password:"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Password">
                    <input class="input100" type="password" name="pwd-rep">
                    <span class="focus-input100" data-placeholder="Confirm your new password:"></span>
                </div>
        
                <p style="text-align:center;"><a href="../index.php">Go back to login page.</a></p>
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button type="submit" name="reset-submit" class="login100-form-btn">
                            Reset Password
                        </button>
                    </div>
                </div>
                <br>
                <p style="text-align:center;">Note: You have been redirected here, because the password is set to default. Please change your password.</p>
            </form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
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