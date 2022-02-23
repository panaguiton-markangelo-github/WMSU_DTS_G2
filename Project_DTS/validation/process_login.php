<?php
    session_start();
?>


<?php
    include ("include/alt_db.php");
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
    


        if(empty($username) && empty($password)) {
            $_SESSION['empty_both'] = "Empty Fields!!";
            header('location: index.php?empty=both');
        }

        
        else if(empty($username)) {
            $_SESSION['empty_email'] = "email field cannot be empty!";
            header('location: index.php?empty=email');
        }

        else if(empty($password)) {
            $_SESSION['empty_pass'] = "password field cannot be empty!";
            header('location: index.php?empty=pass');
        }

        else
        {
            if (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['invalid_email'] = "Please enter a valid email!!";
                header('location: index.php?invalid=email');
            }
    
            else {
                $sql = "SELECT * FROM users WHERE username = '".$username."';";
                $result = mysqli_query($data, $sql);
                $row = mysqli_fetch_array($result);
                if(empty($row)){
                    $_SESSION['invalid_match'] = "Email or Password does not match our records!";
                    header('Location: index.php?invalid=match');
                    exit();
                }

                else {
                    $db_pass = $row['password'];
                    $curUser = $row['id'];

                    if($db_pass == "superadmin"){
                        header("location: new_pass_sa/view_create_newp.php?id=".$curUser);
                        exit();
                    }                
                

                    $check_pass = password_verify($password, $db_pass);

                    if ($check_pass === true) {
                        $sql = "SELECT * FROM users WHERE username = '".$username."' AND id = '".$curUser ."'";
                        $result = mysqli_query($data, $sql);
                        $row = mysqli_fetch_array($result);

                        $sql1 = "SELECT * FROM yearsemester";
                        $result1 = mysqli_query($data, $sql1);
                        $row1 = mysqli_fetch_array($result1);								
            
                        if (!empty($row)) {

                            if ($row["userType"] == "superadmin") {
                                $_SESSION["sa_username"] = $username;
                                $_SESSION["yearSemID_t"] = $row1['id'];
                                $_SESSION["welcome"] = "Welcome $username. You are now logged in!";
                                header('Location: super_admin/HomePageSA.php?user=superadmin');
                                die();
                            }
                            
                            elseif ($row["userType"] == "admin") {
                                $_SESSION["a_username"] = $username;
                                $_SESSION["userID"] = $row['id'];
                                $_SESSION["yearSemID_t"] = $row1['id'];
                                $_SESSION["a_officeName"] = $row['officeName'];
                                $_SESSION["welcome"] = "Welcome $username. You are now logged in!";               
                                header('Location: admin/homePageAdmin.php?user=admin');
                                die();
                            }
                            elseif ($row["userType"] == "clerk") {
                                $_SESSION["c_username"] = $username;
                                $_SESSION["userID"] = $row['id'];
                                $_SESSION["yearSemID_t"] = $row1['id'];
                                $_SESSION["c_officeName"] = $row['officeName'];
                                $_SESSION["welcome"] = "Welcome $username. You are now logged in!";
                                header('Location: clerk/HomePageC.php?user=clerk');
                                die();
                            }
                            else {
                                echo "Unexpected error occured!";
                            }
                        }
                        else if (empty($row)) {
                            $_SESSION['invalid_match'] = "Email or Password does not match our records!";
                            header('Location: index.php?invalid=match');
            
                        }
                    }
                }
                       
            }
        }
       
    }
?>