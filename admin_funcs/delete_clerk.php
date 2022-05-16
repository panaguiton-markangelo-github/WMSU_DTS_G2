<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['delete'])){
		$database = new Connection();
		$db = $database->open();
		$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
		$remarks = "deleted by the office admin.";
		try{

			$sql_logs = $db->prepare("INSERT INTO userslog (deleted_by, office, deleted_at, email, remarks) VALUES (:deleted_by, :office, :deleted_at, :email, :remark)");
				
			//bind
			$sql_logs->bindParam(':deleted_by', $_POST['deleted_by']);
			$sql_logs->bindParam(':office', $_POST['office']);
			$sql_logs->bindParam(':deleted_at',$date->format('M/d/Y, H:i:s'));
			$sql_logs->bindParam(':email',$_POST['email']);
			$sql_logs->bindParam(':remark',$remarks);

			$sql_logs->execute();

			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("DELETE FROM users WHERE id = :id");

            //bind params
            $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'Clerk user was deleted successfully': 'Something went wrong. Cannot delete this clerk user.';	
	    
		}
		catch(PDOException $e){
			//close connection
			$database->close();
			$_SESSION['message_fail'] = "user cannot be deleted, since there is/are an affliated document with this user.";		
			header('location: ../admin/clerk_users.php?failed=deleted?clerk');
			exit();
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
		header('location: ../admin/clerk_users.php?failed');
		//close connection
		$database->close();
		exit();
	}

	header('location: ../admin/clerk_users.php?succesful=deleted?clerk');
	
?>