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
		$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
		$remarks = "edited by the office admin.";

		if (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['message_fail'] = "Please enter a valid email!";
			$database->close();
			header('location: ../admin/clerk_users.php?invalid=email?clerk');
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
				
			try{
				$sql_logs = $db->prepare("INSERT INTO userslog (edited_by, office, edited_at, email, remarks) VALUES (:edited_by, :office, :edited_at, :email, :remark)");
				
				//bind
				$sql_logs->bindParam(':edited_by', $_POST['edited_by']);
				$sql_logs->bindParam(':office', $_POST['office']);
				$sql_logs->bindParam(':edited_at',$date->format('M/d/Y, H:i:s'));
				$sql_logs->bindParam(':email',$_POST['username']);
				$sql_logs->bindParam(':remark',$remarks);

				$sql_logs->execute();

				//make use of prepared statement to prevent sql injection
				$sql = $db->prepare("UPDATE users SET officeName = :officeName, name = :name, username = :username, password = :password WHERE id = :id");
	
				//bind 
				$sql->bindParam(':officeName', $_POST['officeName']);
				$sql->bindParam(':name', $_POST['name']);
				$sql->bindParam(':username', $_POST['username']);
				$sql->bindParam(':password', $password_hash);
				$sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
	
				//if-else statement in executing our prepared statement
				$_SESSION['message'] = ( $sql->execute()) ? 'Updated successfully' : 'Something went wrong. Cannot update clerk user.';	
				//close connection
				$database->close();
				header('location: ../admin/clerk_users.php?succesful=edited?clerk');
			
			}
			catch(PDOException $e){
				$_SESSION['message_fail'] = "The username already exist. Please choose another username.";
				$database->close();
				header('location: ../admin/clerk_users.php?failed=edit?clerk');
			}			
						
		}

	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
		header('location: ../admin/clerk_users.php?failed');
		//close connection
		$database->close();
		exit();
	}	
?>