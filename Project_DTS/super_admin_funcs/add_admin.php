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

	if(isset($_POST['add'])){
			$database = new Connection();
			$db = $database->open();
			
			
			if (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
				$_SESSION['message_fail'] = "Please enter a valid email!";
				$database->close();
				header('location: ../super_admin/admin_users.php?invalid=email?admin');
			}

			else 
			{
				try {

					$query = "SELECT id FROM users WHERE username = '".$_POST['username']."'";
					$result = mysqli_query($data, $query);
					$row = mysqli_fetch_array($result);
				}
				catch(PDOException $e) {
					$_SESSION['message_fail'] = $e->getMessage();
				}
	
				if(empty($row)){
					try{
						//make use of prepared statement to prevent sql injection
						$sql = $db->prepare("INSERT INTO users (officeName, name, username, password, userType) VALUES (:officeName, :name, :username, :password, :userType)");
		
						//bind
						$sql->bindParam(':officeName', $_POST['officeName']);
						$sql->bindParam(':name', $_POST['name']);
						$sql->bindParam(':username', $_POST['username']);
						$sql->bindParam(':password', $_POST['password']);
						$sql->bindParam(':userType', $_POST['userType']);
		
						//if-else statement in executing our prepared statement
						$_SESSION['message'] = ( $sql->execute()) ? 'Admin user was added successfully' : 'Something went wrong. Cannot add admin user.';
		
					
					}
					catch(PDOException $e){
						$_SESSION['message'] = $e->getMessage();
					}
		
					//close connection
					$database->close();	
					
					header('location:../super_admin/admin_users.php?succesful=added?admin');		
				}
	
				else if (!empty($row)){
					$_SESSION['message_fail'] = "The email already exist. Please choose another email.";
					$database->close();
					header('location: ../super_admin/admin_users.php?failed=add?admin');
				}
			}		
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
	}

?>