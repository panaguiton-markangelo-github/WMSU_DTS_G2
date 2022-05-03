<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['delete'])){
		$database = new Connection();
		$db = $database->open();
		try{

			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("DELETE FROM reasons WHERE id = :id");

            //bind params
            $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'Document reason was deleted successfully': 'Something went wrong. Cannot delete this document reason.';	
	    
		}
		catch(PDOException $e){
			$_SESSION['message_fail'] = $e->getMessage();	
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
		header('location: ../super_admin/reasons.php?failed=deleted');
		exit();
	}
    
	header('location: ../super_admin/reasons.php?succesful=deleted');
?>