<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login WMSU|DTS</title>
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/loading.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="assets/js/sweet_alert.js"></script>
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
						<input type="text" placeholder="E-mail" name="username" >
						<input type="password" placeholder="Password" name="password">
						<div class="remember-form">
						<input type="checkbox">
						<span>Remember me</span>
						</div>
						<div class="forget-pass">
						<a href="#">Forgot Password ?</a>
						</div>
						<button type="submit">LOG-IN</button>
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
						text: 'Email or Password does not match our records!',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
		}
	
		else if($_GET['invalid'] == "email") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Ooppss...',
						text: 'Please enter a valid email!!',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
		}
	}
	else if (isset($_GET['empty'])) {
		if($_GET['empty'] == "both") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Ooppss...',
						text: 'Empty Fields!!',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
		}
	
		else if($_GET['empty'] == "email") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Ooppss...',
						text: 'email field cannot be empty!',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
		}

		else if($_GET['empty'] == "pass") {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Ooppss...',
						text: 'password field cannot be empty!',
						showConfirmButton: true,
						allowOutsideClick: false
					});
				</script>
			<?php
		}

	}
		
	?>

	  <script>
		  var loader =  document.getElementById("preloader");
		  window.addEventListener("load", function(){
			  loader.style.display = "none";
		  })
	  </script>

	  <?php include('validation/process_login.php');?>

	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
