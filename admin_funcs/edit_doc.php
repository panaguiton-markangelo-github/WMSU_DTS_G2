<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['edit'])){
		$database = new Connection();
		$db = $database->open();
		$reason = $_POST['reason'];
		$user = "admin";
		$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
		$remarks = "edited by the user.";
		try{
			$sql_logs = $db->prepare("INSERT INTO docslog (trackingID, edited_by, office, edited_at, userType, remarks) VALUES (:trackingID, :edited_by, :office, :edited_at, :userType, :remark)");
				
			//bind
			$sql_logs->bindParam(':trackingID', $_POST['trackingID']);
			$sql_logs->bindParam(':edited_by', $_POST['edited_by']);
			$sql_logs->bindParam(':office', $_POST['office']);
			$sql_logs->bindParam(':edited_at',$date->format('M/d/Y, H:i:s'));
			$sql_logs->bindParam(':userType',$user);
			$sql_logs->bindParam(':remark',$remarks);

			$sql_logs->execute();

			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare ("UPDATE documents SET title = :title, reason = :reason, remarks = :remarks WHERE id = :id;");
            //bind 
            $sql->bindParam(':title', $_POST['title']);
            $sql->bindParam(':reason', $reason);
			$sql->bindParam(':remarks', $_POST['remarks']);
			$sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);



			//if-else statement in executing our prepared statement
			$_SESSION['edit_message'] = ( $sql->execute()) ? 'Updated successfully': 'Something went wrong. Cannot update document.';	
	    
		}
		catch(PDOException $e){
			$_SESSION['e_message'] = $e->getMessage();
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['e_message'] = 'Fill up add form first';
		header('location: ../admin/office_docs.php?failed');
		//close connection
		$database->close();
		exit();
	}

	header('location: ../admin/office_docs.php?succesful=edited');
	
?>