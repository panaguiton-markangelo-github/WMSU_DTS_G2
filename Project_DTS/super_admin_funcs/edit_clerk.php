<?php 
//Alternative Database connection.
$host = "localhost";
$user = "root";
$password = "kookies172001";
$db = "dts_db";

$data = mysqli_connect($host, $user, $password, $db);

if($data === false){
    die("connection error");
}
?>
<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['edit'])){
			$database = new Connection();
			$db = $database->open();

			if (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
				$_SESSION['message_fail'] = "Please enter a valid email!";
				$database->close();
				header('location: ../super_admin/clerk_users.php?invalid=email?clerk');
			}
			else {
				try {

					$query = "SELECT id, username FROM users WHERE username = '".$_POST['username']."'";
					$result = mysqli_query($data, $query);
					$row = mysqli_fetch_array($result);
				}
				catch(PDOException $e) {
					$_SESSION['message_fail'] = $e->getMessage();
				}
	
				
				try{
					//make use of prepared statement to prevent sql injection
					$sql = $db->prepare("UPDATE users SET officeName = :officeName, name = :name, username = :username, password = :password WHERE id = :id");
	
					//bind 
					$sql->bindParam(':officeName', $_POST['officeName']);
					$sql->bindParam(':name', $_POST['name']);
					$sql->bindParam(':username', $_POST['username']);
					$sql->bindParam(':password', $_POST['password']);
					$sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

					$cur_id =  $_GET['id'];
	
					//if-else statement in executing our prepared statement
					$_SESSION['message'] = ( $sql->execute()) ? 'Updated successfully' : 'Something went wrong. Cannot update clerk user.';	
					//close connection
					$database->close();
					header("location: ../super_admin/clerk_users.php?succesful=edited?clerk");
					
				
				}
				catch(PDOException $e){
					$_SESSION['message_fail'] = "The email already exist. Please choose another email.";
					//close connection
					$database->close();
					header("location: ../super_admin/clerk_users.php?failed=edited?clerk");
				}
				
			}			
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
	}

	
?>