<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['delete'])){
		$database = new Connection();
		$db = $database->open();
		try{

			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("DELETE FROM yearsemester WHERE id = :id");

            //bind params
            $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'School year and semester was deleted successfully': 'Something went wrong. Cannot delete this school year and semester.';	
	    
		}
		catch(PDOException $e){
			$error_m1 = $e->getCode();

			if ($error_m1 == 23000) {
				$_SESSION['e_message'] = "OOps. Cannot delete this school year and semester. Because there is/are still documents within this year/semester.";
				header("Location: ../super_admin/sem_year.php?error=exist");
				die();
			}
			
			
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
	}

	header('location: ../super_admin/sem_year.php?succesful=deleted?year?sem');
	
?>