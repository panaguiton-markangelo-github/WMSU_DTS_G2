<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['edit'])){
		$database = new Connection();
		$db = $database->open();
		$reason = $_POST['reason'];
		try{
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
	}

	header('location: ../clerk/office_docs.php?succesful=edited');
	
?>