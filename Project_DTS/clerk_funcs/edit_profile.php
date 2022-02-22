<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['edit'])){
		$database = new Connection();
		$db = $database->open();
		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("UPDATE users SET name = :name, password = :password WHERE id = :id");

            //bind 
			$sql->bindParam(':name', $_POST['name']);
            $sql->bindParam(':password', $_POST['password']);
            $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

			//if-else statement in executing our prepared statement
			$_SESSION['message_profile'] = ( $sql->execute()) ? 'Profile updated successfully' : 'Something went wrong. Cannot update this profile.';	
	    
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

	header('location: ../clerk/HomePageC.php?succesful=edited?profile');
	
?>