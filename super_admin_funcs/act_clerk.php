<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['submit'])){
		$database = new Connection();
		$db = $database->open();
		if($_POST['active'] == 'yes'){
			$message = "Clerk user was activated successfully!";
		}
		elseif($_POST['active'] == 'no'){
			$message = "Clerk user was deactivated successfully!";
		}

		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("UPDATE users SET activated = :activated WHERE id = :id");

            //bind 
			$sql->bindParam(':activated', $_POST['active']);
            $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? $message : 'Something went wrong. Cannot update this user.';	
	    
		}
		catch(PDOException $e){
			$error_m1 = $e->getCode();

			if ($error_m1 == 23000) {
				$_SESSION['e_message'] = "OOps. Cannot activate this user.";
				header("Location: ../super_admin/clerk_users.php?error=exist");
				exit();
			}
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
	}

	header('location: ../super_admin/clerk_users.php?succesful=activated?');
	
?>