<?php
	session_start();
	include_once('../include/database.php');
	include_once('../include/database.php');

	if(isset($_POST['delete'])){
		$database = new Connection();
		$db = $database->open();

		$query = "SELECT status FROM documents WHERE status = '".$_POST['status_rel']."'";
		$result = mysqli_query($data, $query);
		$row = mysqli_fetch_array($result);

		if($row['status']  == 'released' && !empty($row)){
			$_SESSION['e_message'] = "Oppss. You cannot delete a document that was already released/processed!";
			header('location: ../admin/office_docs.php?failed=released');
			//close connection
			$database->close();
			exit();
		}
		else
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
				$_SESSION['e_message'] = $e->getMessage();
			}
	
			//close connection
			$database->close();
		}
	}

	else{
		$_SESSION['e_message'] = 'Fill up add form first';
		header('location: ../admin/office_docs.php?failed');
		//close connection
		$database->close();
		exit();
	}

	header('location: ../admin/office_docs.php?succesful=deleted');
	
?>