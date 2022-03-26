<?php include('validation/process_login.php');?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login WMSU | DTS</title>
	<!-- Custom Stylesheet -->
	<link rel="icon" type="image/png" href="assets/img/wmsu_logo.png"/>
	<link rel="stylesheet" href="assets/css/style_new.css">
	<link rel="stylesheet" href="assets/css/loading.css">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.css">	
	<link rel="stylesheet" type="text/css" href="assets/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/select2/select2.min.css">	
	<link rel="stylesheet" type="text/css" href="assets/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main_new.css">
	<script src="assets/js/sweet_alert.js"></script>
</head>

<body>
	<div id="preloader">
	</div>

    <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<form class="login100-form validate-form flex-sb flex-w" action="?login" method="POST">
					<span class="login100-form-title p-b-32">
						<img src="assets/img/wmsu_logo.png" width="55px" height="55px">
						WMSU|DTS Login
						<img src="assets/img/login_logo_un1.svg" width="55px" height="55px">
					</span> 

					<span class="txt1 p-b-11">
						Email
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Email required @.c">
						<input class="input100" type="text" name="email">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="password" >
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-b-48">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="forgot_pass/forgot-pass.php" class="txt3">
								Forgot Password?
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="submit">
							LOGIN
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	
	<div id="dropDownSelect1"></div>

	
	<?php
	if(isset($_GET['invalid'])) {
		if($_GET['invalid'] == "match") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Ooppss...',
						text: '<?php echo $_SESSION['invalid_match'] ?>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php

			unset($_SESSION['invalid_match']);
		}
	
		else if($_GET['invalid'] == "email") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Ooppss...',
						text: '<?php echo $_SESSION['invalid_email'] ?>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
			unset($_SESSION['invalid_email']);
		}
	}
	else if (isset($_GET['empty'])) {
		if($_GET['empty'] == "both") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Ooppss...',
						text: '<?php echo $_SESSION['empty_both']?>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
			unset($_SESSION['empty_both']);
		}
	
		else if($_GET['empty'] == "email") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Ooppss...',
						text: '<?php echo $_SESSION['empty_email']?>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
			unset($_SESSION['empty_email']);
		}

		else if($_GET['empty'] == "pass") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Ooppss...',
						text: '<?php echo $_SESSION['empty_pass']?>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
			unset($_SESSION['empty_pass']);
		}

	}

	else if (isset($_GET['newpwd'])) {
		if($_GET['newpwd'] == "updated") {
			?>
				<script>
					Swal.fire({
						icon: 'success',
						title: 'Successful!!',
						text: 'Pasword was updated successfully!',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
			unset($_GET['newpwd']);
		}
	}

	else if (isset($_GET['newpass'])) {
		if($_GET['newpass'] == "success") {
			?>
				<script>
					Swal.fire({
						icon: 'success',
						title: 'Successful!!',
						text: '<?php echo $_SESSION['upd_mess'] ?>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
			unset($_SESSION['upd_mess']);
		}

		else if($_GET['newpass'] == "notmatch") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Password does not match!!!',
						text: '<?php echo $_SESSION['message_fail'] ?>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
			unset($_SESSION['message_fail']);
		}

		else if($_GET['newpass'] == "empty") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Password fields cannot be empty!!!',
						text: '<?php echo $_SESSION['message_fail'] ?>',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
			unset($_SESSION['message_fail']);
		}
	}
	
	//done all major changes.
	//last module which is the notification.	
	?>
	  <script>
		  var loader =  document.getElementById("preloader");
		  window.addEventListener("load", function(){
			  loader.style.display = "none";
		  })
	  </script>

     <script src="assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="assets/vendor/animsition/js/animsition.min.js"></script>
	<script src="assets/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/select2/select2.min.js"></script>
	<script src="assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="assets/vendor/countdowntime/countdowntime.js"></script>
	<script src="assets/js/main_new.js"></script>

</body>
</html>
