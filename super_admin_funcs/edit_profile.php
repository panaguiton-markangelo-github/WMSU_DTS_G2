<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['edit'])){
		$database = new Connection();
		$db = $database->open();
		$pass = $_POST['password'];
		$pass_rep = $_POST['password-rep'];
		$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

		if (empty($pass) || empty($pass_rep)) {
			$_SESSION['message_fail'] = "Password fields cannot be empty!";
			header("location: ../super_admin/HomePageSA.php?pass=empty");
			exit();
		}

		elseif ($pass != $pass_rep) {
			$_SESSION['message_fail'] = "Password fields does not match each other!";
			header("location: ../super_admin/HomePageSA.php?pass=notequal");
			exit();
		}

		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("UPDATE users SET name = :name, password = :password WHERE id = :id");

            //bind 
			$sql->bindParam(':name', $_POST['name']);
            $sql->bindParam(':password', $pass_hash);
            $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'Profile updated successfully' : 'Something went wrong. Cannot update this profile.';	
	    
		}
		catch(PDOException $e){
			$_SESSION['message_fail'] = $e->getMessage();
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message_fail'] = 'Fill up add form first';
	}

	header('location: ../super_admin/HomePageSA.php?succesful=edited?profile');
	
?>