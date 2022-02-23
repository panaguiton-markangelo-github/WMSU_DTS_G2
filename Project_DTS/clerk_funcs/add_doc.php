<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['add'])){
		$database = new Connection();
		$db = $database->open();
		try{

			if($_POST['type'] == "Memorandum") {
				$_POST['trackingID'] = "M".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Certificate of Service") {
				$_POST['trackingID'] = "COS".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Disbursement of Service") {
				$_POST['trackingID'] = "DOS".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Inventory and Inspection Report") {
				$_POST['trackingID'] = "IIR".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Letter") {
				$_POST['trackingID'] = "L".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Liquidation Report") {
				$_POST['trackingID'] = "LR".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Memorandum of Agreement") {
				$_POST['trackingID'] = "MOA".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Memorandum Receipt") {
				$_POST['trackingID'] = "MR".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Official Cash Book") {
				$_POST['trackingID'] = "OCB".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Personal Data Sheet") {
				$_POST['trackingID'] = "PDS".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Purchase Order") {
				$_POST['trackingID'] = "PO".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Purchase Request") {
				$_POST['trackingID'] = "PR".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Referral Slip") {
				$_POST['trackingID'] = "RS".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Request for Obligation of Allotments") {
				$_POST['trackingID'] = "RFOA".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Requisition and Issue Voucher") {
				$_POST['trackingID'] = "RIV".$_SESSION["trackID"];
			}

			else if($_POST['type'] == "Unclassified") {
				$_POST['trackingID'] = "U".$_SESSION["trackID"];
			}

			$_SESSION['orig_office'] = $_POST['office'];
			$_SESSION['no_final_trackID'] = $_POST['trackingID'];
			$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
			
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("INSERT INTO documents (trackingID, title, type, reason, remarks, status, user_id, yearSemID) VALUES (:trackingID, :title, :type, :reason, :remarks, :status, :user_id, :yearSemID)");
			
			//bind
			$sql->bindParam(':trackingID', $_POST['trackingID']);
            $sql->bindParam(':title', $_POST['title']);
			$sql->bindParam(':type', $_POST['type']);
            $sql->bindParam(':reason', $_POST['reason']);
			$sql->bindParam(':remarks', $_POST['remarks']);
			$sql->bindParam(':status', $_POST['status']);
			$sql->bindParam(':user_id', $_POST['user_id']);
			$sql->bindParam(':yearSemID', $_POST['yearSemID']);


			$remarks_log = "Added the document in the office";
			$sql_logs = $db->prepare("INSERT INTO logs (trackingID, remarks, status, user_id, created_at, office, origin_office) VALUES (:trackingID, :remarks, :status, :user_id, :created_at, :office, :origin_office)");
			
			//bind
			$sql_logs->bindParam(':trackingID', $_POST['trackingID']);
			$sql_logs->bindParam(':remarks', $remarks_log);
			$sql_logs->bindParam(':status', $_POST['status']);
			$sql_logs->bindParam(':user_id', $_POST['user_id']);
			$sql_logs->bindParam(':created_at',$date->format('M/d/Y, H:i:s'));
			$sql_logs->bindParam(':office', $_POST['office']);
			$sql_logs->bindParam(':origin_office', $_SESSION['orig_office']);

			$sql_logs->execute();

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'Document was added successfully' : 'Something went wrong. Cannot add document.';
			
	    
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

	header('location: ../clerk/HomePageC.php?successful=added?doc');
	
?>