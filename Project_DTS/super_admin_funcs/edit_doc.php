<?php
$host = "localhost";
$user = "root";
$password = "kookies172001";
$db = "dts_db";

session_start();

$data = mysqli_connect($host, $user, $password, $db);

if($data === false){
	die("connection error");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$query = "SELECT `id` FROM yearsemester WHERE `schoolYear` = '".$_POST['schoolYear']."' AND `semester` = '".$_POST['semester']."';";
	$result = mysqli_query($data, $query);
	$row = mysqli_fetch_array($result);
	$count = mysqli_num_rows($result);

	if ($count > 0) {
		$sem_year_id = $row['id'];
	}
}
?>

<?php
	include_once('../include/database.php');
	if(isset($_POST['edit'])){
		$database = new Connection();
		$db = $database->open();
		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare ("UPDATE documents SET trackingID = :trackingID, title = :title, type = :type, reason = :reason, remarks = :remarks, status = :status, yearSemID = :sem_year_id WHERE id = :id;");
            //bind 
			$sql->bindParam(':trackingID', $_POST['trackingID']);
            $sql->bindParam(':title', $_POST['title']);
			$sql->bindParam(':type', $_POST['type']);
            $sql->bindParam(':reason', $_POST['reason']);
			$sql->bindParam(':remarks', $_POST['remarks']);
			$sql->bindParam(':status', $_POST['status']);
			$sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
			$sql->bindParam(':sem_year_id', $sem_year_id);



			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'Updated successfully': 'Something went wrong. Cannot update document.';	
	    
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

	header('location: ../super_admin/all_docs.php?succesful=edited?doc');
	
?>