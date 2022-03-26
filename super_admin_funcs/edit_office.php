<?php 
include ("../include/alt_db.php");
?>
<?php
	session_start();
	include_once('../include/database.php');
	if(isset($_POST['edit'])){
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
                    $sql = $db->prepare("UPDATE office SET officeName = :officeName, description = :description WHERE id = :id");
    
                    //bind 
                    $sql->bindParam(':officeName', $officeUp);
                    $sql->bindParam(':description', $_POST['description']);
                    $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    
                    //if-else statement in executing our prepared statement
                    $_SESSION['message'] = ( $sql->execute()) ? 'Updated successfully' : 'Something went wrong. Cannot update office.';	   
                
                }
                catch(PDOException $e){
                    $_SESSION['message_fail'] = "Something went wrong!";
                    //close connection
                    $database->close();
                    header('location: ../super_admin/offices.php?failed=edit?');
                    exit();
                }
                 //close connection
                $database->close();
                header('location: ../super_admin/offices.php?succesful=edited');
                exit();
            }
            
            elseif(!empty($row)){
                $_SESSION['message_fail'] = "The office is already existing!";
                //close connection
                $database->close();
                header('location: ../super_admin/offices.php?failed=edit?');
                exit();
            }
		
		}

		else{
			$_SESSION['message'] = 'Fill up add form first';
            header('location: ../super_admin/offices.php?failed=edit?');
            exit();
		}

       
	
?>