<?php 
include ("../include/alt_db.php");
?>
<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['add'])){
			$database = new Connection();
			$db = $database->open();
            $reason = $_POST['reason'];
			
            try {

                $query = "SELECT id FROM reasons WHERE reason = '".$reason."'";
                $result = mysqli_query($data, $query);
                $row = mysqli_fetch_array($result);
            }
            catch(PDOException $e) {
                $_SESSION['message_fail'] = $e->getMessage();
            }

	
            if(empty($row)){
                try{
                    //make use of prepared statement to prevent sql injection
                    $sql = $db->prepare("INSERT INTO reasons (reason) VALUES (:reason);");

                    //bind
                    $sql->bindParam(':reason', $reason);
            
                    //if-else statement in executing our prepared statement
                    $_SESSION['message'] = ( $sql->execute()) ? 'Document reason was added successfully' : 'Something went wrong. Cannot add the document reason.';

                
                }
                catch(PDOException $e){
                    $_SESSION['message'] = $e->getMessage();
                }

                //close connection
                $database->close();	   
                header('location:../super_admin/reasons.php?succesful=added');	
                exit();	
            }

            else if (!empty($row)){
                $_SESSION['message_fail'] = "The document reason is already existing.!";
                $database->close();
                header('location: ../super_admin/reasons.php?failed=add');
            }			
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
        header('location: ../super_admin/reasons.php?failed=add');
        exit();
	}

?>