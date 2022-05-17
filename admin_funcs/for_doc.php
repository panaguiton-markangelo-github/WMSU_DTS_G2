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
    $sql1 = "SELECT origin_office FROM logs WHERE trackingID = '".$_POST['trackingID']."';";
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

	if(isset($_POST['submit'])){
		$database = new Connection();
		$db = $database->open();
        $status = $_POST['status'];
        $action = $_POST['reason'];
        $offices = implode(',', $_POST['officeName']);
        if(!empty($_POST['oreason'])){
            $action = $_POST['oreason'];
        }
        $forwarded_mes = "Forwarded to the office/s with $action";
        $date = new DateTime("now", new DateTimeZone('Asia/Manila'));
			
		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare ("UPDATE documents SET status = :status, reason = :reason WHERE trackingID = :trackingID;");
            //bind 
			$sql->bindParam(':trackingID', $_POST['trackingID']);
			$sql->bindParam(':status', $status);
            $sql->bindParam(':reason', $action);

            $_SESSION['trackingID'] = $_POST['trackingID'];

            foreach($_POST['officeName'] as $selectedOffice){

                $sql_logs = $db->prepare ("INSERT INTO logs (trackingID, user_id, office, forwarded_at, remarks, status, origin_office, forwarded_to) VALUES(:trackingID, :user_id, :office, :forwarded_at, :remarks, :status, :origin_office, :forwarded_to);");
                $sql_logs->bindParam(':trackingID', $_POST['trackingID']);
                $sql_logs->bindParam(':user_id', $_POST['userID']);
                $sql_logs->bindParam(':office', $selectedOffice);
                $sql_logs->bindParam(':forwarded_at', $date->format('M/d/Y, H:i:s'));
                $sql_logs->bindParam(':status', $status);
                $sql_logs->bindParam(':remarks', $forwarded_mes);
                $sql_logs->bindParam(':origin_office', $row1['origin_office']);
                $sql_logs->bindParam(':forwarded_to', $offices);
    
                $sql_logs->execute();
            }

           

			//if-else statement in executing our prepared statement
			$_SESSION['message_release'] = ( $sql->execute()) ? 'Document was forwared successfully.': 'Something went wrong. Cannot forward the document.';	
		}
		catch(PDOException $e){
			$_SESSION['message_release'] = $e->getMessage();
		}

		//close connection
		$database->close();
	}

	else{
		$_SESSION['message_release'] = 'Fill up add form first';
        header('location: ../admin/homePageAdmin.php?failed=forward');
		//close connection
		$database->close();
		exit();
	}

	header('location: ../admin/homePageAdmin.php?successful=forward?doc');
	
?>