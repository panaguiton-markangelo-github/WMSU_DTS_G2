<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['delete'])){
		$database = new Connection();
		$db = $database->open();

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