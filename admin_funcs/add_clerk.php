<?php 
include ("../include/alt_db.php");
?>
<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['add'])){
		$database = new Connection();
		$db = $database->open();
		$email = $_POST['username'];
		$password = $_POST['password'];
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$active = 'yes';
		$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
		$remarks = "added by the office admin.";

		$api_key = "1372d36b08aa4f65b05a4d6b7d0e9fca";
		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1/?api_key=$api_key&email=$email",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true
		]);

		$response = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response, true);


		if ($data['deliverability'] === "UNDELIVERABLE") {
			$_SESSION['message_fail'] = "Please enter a valid email!";
			$database->close();
			header('location: ../super_admin/clerk_users.php?invalid=email?clerk');
		}
		elseif($data['is_free_email']['value'] === false){
			$_SESSION['message_fail'] = "Please enter a valid gmail!";
			$database->close();
			header('location: ../super_admin/clerk_users.php?invalid=email?clerk');
		}
		elseif (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['message_fail'] = "Please enter a valid email!";
			$database->close();
			header('location: ../admin/clerk_users.php?invalid=email?clerk');
		}

		else {
			try {

				$query = "SELECT id FROM users WHERE username = '".$_POST['username']."'";
				$result = mysqli_query($data, $query);
				$row = mysqli_fetch_array($result);
			}
			catch(PDOException $e) {
				$_SESSION['message_fail'] = $e->getMessage();
			}
	
			if (empty($row)){
				try{
					$sql_logs = $db->prepare("INSERT INTO userslog (added_by, office, added_at, email, remarks) VALUES (:added_by, :office, :added_at, :email, :remark)");
				
					//bind
					$sql_logs->bindParam(':added_by', $_POST['added_by']);
					$sql_logs->bindParam(':office', $_POST['office']);
					$sql_logs->bindParam(':added_at',$date->format('M/d/Y, H:i:s'));
					$sql_logs->bindParam(':email',$_POST['username']);
					$sql_logs->bindParam(':remark',$remarks);

					$sql_logs->execute();

					//make use of prepared statement to prevent sql injection
					$sql = $db->prepare("INSERT INTO users (officeName, name, username, password, userType, activated) VALUES (:officeName, :name, :username, :password, :userType, :activated)");
		
					//bind
					$sql->bindParam(':officeName', $_POST['officeName']);
					$sql->bindParam(':name', $_POST['name']);
					$sql->bindParam(':username', $_POST['username']);
					$sql->bindParam(':password', $password_hash);
					$sql->bindParam(':userType', $_POST['userType']);
					$sql->bindParam(':activated', $active);
		
					//if-else statement in executing our prepared statement
					$_SESSION['message'] = ( $sql->execute()) ? 'Clerk user was added successfully' : 'Something went wrong. Cannot add clerk user.';
		
				
				}
				catch(PDOException $e){
					$_SESSION['message'] = $e->getMessage();
				}
		
				//close connection
				$database->close();
	
				header('location: ../admin/clerk_users.php?succesful=added?clerk');
			}
	
			else if (!empty($row)){
				$_SESSION['message_fail'] = "The username already exist. Please choose another username.";
				$database->close();
				header('location: ../admin/clerk_users.php?failed=add?clerk');
			}
		}

		
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
		header('location: ../admin/clerk_users.php?failed');
		//close connection
		$database->close();
		exit();
	}
?>