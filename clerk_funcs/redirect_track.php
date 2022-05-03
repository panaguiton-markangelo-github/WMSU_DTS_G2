<?php
session_start();
if(!isset($_SESSION["c_username"])) {
  header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Documents</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/loading.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
                    <a href="../clerk/HomePageC.php"><span class="las la-home"></span>
                    <span>Dashboard</span></a>
                </li>
                <li>
                    <a class="active"><span class="las la-search-location"></span>
                    <span>Track Documents</span></a>
                </li>
                <li>
                    <a href="../clerk/office_docs.php"><span class="las la-file-alt"></span>
                    <span>Office Documents</span></a>
                </li>
                <li>
                    <a href="../clerk/pending_docs.php"><span class="las la-arrow-circle-up"></span>
                    <span>Pending For Release</span></a>
                </li>
                <li>
                    <a href="../clerk/received_docs.php"><span class="las la-arrow-circle-down"></span>
                    <span>Received</span></a>
                </li>
                <li>
                    <a href="../clerk/released_docs.php"><span class="las la-chevron-circle-up"></span>
                    <span>Released</span></a>
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
                Track Documents
            </h2>

            <div class="user-wrapper">
                <div class="profile" onclick="menuToggle();">
                    <span class="las la-user-alt" style="font-size: 50px;color:#8e0413;"></span>
                </div>   
                <div class="menu">
                    <h3><?php echo $_SESSION["c_username"]; ?> <br> (<?php echo $_SESSION['c_officeName']; ?>) <span>clerk</span></h3> 
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
        

        <?php  include('../clerk_funcs/view_edit_profile.php'); ?>
        
       <main>
        <div class="px-3 px-sm-5 pt-4">
            <h2 class="mb-4">
            <span class='las la-search-location text-success'></span> Track Documents
            </h2>
            <form id="trackingForm">
                <div class="input-group input-group-lg mb-5">
                    <input type="text" class="form-control" id="trackID" name="trackID"
                    placeholder="Enter Tracking ID here...." value="<?php echo $_POST['trackingID'];?>">
                    <button class="btn btn-success" type="button" id="btnSearch"
                    name="btnSearch"><span class = "las la-search"></span> Track</button>
                </div>
            </form>
            <div style="display: block;" id="hideTable">
            
                <div class="text-center">
                    <h3>
                        <span class="las la-exclamation-triangle text-danger"></span>
                        NO DATA AVAILABLE....                
                    </h3>
                </div>
            </div>
        </div>

           <div class="container">
               <div class="row" style="display: none;" id="showTable">
                <div class="table-responsive">
                    <h1 class="text-center">Records</h1>
                        <table id="data_table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> No. </th> 
                                    <th> Tracking ID </th>                              
                                    <th> Action by </th>
                                    <th >Originating Office</th>
                                    <th >Current Office</th>
                                    <th >Status</th>                                 
                                    <th >Added at</th>
                                    <th >Received at</th>
                                    <th >Released at</th>
    
                                    <th >Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="showData">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
       </main>
    </div>
    
    <?php include('../validation/view_logout.php'); ?>
    <script src="../assets/js/sweet_alert.js"></script>

    <script>
        var loader =  document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
	</script>

    <script>
        $(document).ready(function() {
            $("#btnSearch").click(function(e) {
                e.preventDefault();
                var trackID = $("#trackID").val();
                $.ajax({
                    type: "POST",
                    url: "../clerk_funcs/track.php",
                    data: $("#trackingForm").serialize(),
                    beforeSend: function() {
                        Swal.fire({
                            icon: 'info',
                            html: "<h1>&nbsp;Please wait ...</h1>",
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    },
                    success: function(data) {
                        if (data == '') {
                            Swal.fire({
                                icon: 'warning',
                                html: "<h4>Please enter the Tracking ID! <br><br> Note: Please make sure the tracking ID is also correct!</h3>",
                                showConfirmButton: true,
                                allowOutsideClick: false
                            });
                        } 
                        else {
                            Swal.fire({
                                icon: 'success',
                                html: "<h1>Success!</h1>",
                                showConfirmButton: true,
                                allowOutsideClick: false
                            });

                            document.getElementById("showTable").style.display = "block";
                            document.getElementById("hideTable").style.display = "none";
                            $('#showData').html(data);
                        }
                    }
                });
                return false;
            });
        });
    </script>

   
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

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