<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['delete'])){
		$database = new Connection();
		$db = $database->open();
		try{

			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("DELETE FROM users WHERE id = :id");

            //bind params
            $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'Admin user was deleted successfully': 'Something went wrong. Cannot delete this admin user.';	
	    
		}
		catch(PDOException $e){
			//close connection
			$database->close();
			$_SESSION['message_fail'] = "user cannot be deleted, since there is/are an affliated document with this user.";		
			header('location: ../super_admin/admin_users.php?failed=deleted?admin');
			exit();
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
	}

	header('location: ../super_admin/admin_users.php?succesful=deleted?admin');
	
?>