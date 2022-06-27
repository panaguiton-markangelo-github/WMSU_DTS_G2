<?php
	session_start();
	include_once('../include/database.php');
	require '../phpmailer/includes/mailer_main.php';
	include_once ("../include/alt_db.php");

	if(isset($_POST['add'])){
		$database = new Connection();
		$db = $database->open();
		$status = $_POST['status_rel'];
		$type = $_POST['type'];
		$reason = $_POST['reason'];

		#$adds = array();
		#$sql = "SELECT officeName FROM office WHERE officeName IN ('".$offices."');";
		#$result = mysqli_query($data, $sql);
		#while($row = mysqli_fetch_assoc($result)){
		#	array_push($adds, $row['id']);
		#}

	
		
		#$subject = "Recipient for an incoming document.";

		#$message = "<p> Don't reply here! Hi There! A document has been sent to your office, please check it at the incoming documents page.</p>";

		#$message .= "From: WMSU|DTS team <support@dts.wmsuccs.com>\r\n";
		#$message .= "<br>Reply-To: wmsudts@gmail.com\r\n";
		#$message .= "<p>Best regards WMSU|DTS team.</p>";

		#$mail->Subject = $subject;
		#$mail->setFrom("support@dts.wmsuccs.com");
		#$mail->isHTML(true);
		#$mail->Body = $message;
	
		#foreach ($adds as $ad) {
		#	$mail->AddAddress(trim($ad));       
		#}
		
		#$mail->Send();

		#$mail->smtpClose();
		
		if(!empty($_POST['oreason'])){
			$reason = $_POST['oreason'];
		}

		if(!empty($_POST['otype'])){
			$type = $_POST['otype'];
		}

		$file = $_FILES['file'];
		$fileName = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];

		$fileExt = explode('.', $fileName);
		$actualFileExt = strtolower(end($fileExt));
		$allowed = array('pdf', 'gif', 'png', 'jpeg', 'jpg');

			
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
			else {
				$_POST['trackingID'] = "O".$_SESSION["trackID"];
			}

			if($fileError != 4){
				if(in_array($actualFileExt, $allowed)){
					if($fileError === 0){
						if($fileSize < 20000000){
							$fileNameNew = uniqid('', true).".".$actualFileExt;
							$fileDestination = '../uploads/'.$fileNameNew;
							move_uploaded_file($fileTmpName, $fileDestination);
	
							$_SESSION['orig_office'] = $_POST['office'];
							$_SESSION['no_final_trackID'] = $_POST['trackingID'];
							$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
							
							//make use of prepared statement to prevent sql injection
							$sql = $db->prepare("INSERT INTO documents (trackingID, title, type, reason, remarks, status, file, schoolYear, user_id, yearSemID, officeID, recipients) VALUES (:trackingID, :title, :type, :reason, :remarks, :status, :file, :schoolYear, :user_id, :yearSemID, :officeID, :recipients);");
							
							//bind
							$sql->bindParam(':trackingID', $_POST['trackingID']);
							$sql->bindParam(':title', $_POST['title']);
							$sql->bindParam(':type', $type);
							$sql->bindParam(':reason', $reason);
							$sql->bindParam(':remarks', $_POST['remarks']);
							$sql->bindParam(':status', $status);
							$sql->bindParam(':file', $fileNameNew);
							$sql->bindParam(':schoolYear', $_POST['schoolYear']);
							$sql->bindParam(':user_id', $_POST['user_id']);
							$sql->bindParam(':yearSemID', $_POST['schoolYear_id']);
							$sql->bindParam(':officeID', $_POST['officeID']);
							$sql->bindParam(':recipients', $offices);
				
							//if-else statement in executing our prepared statement
							$_SESSION['message'] = ( $sql->execute()) ? 'Document was added and released successfully' : 'Something went wrong. Cannot add document.';
	
							$remarks_log = "Released and Added the document in the office";
							$sql_logs = $db->prepare("INSERT INTO logs (trackingID, remarks, status, user_id, created_at, released_at, office, origin_office) VALUES (:trackingID, :remarks, :status, :user_id, :created_at, :released_at, :office, :origin_office)");
							
							//bind
							$sql_logs->bindParam(':trackingID', $_POST['trackingID']);
							$sql_logs->bindParam(':remarks', $remarks_log);
							$sql_logs->bindParam(':status', $status);
							$sql_logs->bindParam(':user_id', $_POST['user_id']);
							$sql_logs->bindParam(':created_at',$date->format('M/d/Y, H:i:s'));
							$sql_logs->bindParam(':released_at',$date->format('M/d/Y, H:i:s'));
							$sql_logs->bindParam(':office', $_POST['office']);
							$sql_logs->bindParam(':origin_office', $_SESSION['orig_office']);
				
							$sql_logs->execute();

							foreach($_POST['officeName'] as $rec){
								$sql_r = $db->prepare("INSERT INTO recipient (officeName, trackingID) VALUES (:officeName, :trackingID)");
							
								//bind
								$sql_r->bindParam(':trackingID', $_POST['trackingID']);
								$sql_r->bindParam(':officeName', $rec);
					
								$sql_r->execute();
							}

							if(!empty($_POST['oreason'])){
								$sql_reason = $db->prepare("INSERT INTO reasons (reason) VALUES (:reason)");
							
								//bind
								$sql_reason->bindParam(':reason', $reason);	
								$sql_reason->execute();

							}
					
							if(!empty($_POST['otype'])){
								$sql_reason = $db->prepare("INSERT INTO types (type) VALUES (:type)");
							
								//bind
								$sql_reason->bindParam(':type', $type);	
								$sql_reason->execute();
							}
	
							//close connection
							$database->close();
							header('location: ../admin/homePageAdmin.php?successful=added?doc');
							unset($_POST['add']);
							exit();
		
						}
						else{
							$_SESSION['e_message'] = "You can only upload pdf file which has a size of less than 20mb.";
							header('location: ../admin/homePageAdmin.php?failed_size');
							unset($_POST['add']);
							exit();
						}
		
					}
					else{
						$_SESSION['e_message'] = "There was an error uploading the file, try again.";
						header('location: ../admin/homePageAdmin.php?failed');
						unset($_POST['add']);
						exit();
					}
		
				}
		
				else {
					$_SESSION['e_message'] = "you can only upload pdf files.";
					header('location: ../admin/homePageAdmin.php?failed_type');
					unset($_POST['add']);
					exit();
				}
			}
			elseif($fileError == 4){
				$_SESSION['orig_office'] = $_POST['office'];
				$_SESSION['no_final_trackID'] = $_POST['trackingID'];
				$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
				
				//make use of prepared statement to prevent sql injection
				$sql = $db->prepare("INSERT INTO documents (trackingID, title, type, reason, remarks, status, schoolYear, user_id, yearSemID, officeID, recipients) VALUES (:trackingID, :title, :type, :reason, :remarks, :status, :schoolYear, :user_id, :yearSemID, :officeID, :recipients);");
				
				//bind
				$sql->bindParam(':trackingID', $_POST['trackingID']);
				$sql->bindParam(':title', $_POST['title']);
				$sql->bindParam(':type', $type);
				$sql->bindParam(':reason', $reason);
				$sql->bindParam(':remarks', $_POST['remarks']);
				$sql->bindParam(':status', $status);
				$sql->bindParam(':schoolYear', $_POST['schoolYear']);
				$sql->bindParam(':user_id', $_POST['user_id']);
				$sql->bindParam(':yearSemID', $_POST['schoolYear_id']);
				$sql->bindParam(':officeID', $_POST['officeID']);
				$sql->bindParam(':recipients', $offices);

				//if-else statement in executing our prepared statement
				$_SESSION['message'] = ( $sql->execute()) ? 'Document was added and released successfully' : 'Something went wrong. Cannot add document.';

				$remarks_log = "Released and Added the document in the office";
				$sql_logs = $db->prepare("INSERT INTO logs (trackingID, remarks, status, user_id, created_at, released_at, office, origin_office) VALUES (:trackingID, :remarks, :status, :user_id, :created_at, :released_at, :office, :origin_office)");
				
				//bind
				$sql_logs->bindParam(':trackingID', $_POST['trackingID']);
				$sql_logs->bindParam(':remarks', $remarks_log);
				$sql_logs->bindParam(':status', $status);
				$sql_logs->bindParam(':user_id', $_POST['user_id']);
				$sql_logs->bindParam(':created_at',$date->format('M/d/Y, H:i:s'));
				$sql_logs->bindParam(':released_at',$date->format('M/d/Y, H:i:s'));
				$sql_logs->bindParam(':office', $_POST['office']);
				$sql_logs->bindParam(':origin_office', $_SESSION['orig_office']);

				$sql_logs->execute();

			
				foreach($_POST['officeID'] as $id){
					$sql_o = "SELECT officeName FROM office WHERE id = '".$id."';";
					$result = mysqli_query($data, $sql_o);
					$row = mysqli_fetch_assoc($result);

					$sql1 = "SELECT id FROM users WHERE officeName = '".$row['officeName']."';";
					$result1 = mysqli_query($data, $sql1);
					$row1 = mysqli_fetch_assoc($result1);

					$sql_r = $db->prepare("INSERT INTO recipient (userID, officeName, trackingID) VALUES (:userID, :officeName, :trackingID)");
				
					//bind
					$sql_r->bindParam(':userID', $row1['id']);
					$sql_r->bindParam(':officeName', $row['officeName']);
					$sql_r->bindParam(':trackingID', $_POST['trackingID']);
					
		
					$sql_r->execute();
					

				}


				if(!empty($_POST['oreason'])){
					$sql_reason = $db->prepare("INSERT INTO reasons (reason) VALUES (:reason)");
				
					//bind
					$sql_reason->bindParam(':reason', $reason);	
					$sql_reason->execute();

				}
		
				if(!empty($_POST['otype'])){
					$sql_reason = $db->prepare("INSERT INTO types (type) VALUES (:type)");
				
					//bind
					$sql_reason->bindParam(':type', $type);	
					$sql_reason->execute();
				}

				//close connection
				$database->close();
				header('location: ../admin/homePageAdmin.php?successful=added?doc');
				unset($_POST['add']);
				exit();
			}

		}
		catch(PDOException $e){
			$_SESSION['message'] = $e->getMessage();
		}

		//close connection
		$database->close();
		unset($_POST['add']);
	}

	elseif(isset($_POST['draft'])){
		$database = new Connection();
		$db = $database->open();
		$status = $_POST['status_draft'];
		$type = $_POST['type'];
		$reason = $_POST['reason'];
		$offices = implode(',', $_POST['officeName']);

		if(!empty($_POST['oreason'])){
			$reason = $_POST['oreason'];
		}

		if(!empty($_POST['otype'])){
			$type = $_POST['otype'];
		}

		$file = $_FILES['file'];
		$fileName = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];

		$fileExt = explode('.', $fileName);
		$actualFileExt = strtolower(end($fileExt));
		$allowed = array('pdf', 'gif', 'png', 'jpeg', 'jpg');

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
			else {
				$_POST['trackingID'] = "O".$_SESSION["trackID"];
			}

			if($fileError != 4){
				if(in_array($actualFileExt, $allowed)){
					if($fileError === 0){
						if($fileSize < 20000000){
							$fileNameNew = uniqid('', true).".".$actualFileExt;
							$fileDestination = '../uploads/'.$fileNameNew;
							move_uploaded_file($fileTmpName, $fileDestination);
	
							$_SESSION['orig_office'] = $_POST['office'];
							$_SESSION['no_final_trackID'] = $_POST['trackingID'];
							$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
							
							//make use of prepared statement to prevent sql injection
							$sql = $db->prepare("INSERT INTO documents (trackingID, title, type, reason, remarks, status, file, schoolYear, user_id, yearSemID, officeID, recipients) VALUES (:trackingID, :title, :type, :reason, :remarks, :status, :file, :schoolYear, :user_id, :yearSemID, :officeID, :recipients);");
							
							//bind
							$sql->bindParam(':trackingID', $_POST['trackingID']);
							$sql->bindParam(':title', $_POST['title']);
							$sql->bindParam(':type', $type);
							$sql->bindParam(':reason', $reason);
							$sql->bindParam(':remarks', $_POST['remarks']);
							$sql->bindParam(':status', $status);
							$sql->bindParam(':file', $fileNameNew);
							$sql->bindParam(':schoolYear', $_POST['schoolYear']);
							$sql->bindParam(':user_id', $_POST['user_id']);
							$sql->bindParam(':yearSemID', $_POST['schoolYear_id']);
							$sql->bindParam(':officeID', $_POST['officeID']);
							$sql->bindParam(':recipients', $offices);
				
							//if-else statement in executing our prepared statement
							$_SESSION['message'] = ( $sql->execute()) ? 'Document was saved as draft successfully' : 'Something went wrong. Cannot save the document as draft.';
	
							$remarks_log = "Added the document in the office";
							$sql_logs = $db->prepare("INSERT INTO logs (trackingID, remarks, status, user_id, created_at, office, origin_office) VALUES (:trackingID, :remarks, :status, :user_id, :created_at, :office, :origin_office)");
							
							//bind
							$sql_logs->bindParam(':trackingID', $_POST['trackingID']);
							$sql_logs->bindParam(':remarks', $remarks_log);
							$sql_logs->bindParam(':status', $status);
							$sql_logs->bindParam(':user_id', $_POST['user_id']);
							$sql_logs->bindParam(':created_at',$date->format('M/d/Y, H:i:s'));
							$sql_logs->bindParam(':office', $_POST['office']);
							$sql_logs->bindParam(':origin_office', $_SESSION['orig_office']);
				
							$sql_logs->execute();

							if(!empty($_POST['oreason'])){
								$sql_reason = $db->prepare("INSERT INTO reasons (reason) VALUES (:reason)");
							
								//bind
								$sql_reason->bindParam(':reason', $reason);	
								$sql_reason->execute();

							}
					
							if(!empty($_POST['otype'])){
								$sql_reason = $db->prepare("INSERT INTO types (type) VALUES (:type)");
							
								//bind
								$sql_reason->bindParam(':type', $type);	
								$sql_reason->execute();
							}
	
							//close connection
							$database->close();
							header('location: ../admin/homePageAdmin.php?successful=drafted?doc');
							unset($_POST['draft']);
							exit();
		
						}
						else{
							$_SESSION['e_message'] = "You can only upload pdf file which has a size of less than 20mb.";
							header('location: ../admin/homePageAdmin.php?failed_size');
							unset($_POST['draft']);
							exit();
						}
		
					}
					else{
						$_SESSION['e_message'] = "There was an error uploading the file, try again.";
						header('location: ../admin/homePageAdmin.php?failed');
						unset($_POST['draft']);
						exit();
					}
		
				}
		
				else {
					$_SESSION['e_message'] = "you can only upload pdf files.";
					header('location: ../admin/homePageAdmin.php?failed_type');
					unset($_POST['draft']);
					exit();
				}
			}
			elseif($fileError == 4){
				$_SESSION['orig_office'] = $_POST['office'];
				$_SESSION['no_final_trackID'] = $_POST['trackingID'];
				$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
				
				//make use of prepared statement to prevent sql injection
				$sql = $db->prepare("INSERT INTO documents (trackingID, title, type, reason, remarks, status, schoolYear, user_id, yearSemID, officeID, recipients) VALUES (:trackingID, :title, :type, :reason, :remarks, :status, :schoolYear, :user_id, :yearSemID, :officeID, :recipients);");
				
				//bind
				$sql->bindParam(':trackingID', $_POST['trackingID']);
				$sql->bindParam(':title', $_POST['title']);
				$sql->bindParam(':type', $type);
				$sql->bindParam(':reason', $reason);
				$sql->bindParam(':remarks', $_POST['remarks']);
				$sql->bindParam(':status', $status);
				$sql->bindParam(':schoolYear', $_POST['schoolYear']);
				$sql->bindParam(':user_id', $_POST['user_id']);
				$sql->bindParam(':yearSemID', $_POST['schoolYear_id']);
				$sql->bindParam(':officeID', $_POST['officeID']);
				$sql->bindParam(':recipients', $offices);

				//if-else statement in executing our prepared statement
				$_SESSION['message'] = ( $sql->execute()) ? 'Document was saved as draft successfully' : 'Something went wrong. Cannot save the document as draft.';

				$remarks_log = "Added the document in the office";
				$sql_logs = $db->prepare("INSERT INTO logs (trackingID, remarks, status, user_id, created_at, office, origin_office) VALUES (:trackingID, :remarks, :status, :user_id, :created_at, :office, :origin_office)");
				
				//bind
				$sql_logs->bindParam(':trackingID', $_POST['trackingID']);
				$sql_logs->bindParam(':remarks', $remarks_log);
				$sql_logs->bindParam(':status', $status);
				$sql_logs->bindParam(':user_id', $_POST['user_id']);
				$sql_logs->bindParam(':created_at',$date->format('M/d/Y, H:i:s'));
				$sql_logs->bindParam(':office', $_POST['office']);
				$sql_logs->bindParam(':origin_office', $_SESSION['orig_office']);

				$sql_logs->execute();
				
				if(!empty($_POST['oreason'])){
					$sql_reason = $db->prepare("INSERT INTO reasons (reason) VALUES (:reason)");
				
					//bind
					$sql_reason->bindParam(':reason', $reason);	
					$sql_reason->execute();

				}
		
				if(!empty($_POST['otype'])){
					$sql_reason = $db->prepare("INSERT INTO types (type) VALUES (:type)");
				
					//bind
					$sql_reason->bindParam(':type', $type);	
					$sql_reason->execute();
				}

				//close connection
				$database->close();
				header('location: ../admin/homePageAdmin.php?successful=drafted?doc');
				unset($_POST['draft']);
				exit();
			}
			 
		}
		catch(PDOException $e){
			$_SESSION['e_message'] = $e->getMessage();
			//close connection
			$database->close();
			header('location: ../admin/homePageAdmin.php?failed');
			unset($_POST['draft']);
			exit();
		}

	}

	else{
		$_SESSION['e_message'] = 'Fill up add form first';
		//close connection
		$database->close();
		header('location: ../admin/homePageAdmin.php?failed');
		exit();
	}
	
?>