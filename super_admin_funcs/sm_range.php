<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['submit'])){
		$database = new Connection();
		$db = $database->open();
        $summer_date = $_POST['start_month']." ".$_POST['start_day'];
        $summer_end_date = $_POST['end_month']." ".$_POST['end_day'];
		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("UPDATE dateRange SET summer_date = :summer_date, end_summer_date = :end_summer_date WHERE id = :id");

            //bind 
			$sql->bindParam(':summer_date', $summer_date);
            $sql->bindParam(':end_summer_date', $summer_end_date);
            $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'Summer date range was edited successfully' : 'Something went wrong. Cannot update this date range.';	
	    
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

	header('location: ../super_admin/settings.php?succesful=edited');
	
?>