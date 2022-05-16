<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['submit'])){
		$database = new Connection();
		$db = $database->open();
		$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
		if($_POST['active'] == 'yes'){
			$message = "Clerk user was activated successfully!";
			$remarks = "activated by the office admin.";
			try{
				$sql_logs = $db->prepare("INSERT INTO userslog (activated_by, office, activated_at, email, remarks) VALUES (:activated_by, :office, :activated_at, :email, :remark)");
				
				//bind
				$sql_logs->bindParam(':activated_by', $_POST['name']);
				$sql_logs->bindParam(':office', $_POST['office']);
				$sql_logs->bindParam(':activated_at',$date->format('M/d/Y, H:i:s'));
				$sql_logs->bindParam(':email',$_POST['email']);
				$sql_logs->bindParam(':remark',$remarks);

				$sql_logs->execute();
			}
			catch(PDOException $e){
				$error_m1 = $e->getCode();
			}
		}
		elseif($_POST['active'] == 'no'){
			$message = "Clerk user was deactivated successfully!";
			$remarks = "deactivated by the office admin.";
			try{
				$sql_logs = $db->prepare("INSERT INTO userslog (deactivated_by, office, deactivated_at, email, remarks) VALUES (:deactivated_by, :office, :deactivated_at, :email, :remark)");
				
				//bind
				$sql_logs->bindParam(':deactivated_by', $_POST['name']);
				$sql_logs->bindParam(':office', $_POST['office']);
				$sql_logs->bindParam(':deactivated_at',$date->format('M/d/Y, H:i:s'));
				$sql_logs->bindParam(':email',$_POST['email']);
				$sql_logs->bindParam(':remark',$remarks);

				$sql_logs->execute();
			}
			catch(PDOException $e){
				$error_m1 = $e->getCode();
			}
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
				header("Location: ../admin/clerk_users.php?error=exist");
				exit();
			}
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
	}

	header('location: ../admin/clerk_users.php?succesful?');
	
?>