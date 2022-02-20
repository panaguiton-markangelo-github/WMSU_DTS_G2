<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['add'])){
		$database = new Connection();
		$db = $database->open();
		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("INSERT INTO yearsemester (schoolYear, semester) VALUES (:schoolYear, :semester)");

			//bind
			$sql->bindParam(':schoolYear', $_POST['schoolYear']);
            $sql->bindParam(':semester', $_POST['semester']);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'School Year and Sem was added successfully' : 'Something went wrong. Cannot add school year and sem.';

	    
		}
		catch(PDOException $e){
			$_SESSION['message'] = $e->getMessage();
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
	}

	header('location:../super_admin/sem_year.php?succesful=added?year?sem');
	
?>