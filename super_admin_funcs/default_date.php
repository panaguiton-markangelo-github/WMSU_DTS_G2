<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['submit'])){
		$database = new Connection();
		$db = $database->open();
        $first_sem_date = $_POST['start_month_1']." ".$_POST['start_day_1'];
        $first_sem_end_date = $_POST['end_month_1']." ".$_POST['end_day_1'];
        $sec_sem_date = $_POST['start_month_2']." ".$_POST['start_day_2'];
        $sec_sem_end_date = $_POST['end_month_2']." ".$_POST['end_day_2'];
        $sum_date = $_POST['start_month_3']." ".$_POST['start_day_3'];
        $sum_end_date = $_POST['end_month_3']." ".$_POST['end_day_3'];
		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("INSERT INTO `dateRange`(`first_sem_date`, `end_first_sem_date`, `sec_sem_date`, `end_sec_sem_date`, `summer_date`, `end_summer_date`) VALUES (:first_sem_date,:end_first_sem_date,:sec_sem_date,:sec_end_date,:sum_date,:sum_end_date);");

            //bind 
			$sql->bindParam(':first_sem_date', $first_sem_date);
            $sql->bindParam(':end_first_sem_date', $first_sem_end_date);
            $sql->bindParam(':sec_sem_date', $sec_sem_date);
            $sql->bindParam(':sec_end_date', $sec_sem_end_date);
            $sql->bindParam(':sum_date', $sum_date);
            $sql->bindParam(':sum_end_date', $sum_end_date);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'Initialization of date range was executed successfully' : 'Something went wrong.';	
	    
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

	header('location: ../super_admin/settings.php?succesful=initialize');
	
?>