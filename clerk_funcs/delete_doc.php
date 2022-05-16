<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['delete'])){
		$database = new Connection();
		$db = $database->open();
		$user = "clerk";
		$date = new DateTime("now", new DateTimeZone('Asia/Manila'));

		if($_POST['status_rel'] != 'draft'){
			$_SESSION['message_fail'] = "Oppss. You cannot delete a document that was already released/processed!";
			header('location: ../clerk/office_docs.php?failed=released');
			//close connection
			$database->close();
			exit();
		}
		elseif($_POST['status_rel'] == 'draft')
		{
			try{
				$sql_logs = $db->prepare("INSERT INTO docslog (trackingID, deleted_by, office, deleted_at, userType) VALUES (:trackingID, :deleted_by, :office, :deleted_at, :userType)");
				
				//bind
				$sql_logs->bindParam(':trackingID', $_POST['trackingID']);
				$sql_logs->bindParam(':deleted_by', $_POST['deleted_by']);
				$sql_logs->bindParam(':office', $_POST['office']);
				$sql_logs->bindParam(':deleted_at',$date->format('M/d/Y, H:i:s'));
				$sql_logs->bindParam(':userType',$user);

				$sql_logs->execute();


				//make use of prepared statement to prevent sql injection
				$sql = $db->prepare("DELETE FROM documents WHERE id = :id");
	
				//bind params
				$sql->bindParam(':id', $_GET['id']);
	
				//if-else statement in executing our prepared statement
				$_SESSION['message'] = ( $sql->execute()) ? 'Document was deleted successfully': 'Something went wrong. Cannot delete this document.';	
			
			}
			catch(PDOException $e){
				$_SESSION['message_fail'] = $e->getMessage();
			}
	
			//close connection
			$database->close();
		}
	}

	else{
		$_SESSION['message_fail'] = 'Fill up add form first';
		header('location: ../clerk/office_docs.php?failed=released');
		//close connection
		$database->close();
		exit();
	}

	header('location: ../clerk/office_docs.php?succesful=deleted');
	
?>