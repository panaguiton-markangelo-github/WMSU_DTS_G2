<?php 
include ("../include/alt_db.php");
?>
<?php
	session_start();
	include_once('../include/database.php');

	if(isset($_POST['add'])){
			$database = new Connection();
			$db = $database->open();
            $type = $_POST['type'];
			
            try {

                $query = "SELECT id FROM types WHERE type = '".$type."'";
                $result = mysqli_query($data, $query);
                $row = mysqli_fetch_array($result);
            }
            catch(PDOException $e) {
                $_SESSION['message_fail'] = $e->getMessage();
            }

	
            if(empty($row)){
                try{
                    //make use of prepared statement to prevent sql injection
                    $sql = $db->prepare("INSERT INTO types (type) VALUES (:type)");

                    //bind
                    $sql->bindParam(':type', $type);
            
                    //if-else statement in executing our prepared statement
                    $_SESSION['message'] = ( $sql->execute()) ? 'Document type was added successfully' : 'Something went wrong. Cannot add the document type.';

                
                }
                catch(PDOException $e){
                    $_SESSION['message'] = $e->getMessage();
                }

                //close connection
                $database->close();	   
                header('location:../super_admin/types.php?succesful=added');	
                exit();	
            }

            else if (!empty($row)){
                $_SESSION['message_fail'] = "The document type is already existing.!";
                $database->close();
                header('location: ../super_admin/types.php?failed=add');
            }			
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
        header('location: ../super_admin/types.php?failed=add');
        exit();
	}

?>