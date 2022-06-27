
<?php
	session_start();
	include_once('../include/database.php');
	include ("../include/alt_db.php");

	
	if(isset($_POST['add'])){
			$database = new Connection();
			$db = $database->open();
			$email = $_POST['username'];
			$password = $_POST['password'];
			$password_hash = password_hash($password, PASSWORD_DEFAULT);
			$active = 'yes';
	

			$api_key = "1372d36b08aa4f65b05a4d6b7d0e9fca";
			$ch = curl_init();
			curl_setopt_array($ch, [
				CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1/?api_key=$api_key&email=$email",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true
			]);

			$response = curl_exec($ch);
			curl_close($ch);
			$da = json_decode($response, true);


			if ($da['deliverability'] === "UNDELIVERABLE") {
				$_SESSION['message_fail'] = "Please enter a valid email!";
				$database->close();
				header('location: ../super_admin/admin_users.php?invalid=email?admin');
			}
			elseif($da['is_smtp_valid']['value'] === false){
				$_SESSION['message_fail'] = "Please enter a valid email!";
				$database->close();
				header('location: ../super_admin/clerk_users.php?invalid=email_s?clerk');
			}
			elseif (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
				$_SESSION['message_fail'] = "Please enter a valid email!";
				$database->close();
				header('location: ../super_admin/admin_users.php?invalid=email?admin');
			}

			else 
			{
				try {

					$query = "SELECT id FROM users WHERE username = '".$_POST['username']."'";
					$result = mysqli_query($data, $query);
					$row = mysqli_fetch_array($result);
				}
				catch(PDOException $e) {
					$_SESSION['message_fail'] = $e->getMessage();
				}
	
				if(empty($row)){
					try{
					
			
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
						$_SESSION['message'] = ( $sql->execute()) ? 'Admin user was added successfully' : 'Something went wrong. Cannot add admin user.';
							
					}
					catch(PDOException $e){
						$_SESSION['message'] = $e->getMessage();
					}
					
					//close connection
					$database->close();	
					header('location:../super_admin/admin_users.php?succesful=added?admin?');
		
						
				}
	
				else if (!empty($row)){
					$_SESSION['message_fail'] = "The email already exist. Please choose another email.";
					$database->close();
					header('location: ../super_admin/admin_users.php?failed=add?admin');
				}
			}		
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
	}

?>