<?php
session_start();
//include our connection
include_once('../include/database.php');

$database = new Connection();
$db = $database->open();
try{	
    $sql = "SELECT officeName FROM users WHERE id = '".$_POST['userID']."';";
    foreach ($db->query($sql) as $row) {
      }
    }
catch(PDOException $e){
    echo "There is some problem in connection: " . $e->getMessage();
    }

    //close connection
    $database->close();
?>

<?php
try{	
    $sql1 = "SELECT origin_office FROM logs WHERE trackingID = '".$_POST['rec_trackingID']."';";
    foreach ($db->query($sql1) as $row1) {
      }
    }
catch(PDOException $e){
    echo "There is some problem in connection: " . $e->getMessage();
    }

    //close connection
    $database->close();
?>

<?php
	include_once('../include/database.php');
    include_once ("../include/alt_db.php");

	if(isset($_POST['submit'])){
		$database = new Connection();
		$db = $database->open();
        $receive_mes = "received in the office.";

        $rec_al_office = $_SESSION['c_officeName'];
        $query = "UPDATE documents SET recipients = REPLACE(recipients, '".$rec_al_office."', '') WHERE trackingID = '".$_POST['rec_trackingID']."';";
        $result = mysqli_query($data, $query);


        if($_POST['status'] == 'draft'){
            $_SESSION['e_message'] = 'The document is still not yet available to be received. Note: The document was not yet finalized and released. Please try again later.';
            header('location: ../clerk/HomePageC.php?failed');
            //close connection
            $database->close();
            exit();
        }

		try{

            $sql_rec = $db->prepare ("UPDATE documents SET status = :status WHERE trackingID = :trackingID;");
            $sql_rec->bindParam(':trackingID', $_POST['rec_trackingID']);
            $sql_rec->bindParam(':status', $_POST['status']);
            $sql_rec->execute();

            $_SESSION['trackingID'] = $_POST['rec_trackingID'];
            $date = new DateTime("now", new DateTimeZone('Asia/Manila'));

            $sql_logs = $db->prepare ("INSERT INTO logs (trackingID, user_id, office, received_at, remarks, status, origin_office) VALUES(:trackingID, :user_id, :office, :received_at, :remarks, :status, :origin_office);");
            $sql_logs->bindParam(':trackingID', $_POST['rec_trackingID']);
            $sql_logs->bindParam(':user_id', $_POST['userID']);
            $sql_logs->bindParam(':office', $row['officeName']);
            $sql_logs->bindParam(':received_at', $date->format('M/d/Y, H:i:s'));
			$sql_logs->bindParam(':status', $_POST['status']);
            $sql_logs->bindParam(':remarks', $receive_mes);
			$sql_logs->bindParam(':origin_office', $row1['origin_office']);


			//if-else statement in executing our prepared statement
			$_SESSION['message_receive'] = ( $sql_logs->execute()) ? 'Document was received successfully.': 'Something went wrong. Cannot receive the document.';	
		}
		catch(PDOException $e){
			$_SESSION['message_receive'] = $e->getMessage();
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message_receive'] = 'Fill up add form first';
        header('location: ../clerk/HomePageC.php?failed=released');
		//close connection
		$database->close();
		exit();
	}

	header('location: ../clerk/HomePageC.php?successful=receive?doc');
	
?>