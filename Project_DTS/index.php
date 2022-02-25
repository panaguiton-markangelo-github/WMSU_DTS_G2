<?php include('validation/process_login.php');?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login WMSU|DTS</title>
	<!-- Custom Stylesheet -->
	<link rel="icon" type="image/png" href="assets/img/wmsu_logo.png"/>
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/loading.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="assets/js/sweet_alert.js"></script>
	<script src="assets/js/show_pass.js"></script>
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
	<div id="preloader">
	</div>

	<div class="parent clearfix">
		<div class="bg-illustration">
		  <div class="burger-btn">
			<span></span>
			<span></span>
			<span></span>
		  </div>
		</div>
		
		<div class="login">
			<div class="container">
				<h1>LOGIN TO YOUR ACCOUNT <br> <img src="./assets/img/wmsu_logo.png" alt="logo" width="55px" height="55px"> WMSU|DTS</h1>
		
				<div class="login-form">
					<img src="./assets/img/login_logo_un1.svg" alt="logo">
					<form action="?login" method="POST">
						<input type="text" placeholder="E-mail" name="username" class="email" >
						<input type="password" placeholder="Password" name="password" id="pass" class="pass">																
						<div class="remember-form">
						<input type="checkbox" class="show" onclick="myFunction()">
						<span>Show password</span>
						</div>
						<div class="forget-pass">
							<a href="forgot_pass/forgot-pass.php">Forgot Password?</a>
						</div>
						<button class="login_but" type="submit">LOG-IN</button>
			  		</form>
					
				</div>
			</div>
		</div>
	</div>

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

	//almost done!
	//integrate the report module to the clerk/admin users module.
	//then done^^.
	//afterwards, don't forget to push the changes into github^^.
	//byefornow
		
	?>
	  <script>
		  var loader =  document.getElementById("preloader");
		  window.addEventListener("load", function(){
			  loader.style.display = "none";
		  })
	  </script>

	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
