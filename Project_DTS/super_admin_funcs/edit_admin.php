<?php 
//Alternative Database connection.
$host = "localhost";
$user = "root";
$password = "kookies172001";
$db = "dts_db";

$data = mysqli_connect($host, $user, $password, $db);

if($data === false){
    die("connection error");
}
?>
<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['edit'])){
			$database = new Connection();
			$db = $database->open();

			try {

				$query = "SELECT id FROM users WHERE username = '".$_POST['username']."'";
				$result = mysqli_query($data, $query);
				$row = mysqli_fetch_array($result);
			}
			catch(PDOException $e) {
				$_SESSION['message_fail'] = $e->getMessage();
			}

			if(empty($row)) {
				try{
					//make use of prepared statement to prevent sql injection
					$sql = $db->prepare("UPDATE users SET officeName = :officeName, name = :name, username = :username, password = :password WHERE id = :id");
	
					//bind 
					$sql->bindParam(':officeName', $_POST['officeName']);
					$sql->bindParam(':name', $_POST['name']);
					$sql->bindParam(':username', $_POST['username']);
					$sql->bindParam(':password', $_POST['password']);
					$sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
	
					//if-else statement in executing our prepared statement
					$_SESSION['message'] = ( $sql->execute()) ? 'Updated successfully' : 'Something went wrong. Cannot update admin user.';	
				
				}
				catch(PDOException $e){
					$_SESSION['message'] = $e->getMessage();
				}
	
				//close connection
				$database->close();

				header('location: ../super_admin/admin_users.php?succesful=edited?admin');

			}

			else if (!empty($row)){
				
				$_SESSION['message_fail'] = "The username already exist. Please choose another username.";
				$database->close();
				header('location: ../super_admin/admin_users.php?failed=edit?admin');
			}
		
		}

		else{
			$_SESSION['message'] = 'Fill up add form first';
		}
	
?>