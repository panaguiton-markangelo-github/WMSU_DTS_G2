<?php
    session_start();
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
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if(empty($username) && empty($password)) {
            header('location: ../index.php?empty=both');
        }

        
        else if(empty($username)) {
            header('location: ../index.php?empty=email');
        }

        else if(empty($password)) {
            header('location: ../index.php?empty=pass');
        }

        else
        {
            if (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
                header('location: ../index.php?invalid=email');
            }
    
            else {
                $sql = "SELECT * FROM users  WHERE username = '".$username."' AND password = '".$password."'";
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
                header('Location: index.php?invalid=match');
    
                }
            }
        }

        

        
    }
?>