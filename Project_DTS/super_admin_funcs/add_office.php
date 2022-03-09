<?php 
include ("../include/alt_db.php");
?>
<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['add'])){
			$database = new Connection();
			$db = $database->open();
            $officeUp = strtoupper($_POST['officeName']);
			
            try {

                $query = "SELECT id FROM office WHERE officeName = '".$_POST['officeName']."'";
                $result = mysqli_query($data, $query);
                $row = mysqli_fetch_array($result);
            }
            catch(PDOException $e) {
                $_SESSION['message_fail'] = $e->getMessage();
            }

	
            if(empty($row)){
                try{
                    //make use of prepared statement to prevent sql injection
                    $sql = $db->prepare("INSERT INTO office (officeName, description) VALUES (:officeName, :description)");

                    //bind
                    $sql->bindParam(':officeName', $officeUp);
                    $sql->bindParam(':description', $_POST['description']);

                    //if-else statement in executing our prepared statement
                    $_SESSION['message'] = ( $sql->execute()) ? 'Office was added successfully' : 'Something went wrong. Cannot add office.';

                
                }
                catch(PDOException $e){
                    $_SESSION['message'] = $e->getMessage();
                }

                //close connection
                $database->close();	   
                header('location:../super_admin/offices.php?succesful=added');	
                exit();	
            }

            else if (!empty($row)){
                $_SESSION['message_fail'] = "The office is already existing.!";
                $database->close();
                header('location: ../super_admin/offices.php?failed=add');
            }			
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
        header('location: ../super_admin/offices.php?failed=add');
        exit();
	}

?>