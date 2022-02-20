<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['edit'])){
		$database = new Connection();
		$db = $database->open();
		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("UPDATE yearsemester SET schoolYear = :schoolYear, semester = :semester WHERE id = :id");

            //bind 
			$sql->bindParam(':schoolYear', $_POST['schoolYear']);
            $sql->bindParam(':semester', $_POST['semester']);
            $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'Updated successfully' : 'Something went wrong. Cannot update this school year and semester.';	
	    
		}
		catch(PDOException $e){
			$error_m1 = $e->getCode();

			if ($error_m1 == 23000) {
				$_SESSION['e_message'] = "OOps. Cannot edit this school year and semester. Because there is/are still documents within this year/semester.";
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

	header('location: ../super_admin/sem_year.php?succesful=edited?year?sem');
	
?>