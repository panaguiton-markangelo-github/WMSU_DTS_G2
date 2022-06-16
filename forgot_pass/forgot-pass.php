<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Forgot Password</title>
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
	<script src="../assets/js/sweet_alert.js"></script>
<!--===============================================================================================-->
</head>
<body>
	<div id="preloader">
    </div>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="../include/forgot-pass-reset.php">
					<span class="login100-form-title p-b-26">
						Forgot Password
					</span>
					<span class="login100-form-title p-b-48">
						<img src="../assets/img/wmsu_logo.png" width="60px" height="60px" alt="logo">
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="text" name="email">
						<span class="focus-input100" data-placeholder="Enter your e-mail:"></span>
					</div>

					<p style="text-align:center;">Instruction will be sent to your email, on how to reset your password.</p>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" name="reset-submit" class="login100-form-btn">
								Send recovery instruction
							</button>
						</div>
					</div>

					<div class="text-center p-t-115">
						<span class="txt1">
							Remember password?
						</span>

						<a class="txt2" href="../index.php">
							Login
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>

	<?php
	if(isset($_GET['reset'])) {
		if($_GET['reset'] == "success") {
			?>
				<script>
					Swal.fire({
						icon: 'success',
						title: 'Successful!',
						html: '<p><?php echo $_SESSION['message_succ'] ?></p>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php

			unset($_SESSION['message_succ']);
		}

		else if($_GET['reset'] == "failed") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Error!',
						html: '<p><?php echo $_SESSION['message_mail_fail'] ?></p>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php

			unset($_SESSION['message_mail_fail']);
		}
	}

	elseif(isset($_GET['newpass'])) {
		if($_GET['newpass'] == "empty") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Failed!',
						html: '<p><?php echo $_SESSION['message_fail'] ?></p>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php

			unset($_SESSION['message_fail']);
		}

		else if($_GET['newpass'] == "notequal") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Failed!',
						html: '<p><?php echo $_SESSION['message_fail'] ?></p>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php

			unset($_SESSION['message_fail']);
		}
	}
	elseif(isset($_GET['user'])) {
		if($_GET['user'] == "notexist") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Failed!',
						html: '<p><?php echo $_SESSION['message_fail'] ?></p>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php

			unset($_SESSION['message_fail']);
		}
	}
	elseif(isset($_GET['error'])) {
		if($_GET['error'] == "true") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Failed!',
						html: '<p><?php echo $_SESSION['message_fail'] ?></p>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php

			unset($_SESSION['message_fail']);
		}
	}
	?>

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