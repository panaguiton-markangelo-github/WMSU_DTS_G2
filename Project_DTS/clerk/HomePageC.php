<?php
session_start();
if(!isset($_SESSION["c_username"])) {
  header("location: ../index.php");
}

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
try {
    function count_characters(string $string) {
        return count(preg_split('//', $string, -1, PREG_SPLIT_NO_EMPTY));
      }

    $query = "SELECT documents.* FROM documents ORDER BY id desc LIMIT 1;";
    $result = mysqli_query($data, $query);
    $row = mysqli_fetch_array($result);

    if (empty($row)) {
        $trackID = date("Y")."-000"."1";
        $_SESSION["trackID"] = $trackID;
        
    }
    else if (empty($row) == False)
    {       
            $last_tracking_id = $row['trackingID'];
            $no_chars = count_characters($last_tracking_id);
            $trackID = substr($last_tracking_id, $no_chars - 1);
            $trackID = intval($trackID);
            $trackID = date("Y")."-000".$trackID + 1;
            $_SESSION["trackID"] = $trackID;

    }

}
catch(PDOException $e) {
    $_SESSION['message'] = $e->getMessage();
}

?>

<?php
try {
    $query1 = "SELECT * FROM yearsemester";
    $result1 = mysqli_query($data, $query1);
    $row1 = mysqli_fetch_array($result1);
   
}
catch(PDOException $e) {
    $_SESSION['message'] = $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-sacle=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/loading.css">
    <script src="../assets/js/sweet_alert.js"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
    </svg>
    <div id="preloader">
    </div>

    <input type="checkbox" id="nav-toggle">

    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="las la-book"></span> <span>WMSU|DTS</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a class="active"><span class="las la-home"></span>
                    <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="view_track.php"><span class="las la-search-location"></span>
                    <span>Track Documents</span></a>
                </li>
                <li>
                    <a href="office_docs.php"><span class="las la-file-alt"></span>
                    <span>Office Documents</span></a>
                </li>
                <li>
                    <a href="pending_docs.php"><span class="las la-arrow-circle-up"></span>
                    <span>Pending For Release</span></a>
                </li>
                <li>
                    <a href="received_docs.php"><span class="las la-arrow-circle-down"></span>
                    <span>Received</span></a>
                </li>
                <li>
                    <a href="released_docs.php"><span class="las la-chevron-circle-up"></span>
                    <span>Released</span></a>
                </li>   
                <li>
                    <a href="terminal_docs.php"><span class="las la-check-circle"></span>
                    <span>Tagged As Terminal</span></a>
                </li> 
               
            </ul>
        </div>
    </div>
    
    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>
                Dashboard
            </h2>

            <div class="user-wrapper">
                <div class="profile" onclick="menuToggle();">
                    <img src="../assets/img/wmsu_logo.png" alt="user">
                </div>   
                <div class="menu">
                    <h3><?php echo $_SESSION["c_username"]; ?> (<?php echo $_SESSION['c_officeName']; ?>) <span>clerk</span></h3> 
                    <ul>
                        <?php
                            //include our connection
                            include_once('../include/database.php');

                            $database = new Connection();
                            $db = $database->open();
                            try{	
                                $sql = "SELECT * FROM users WHERE username = '".$_SESSION['c_username']."'";
                    
                                foreach ($db->query($sql) as $row) {
                                ?>
                                    <li> <span class="las la-user-tie"></span> <a data-bs-toggle="modal" data-bs-target="#edit_profile<?php echo $row['id']; ?>">Edit Profile</a> </li>
                                <?php
                                
                                }
                            }
                            catch(PDOException $e){
                                echo "There is some problem in connection: " . $e->getMessage();
                            }

                            //close connection
                            $database->close();
                        ?>
                        
                        <li> <span class="las la-chevron-circle-right"></span> <a type="button" data-bs-toggle="modal" data-bs-target="#logout_modal">Logout</a> </li>
                    </ul>
                              
                </div>
            </div>
        </header>

        <?php  include('../clerk_funcs/view_edit_profile.php'); ?> 

        <main>
        <?php 
          if(empty($row1)){
              ?>
              <div class="container">
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                      <div style="margin-left:10px;" class="text-center">
                        <?php 
                            echo "<h5>There is still no semester or year! please ask the super administrator to add it as soon as possible. <br> Note: This may cause unwanted error in the system!<h5>";
                        ?>
                      </div>
                  </div>
              </div>
              <?php
          }
        ?>

        <?php   
            if(isset($_SESSION['message_terminal'])){
                ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Successful!!',
                        html: '<h4><?php echo $_SESSION['message_terminal']." With the tracking ID"." of <b>".$_SESSION['trackingID']."</b>." ?></h4>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: 'OKAY!'
                    });
                </script>
                <?php

                unset($_SESSION['message_terminal']);
            }
        ?>

        <?php 
            if(isset($_SESSION['message_release'])){
                ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Successful!!',
                        html: '<h4><?php echo $_SESSION['message_release']." With the tracking ID"." of <b>".$_SESSION['trackingID']."</b>." ?></h4>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: 'OKAY!'
                    });
                </script>
                <?php

                unset($_SESSION['message_release']);
            }
        ?>

        <?php 
            if(isset($_SESSION['message_receive'])){
                ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Successful!!',
                        html: '<h4><?php echo $_SESSION['message_receive']." With the tracking ID"." of <b>".$_SESSION['trackingID']."</b>." ?></h4>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: 'OKAY!'
                    });
                </script>
                <?php

                unset($_SESSION['message_receive']);
            }
        ?>
        
        <?php 
            if(isset($_SESSION['e_message'])){
                ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!!',
                        html: '<h4><?php echo $_SESSION['e_message']." "." With the tracking ID of <b>".$_SESSION['e_id']."</b>.";?></h4>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: 'OKAY!'
                    });
                </script>
                <?php

                unset($_SESSION['e_message']);
            }
        ?>

        <?php 
            if(isset($_SESSION['message'])){
                ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Successful!!',
                        html: '<h4><?php echo $_SESSION['message']." "."The final tracking ID is: <b>".$_SESSION['no_final_trackID']."</b>. Please do attach the correct tracking ID on the document.";?></h4>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: 'OKAY!'
                    });
                </script>
                <?php

                unset($_SESSION['message']);
            }
        ?>

        <?php 
            if(isset($_SESSION['message_profile'])){
                ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Successful!!',
                        html: '<h4><?php echo $_SESSION['message_profile'] ;?></h4>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: 'OKAY!'
                    });
                </script>
                <?php

                unset($_SESSION['message_profile']);
            }
        ?>

        <?php 
            if(isset($_SESSION['welcome'])){
                ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Greetings!',
                        html: '<h4><?php echo $_SESSION['welcome'];?></h4>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: 'OKAY!'
                    });
                </script>
                <?php
                unset($_SESSION['welcome']);
            }
        ?>

        <div class="container">
            <div class="tem-grid">
                <div class="row">
                    <div class="col">
                        <form action="../clerk_funcs/redirect_track.php" method="POST">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control border border-dark" name="trackingID" placeholder="Tracking ID" required>
                            <button class="btn btn-outline-success fw-bold" type="submit" id="button-addon2">Track Document</button>
                            </div>
                        </form>                      
                    </div>

                    <div class="col">
                       <form action="add_docs.php" method="POST">
                            <div class="input-group mb-3">
                                <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_SESSION["userID"];?>" hidden>
                                <input type="text" name="trackingID" class="form-control border border-dark" value="<?php echo $_SESSION["trackID"];?>" aria-label="Tracking ID" aria-describedby="button-addon2" readonly>
                                <button class="btn btn-outline-success fw-bold" type="submit" id="button-addon2">Add Document</button>
                            </div>
                       </form>
                    </div>
                </div>

                            
                <div class="row d-flex justify-content-center">
                    <div class="col-8">
                        <form action="release_document.php" method="POST">
                        <div class="input-group mb-3">
                            <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_SESSION["userID"];?>" hidden>
                            <input type="text" name="trackingID" class="form-control border border-dark" placeholder="Tracking ID" required>
                            <button class="btn btn-outline-success fw-bold" type="submit" id="button-addon2">Release Document</button>
                        </div>
                        </form> 


                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <form action="../clerk_funcs/view_receive.php" method="POST">
                            <div class="input-group mb-3">
                            <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_SESSION["userID"];?>" hidden>
                            <input type="text" name="rec_trackingID" id="rec_trackingID" class="form-control border border-dark" placeholder="Tracking ID" required>
                            <button class="btn btn-outline-success fw-bold" type="submit" id="recBut">Receive Document</button>
                            </div>
                        </form>                      
                    </div>

                    <div class="col">
                        <form action="../clerk_funcs/view_terminal.php" method="POST">
                            <div class="input-group mb-3">
                            <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_SESSION["userID"];?>" hidden>
                            <input type="text" name="termTrackingID" id="termTrackingID" class="form-control border border-dark" placeholder="Tracking ID" required>
                            <button class="btn btn-outline-success fw-bold" type="submit" id="termBut">Tag as Terminal</button>
                            </div>
                        </form>    
                                    
                    </div>
                </div>
            </div>
        </div>

        </main>
    </div>
   
    <footer>
        <p>&copy;Copyright 2021 by <a href="#" class="text-dark">WMSU</a>.</p>
    </footer>

    <?php include('../validation/view_logout.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <script>
        var loader =  document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
	</script>

    <script>
        function menuToggle(){
            const toggleMenu = document.querySelector('.menu');
            toggleMenu.classList.toggle('active')
        }
    </script>
</body>
</html>