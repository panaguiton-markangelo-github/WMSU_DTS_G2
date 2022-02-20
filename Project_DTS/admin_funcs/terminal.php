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
	include_once('../include/database.php');

	if(isset($_POST['submit'])){
		$database = new Connection();
		$db = $database->open();
        $terminal_mes = "tagged as terminal in the office.";
		$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare ("UPDATE documents SET status = :status WHERE trackingID = :trackingID;");
            //bind 
			$sql->bindParam(':trackingID', $_POST['termTrackingID']);
			$sql->bindParam(':status', $_POST['status']);

            $_SESSION['trackingID'] = $_POST['termTrackingID'];

            $sql_logs = $db->prepare ("INSERT INTO logs (trackingID, user_id, office, terminal_at, remarks, action, status) VALUES(:trackingID, :user_id, :office, :terminal_at, :remarks, :action, :status);");
            $sql_logs->bindParam(':trackingID', $_POST['termTrackingID']);
            $sql_logs->bindParam(':user_id', $_POST['userID']);
            $sql_logs->bindParam(':office', $row['officeName']);
            $sql_logs->bindParam(':terminal_at', $date->format('M/d/Y, H:i:s'));
            $sql_logs->bindParam(':action', $_POST['action']);
			$sql_logs->bindParam(':status', $_POST['status']);
            $sql_logs->bindParam(':remarks', $terminal_mes);

            $sql_logs->execute();

			//if-else statement in executing our prepared statement
			$_SESSION['message_terminal'] = ( $sql->execute()) ? 'Document was tagged as terminal successfully. Note: The document can no longer be processed by any office!': 'Something went wrong. Cannot tag the document as terminal.';	
		}
		catch(PDOException $e){
			$_SESSION['message_terminal'] = $e->getMessage();
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message_terminal'] = 'Fill up add form first';
	}

	header('location: ../admin/HomePageAdmin.php?successful=terminal?doc');
	
?>