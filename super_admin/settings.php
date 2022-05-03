<?php
session_start();
if(!isset($_SESSION["sa_username"])) {
  header("location: ../index.php");
}
include ("../include/alt_db.php");
?>

<?php
try {

    $query1 = "SELECT * FROM yearsemester WHERE activated= 'yes'";
    $result1 = mysqli_query($data, $query1);
    $row1 = mysqli_fetch_array($result1);
}
catch(PDOException $e) {
    $_SESSION['message'] = $e->getMessage();
}

try {

    $query2 = "SELECT * FROM dateRange ORDER BY id DESC LIMIT 1;";
    $result2 = mysqli_query($data, $query2);
    $row2 = mysqli_fetch_array($result2);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/loading.css">
    <script src="../assets/js/sweet_alert.js"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <div id="preloader">
	</div>

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

    <input type="checkbox" id="nav-toggle">
    
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="las la-book"></span> <span>WMSU|DTS</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="HomePageSA.php"><span class="las la-home"></span>
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
                    <a href="archives.php"><span class="las la-file-excel"></span>
                    <span>Archives</span></a>
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
                    <a href="types.php"><span class="las la-passport"></span>
                    <span>Document types</span></a>
                </li>
                <li>
                    <a href="reasons.php"><span class="las la-file-invoice"></span>
                    <span>Document reasons</span></a>
                </li>
                <li>
                    <a href="sem_year.php"><span class="las la-school"></span>
                    <span>School Year/Sem</span></a>
                </li>
                <li>
                    <a class="active"><span class="las la-cog"></span>
                    <span>Settings</span></a>
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
                Settings
            </h2>

        
            <div class="user-wrapper">
                <div class="profile" onclick="menuToggle();">
                    <span class="las la-user-alt" style="font-size: 50px;color:#8e0413;"></span>
                </div>   
                <div class="menu">
                    <h3><?php echo $_SESSION["sa_username"]; ?> <br> <span>Super admin</span></h3> 
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
                        <li> <i class="las la-file-export"></i> <a type="button" href="view_generate.php">Generate Report</a> </li>
                        <li> <i class="las la-chevron-circle-right"></i> <a type="button" data-bs-toggle="modal" data-bs-target="#logout_modal">Logout</a> </li>
                    </ul>
                               
                </div>
            </div>
        </header>

        <?php  include('../super_admin_funcs/view_edit_profile.php'); ?> 


        <main>
           <div class="container">
                <?php
                    if(empty($row2)){
                        ?>
                        <div class="container">
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                <div style="margin-left:10px;text-align:center;">
                                    <?php 
                                        echo "<h5>No date range set for semesters and summer. Please click initialize default date range first.<h5>";
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
        
                    }
                ?> 
           </div>
           <div class="row d-flex justify-content-start">
                    <?php
                        if(empty($row2)){
                            ?>
                            <div class="col-3">
                                <a class="btn btn-primary mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#default_modal">Initialize Default Date Range</a>
                                <p style="text-align:center;color:orange;"> <span class="las la-info-circle"></span> Initialize the date range for all semesters and summer. Note: This will be disappeared after succesfull initialization of date range.</p>
                            </div>
                            <?php
                        }
                    ?>
                    
                </div>

                <div class="row d-flex justify-content-start">
                    <?php
                        if(!empty($row2)){
                            ?>
                            <div class="col-3">
                                <a class="btn btn-primary mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#fsem_modal<?php echo $row2['id']; ?>">Edit Date Range 1st sem</a>
                                <p style="color:orange;"> <span class="las la-info-circle"></span> Edit the date range for the 1st semester.</p>
                            </div>
                        <?php
                        }
                    ?>
                </div>

                <div class="row d-flex justify-content-start">
                    <?php
                        if(!empty($row2)){
                            ?>
                            <div class="col-3">
                                <a class="btn btn-primary mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#ssem_modal<?php echo $row2['id']; ?>">Edit Date Range 2nd sem</a>
                                <p style="color:orange;"> <span class="las la-info-circle"></span> Edit the date range for the 2nd semester.</p>
                            </div>
                            <?php
                        }
                    ?>
                </div>

                <div class="row d-flex justify-content-start">
                    <?php
                        if(!empty($row2)){
                            ?>
                            <div class="col-3">
                                <a class="btn btn-primary mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#sm_modal<?php echo $row2['id']; ?>">Edit Date Range summer</a>
                                <p style="color:orange;"> <span class="las la-info-circle"></span> Edit the date range for the summer.</p>
                            </div>
                            <?php
                        }
                    ?>
                </div>
       </main>
    </div>

    <script>
        var loader =  document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
	</script>

    <?php 
            if(isset($_SESSION['message'])){
                ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Successful!!',
                        html: '<h4><?php echo $_SESSION['message'];?></h4>',
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
            if(isset($_SESSION['e_message'])){
                ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: '<h4><?php echo $_SESSION['e_message'];?></h4>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: 'OKAY!'
                    });
                </script>
                <?php

                unset($_SESSION['e_message']);
            }
        ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   
    <?php include('../super_admin_funcs/view_add_year_sem.php'); ?>
    <?php include('../super_admin_funcs/view_1st_sem_date_range.php'); ?>
    <?php include('../super_admin_funcs/view_add_default.php'); ?>
    <?php include('../super_admin_funcs/view_2nd_sem_date_range.php'); ?>
    <?php include('../super_admin_funcs/view_summer_date_range.php'); ?>
    <?php include('../validation/view_logout.php'); ?>
    
    <footer>
        <p>&copy;Copyright 2021 by <a href="#" class="text-dark">WMSU</a>.</p>
    </footer>

    <script>
        function menuToggle(){
            const toggleMenu = document.querySelector('.menu');
            toggleMenu.classList.toggle('active')
        }
    </script>

</body>
</html>