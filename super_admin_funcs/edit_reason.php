<?php 
include ("../include/alt_db.php");
?>
<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['edit'])){
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
                    $sql = $db->prepare("UPDATE reasons SET reason = :reason WHERE id = :id");
    
                    //bind 
                    $sql->bindParam(':reason', $reason);
                    $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    
                    //if-else statement in executing our prepared statement
                    $_SESSION['message'] = ( $sql->execute()) ? 'Updated successfully' : 'Something went wrong. Cannot update document reason.';	   
                
                }
                catch(PDOException $e){
                    $_SESSION['message_fail'] = "Something went wrong!";
                    //close connection
                    $database->close();
                    header('location: ../super_admin/reasons.php?failed=edit?');
                    exit();
                }
                 //close connection
                $database->close();
                header('location: ../super_admin/reasons.php?succesful=edited');
                exit();
            }
            
            elseif(!empty($row)){
                $_SESSION['message_fail'] = "The document reason is already existing!";
                //close connection
                $database->close();
                header('location: ../super_admin/reasons.php?failed=edit?');
                exit();
            }
		
		}

		else{
			$_SESSION['message'] = 'Fill up add form first';
            header('location: ../super_admin/reasons.php?failed=edit?');
            exit();
		}

	
?>