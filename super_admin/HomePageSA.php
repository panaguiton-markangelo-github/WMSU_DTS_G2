<?php
session_start();
if(!isset($_SESSION["sa_username"])) {
  header("location: ../index.php");
}

include ("../include/alt_db.php");
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
                    <a href="all_docs.php"><span class="las la-file-alt"></span>
                    <span>All Documents</span></a>
                </li>
                <li>
                    <a href="offices.php"><span class="las la-building"></span>
                    <span>Offices</span></a>
                </li>
                <li>
                    <a href="clerk_users.php"><span class="las la-users"></span>
                    <span>Clerk Users</span></a>
                </li>
                <li>
                    <a href="admin_users.php"><span class="las la-user-cog"></span>
                    <span>Admin Users</span></a>
                </li>
                <li>
                    <a href="sem_year.php"><span class="las la-school"></span>
                    <span>School Year/Sem</span></a>
                </li> 
                <li>
                    <a href="settings.php"><span class="las la-cog"></span>
                    <span>Settings</span></a>
                </li>  
            </ul>
            
        </div>
    </div>

    <?php 
        if(isset($_SESSION['message'])){
            ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Successful!!',
                    html: '<h4><?php echo $_SESSION['message']?></h4>',
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
        if(isset($_SESSION['message_fail'])){
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Failed!!',
                    html: '<h4><?php echo $_SESSION['message_fail']?></h4>',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    confirmButtonText: 'OKAY!'
                });
            </script>
            <?php

            unset($_SESSION['message_fail']);
        }
    ?>

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
                    <h3><?php echo $_SESSION["sa_username"];?> <br> <span>Super admin</span></h3> 
                    <ul>
                        <?php
                            //include our connection
                            include_once('../include/database.php');

                            $database = new Connection();
                            $db = $database->open();
                            try{	
                                $sql = "SELECT * FROM users WHERE username = '".$_SESSION['sa_username']."'";
                    
                                foreach ($db->query($sql) as $row) {
                                ?>
                                    <li> <i class="las la-user-tie"></i> <a data-bs-toggle="modal" data-bs-target="#edit_profile<?php echo $row['id']; ?>">Edit Profile</a> </li>
                                <?php
                                
                                }
                            }
                            catch(PDOException $e){
                                echo "There is some problem in connection: " . $e->getMessage();
                            }

                            //close connection
                            $database->close();
                        ?>
                        <li> <i class="las la-folder-plus"></i> <a type="button" href="view_generate.php">Generate Report</a> </li>
                        <li> <i class="las la-chevron-circle-right"></i> <a type="button" data-bs-toggle="modal" data-bs-target="#logout_modal">Logout</a> </li>
                    </ul>
                               
                </div>
            </div>
        </header>
        
        <?php  include('../super_admin_funcs/view_edit_profile.php'); ?> 

        <main>
        <?php 
          if(!empty($row1)){
            ?>
            <div class="container" style="display:none;">
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <button style="margin-right:10px;" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#check-circle-fill"/></svg>
                    <div style="margin-left:10px;">
                    <?php 
                        echo "<h5>Thank you! Year and Semester has been successfully added!<h5>";
                    ?>
                    </div>
                </div>
            </div>
            <?php 
          }
              else{
                  ?>
                  <div class="container">
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                            <div style="margin-left:10px;">
                                <?php 
                                    echo "<h5>There is still no semester or year! please add it as soon as possible. Note: This may cause unwanted error in the system!<h5>";
                                ?>
                            </div>
                        </div>
                    </div>
                  <?php
              }
              ?>
    
        <div class="container">
            <div class="cards">
                <div class="card-single">
                    <div>
                        <?php 
                         $docs_query = 'SELECT * FROM documents;';
                         $docs_query_run = mysqli_query($data, $docs_query);

                         if($docs_total = mysqli_num_rows($docs_query_run))
                         {
                            echo '<h1> '.$docs_total.' </h1>' ;
                            if($docs_total <= 1) {
                                echo '<span>Document</span>';
                            }
                            else
                            {
                                echo '<span>Documents</span>';
                            }
                         }
                         else
                         {
                            echo '<span>No Documents</span>';
                         }
                        ?>    
                    </div>
                    <div>
                        <span class="las la-file-alt"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <?php 
                         $clerks_query = 'SELECT * FROM users WHERE userType = "clerk";';
                         $clerks_query_run = mysqli_query($data, $clerks_query);

                         if($clerks_total = mysqli_num_rows($clerks_query_run))
                         {
                            echo '<h1> '.$clerks_total.' </h1>' ;
                            if($clerks_total <= 1) {
                                echo '<span>Clerk User</span>';
                            }
                            else
                            {
                                echo '<span>Clerk Users</span>';
                            }
                         }
                         else
                         {
                            echo '<span>No Clerk User</span>';
                         }
                        ?>
                    </div>
                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <?php 
                         $admins_query = 'SELECT * FROM users WHERE userType = "admin";';
                         $admins_query_run = mysqli_query($data, $admins_query);

                         if($admins_total = mysqli_num_rows($admins_query_run))
                         {
                            echo '<h1> '.$admins_total.' </h1>' ;
                            if($admins_total <= 1) {
                                echo '<span>Admin User</span>';
                            }
                            else
                            {
                                echo '<span>Admin Users</span>';
                            }
                         }
                         else
                         {
                            echo '<span>No Admin User</span>';
                         }
                        ?>
                    </div>
                    <div>
                        <span class="las la-users-cog"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <?php 
                         $sem_year_query = 'SELECT * FROM yearsemester;';
                         $sem_year_query_run = mysqli_query($data, $sem_year_query);

                         if($sem_year_total = mysqli_num_rows($sem_year_query_run))
                         {
                            echo '<h1> '.$sem_year_total.' </h1>';
                            echo '<span>Year/Semester</span>';
                         
                            
                         }
                         else
                         {  
                            $_SESSION['upd_year_sem'] = $sem_year_total;
                            echo '<span>No Year/Semester</span>';
                         }
                        
                         
                         
                        ?>
                    </div>
                    <div>
                        <span class="las la-calendar"></span>
                    </div>
                </div>
            </div>

            <div class="tem-grid">
                <div class="documents">
                    <div class="card">
                        <div class="card-header">
                            <h3>Documents</h3>
                            <a href="all_docs.php">See all <span class="las la-arrow-right"></span></a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-cus">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>No.</td>
                                            <td> Tracking ID </td>
                                            <td> Title </td>
                                            <td> Type </td>
                                            <td> Reason </td>
                                            <td> Status </td>
                                            <td> View </td>
                                            <td> Track </td>                                       
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        //include our connection
                                        include_once('../include/database.php');
                                        

                                        $database = new Connection();
                                        $db = $database->open();
                                        try{	
                                            $sql = 'SELECT yearsemester.schoolYear, yearsemester.stat, documents.trackingID, 
                                            documents.title, documents.type, documents.reason, documents.remarks, documents.status, documents.file
                                            FROM yearsemester INNER JOIN documents ON yearsemester.id = documents.yearSemID LIMIT 5;';
                                            $no = 0;
                                            foreach ($db->query($sql) as $row) {
                                                $no++;
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['trackingID']; ?></td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td>
                                                <?php echo $row['type']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['reason']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($row['status'] == "pending"){
                                                    ?>
                                                        <span style="color: red;"> <?php echo $row['status']; ?> </span>
                                                <?php
                                                    }
                                                    else {
                                                    ?>
                                                        <span style="color: green;"> <?php echo $row['status']; ?> </span>
                                                <?php
                                                    }
                                                ?> 
                                            </td>
                                            <td>
                                                <form id="viewForm" action="view_documentSA.php" method="POST">
                                                    <input type="text" name="track_ID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                                                    <input type="text" name="title" id="title" value= "<?php echo $row['title'];?>" hidden>
                                                    <input type="text" name="type" id="type" value= "<?php echo $row['type'];?>" hidden>
                                                    <input type="text" name="reason" id="reason" value= "<?php echo $row['reason'];?>" hidden>
                                                    <input type="text" name="remarks" id="remarks" value= "<?php echo $row['remarks'];?>" hidden>
                                                    <input type="text" name="status" id="status" value= "<?php echo $row['status'];?>" hidden>
                                                    <input type="text" name="file" id="file" value= "<?php echo $row['file'];?>" hidden>

                                                    <input type="text" name="schoolYear" id="schoolYear" value= "<?php echo $row['schoolYear'];?>" hidden>
                                                    
                                                    <button id="submit" type="submit"><span class = "las la-info"></span></button>
                                                </form>
                                            </td>
                                            <td>
                                                <form id="trackForm" action="redirect_track.php" method="POST">
                                                    <input type="text" name="track_ID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                                                    <button id="submit" type="submit"> <span class = "las la-search-location"></span></button>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                    <?php 
                                            }
                                        }
                                        catch(PDOException $e){
                                            echo "There is some problem in connection: " . $e->getMessage();
                                        }

                                        //close connection
                                        $database->close();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="office">
                    <div class="card">
                        <div class="card-header">
                            <h3>Offices</h3>
                            <a href="offices.php">See all <span class="las la-arrow-right"></span> </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-cus">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>No.</td>
                                            <td> Office Name </td>
                                            <td> Description </td>
                                          
                                        </tr>
                                    </thead>
    
                                    <tbody>
                                    <?php
                                        //include our connection
                                        include_once('../include/database.php');
                                        

                                        $database = new Connection();
                                        $db = $database->open();
                                        try{	
                                            $sql = 'SELECT * FROM office LIMIT 5;';
                                            $no = 0;
                                            foreach ($db->query($sql) as $row) {
                                                $no++;
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['officeName']; ?></td>
                                            <td><?php echo $row['description'];?></td>
                                            
                                        </tr>

                                    <?php 
                                            }
                                        }
                                        catch(PDOException $e){
                                            echo "There is some problem in connection: " . $e->getMessage();
                                        }

                                        //close connection
                                        $database->close();
                                    ?>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>

                </div>

                <div class="users">
                    <div class="card">
                        <div class="card-header">
                            <h3>Admin Users</h3>
                            <a href="admin_users.php">See all <span class="las la-arrow-right"></span> </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-cus">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>No.</td>
                                            <td> Name </td>
                                            <td> Email </td>
                                            <td> Office </td>
                                        </tr>
                                    </thead>
    
                                    <tbody>
                                    <?php
                                        //include our connection
                                        include_once('../include/database.php');
                                        

                                        $database = new Connection();
                                        $db = $database->open();
                                        try{	
                                            $sql = 'SELECT * FROM users WHERE userType = "admin" LIMIT 5;';
                                            $no = 0;
                                            foreach ($db->query($sql) as $row) {
                                                $no++;
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['name'];?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td>
                                            <?php echo $row['officeName']; ?>
                                            </td>
                                        </tr>

                                    <?php 
                                            }
                                        }
                                        catch(PDOException $e){
                                            echo "There is some problem in connection: " . $e->getMessage();
                                        }

                                        //close connection
                                        $database->close();
                                    ?>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        
                    </div>

                </div>

                <div class="users">
                    <div class="card">
                        <div class="card-header">
                            <h3>Clerk Users</h3>
                            <a href="clerk_users.php">See all <span class="las la-arrow-right"></span> </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-cus">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>No.</td>
                                            <td> Name </td>
                                            <td> Email </td>
                                            <td> Office </td>
                                        </tr>
                                    </thead>
    
                                    <tbody>
                                    <?php
                                        //include our connection
                                        include_once('../include/database.php');
                                        

                                        $database = new Connection();
                                        $db = $database->open();
                                        try{	
                                            $sql = 'SELECT * FROM users WHERE userType = "clerk" LIMIT 5;';
                                            $no = 0;
                                            foreach ($db->query($sql) as $row) {
                                                $no++;
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['username'];?></td>
                                            <td>
                                                <?php echo $row['officeName']; ?>
                                            </td>
                                        </tr>

                                    <?php 
                                            }
                                        }
                                        catch(PDOException $e){
                                            echo "There is some problem in connection: " . $e->getMessage();
                                        }

                                        //close connection
                                        $database->close();
                                    ?>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>

                </div>

                <div class="yearSem">
                    <div class="card">
                        <div class="card-header">
                            <h3>Year and Semester</h3>
                            <a href="sem_year.php">See all <span class="las la-arrow-right"></span> </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-cus">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>No.</td>
                                            <td> Year </td>
                                            <td> Status </td>
                                        </tr>
                                    </thead>
    
                                    <tbody>
                                    <?php
                                        //include our connection
                                        include_once('../include/database.php');
                                        

                                        $database = new Connection();
                                        $db = $database->open();
                                        try{	
                                            $sql = 'SELECT * FROM yearsemester LIMIT 5;';
                                            $no = 0;
                                            foreach ($db->query($sql) as $row) {
                                                $no++;
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['schoolYear']; ?></td>
                                            <td><?php echo $row['stat'];?></td>
                                        </tr>

                                    <?php 
                                            }
                                        }
                                        catch(PDOException $e){
                                            echo "There is some problem in connection: " . $e->getMessage();
                                        }

                                        //close connection
                                        $database->close();
                                    ?>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
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

        <?php 
            if(isset($_SESSION['welcome'])){
                if ($sem_year_total > 0 && $clerks_total > 0 && $admins_total > 0) {
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
                }
                else if ($sem_year_total <= 0) {
                ?>
                <script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Greetings!(almost there)',
                        html: '<h4><?php echo $_SESSION['welcome'];?> <br><br> Note: Please do note that there is still no year/sem!.</h4>',                        
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: 'OKAY!'
                    });
                </script>
                <?php
                }
                else if ($clerks_total <= 0) {
                    ?>
                    <script>
                        Swal.fire({
                            icon: 'warning',
                            title: 'Greetings!(almost there)',
                            html: '<h4><?php echo $_SESSION['welcome'];?> <br><br> Note: Please do note that there is still no clerk user!.</h4>',                        
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            confirmButtonText: 'OKAY!'
                        });
                    </script>
                    <?php
                    }

                    else if (!$admins_total) {
                        ?>
                        <script>
                            Swal.fire({
                                icon: 'warning',
                                title: 'Greetings!(almost there)',
                                html: '<h4><?php echo $_SESSION['welcome'];?> <br><br> Note: Please do note that there is still no admin user!.</h4>',                        
                                showConfirmButton: true,
                                allowOutsideClick: false,
                                confirmButtonText: 'OKAY!'
                            });
                        </script>
                        <?php
                        }
                    else {
                        ?>
                        <script>
                            Swal.fire({
                                icon: 'warning',
                                title: 'Greetings!(almost there)',
                                html: '<h4><?php echo $_SESSION['welcome'];?> <br><br> Note: Please add a year/sem, clerk, and admin to officialy start the system.</h4>',                        
                                showConfirmButton: true,
                                allowOutsideClick: false,
                                confirmButtonText: 'OKAY!'
                            });
                        </script>
                        <?php
                        }
            unset($_SESSION['welcome']);
            }
        ?>


    <script>
        function menuToggle(){
            const toggleMenu = document.querySelector('.menu');
            toggleMenu.classList.toggle('active')
        }
    </script>
</body>
</html>