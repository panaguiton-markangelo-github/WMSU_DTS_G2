<?php 
include ("../include/alt_db.php");
?>
<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['edit'])){
			$database = new Connection();
			$db = $database->open();
			$password = $_POST['password'];
			$password_hash = password_hash($password, PASSWORD_DEFAULT);

			if (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
				$_SESSION['message_fail'] = "Please enter a valid email!";
				$database->close();
				header('location: ../super_admin/admin_users.php?invalid=email?admin');
			}

			else {
				try {

					$query = "SELECT id FROM users WHERE username = '".$_POST['username']."'";
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
					$sql->bindParam(':password', $password_hash);
					$sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
	
					//if-else statement in executing our prepared statement
					$_SESSION['message'] = ( $sql->execute()) ? 'Updated successfully' : 'Something went wrong. Cannot update admin user.';	
					//close connection
					$database->close();
					header('location: ../super_admin/admin_users.php?succesful=edited?admin');
				
				}
				catch(PDOException $e){
					$_SESSION['message_fail'] = "The email already exist. Please choose another email.";
					//close connection
					$database->close();
					header('location: ../super_admin/admin_users.php?failed=edit?admin');
				}
					
			}		
		
		}

		else{
			$_SESSION['message'] = 'Fill up add form first';
		}
	
?>