<?php
session_start();
if(!isset($_SESSION["a_username"])) {
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

    $query = "SELECT * FROM yearsemester";
    $result = mysqli_query($data, $query);
    $row = mysqli_fetch_array($result);


    $query1 = "SELECT officeName FROM users WHERE id = '".$_SESSION['userID']."'";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/footer.css">
</head>
<body style="background-color:#fff;">
    <nav class="navbar navbar-expand-sm navbar-dark border-bottom border-dark" style="background-color:#8e0413;">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold">WMSU|DTS</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link fw-bold" href="homePageAdmin.php">Home</a>
              </li> 

              <li class="nav-item">
                <a class="nav-link fw-bold">--></a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link active fw-bold" aria-current="page">Add Document</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <br>
      <br>

      
      <div class="container text-center">
        <h4>ADD DOCUMENT</h4> 
      </div>

      <br>

      <div class="container">
        <div id="liveAlertPlaceholder"></div>
      </div>

      <hr style="color: black;">
      <br>

      <div class="container">
        <form action="../admin_funcs/add_doc.php" id="mainForm" method="POST">

          <div class="row">
            <div class="col md-4">
              <div class="form-floating">
                <input type="text" class="form-control fs-4" id="trackingID" name="trackingID"  value="<?php echo $_POST["trackingID"] ?>" readonly>
                <label for="trackingID">Tracking ID</label>
              </div>
              <p class="text-center text-muted fw-bold">Please make sure to attach the correct <mark>Tracking ID</mark>on the document.</p>
            </div>
            <div class="col md-4">
              <div class="form-floating d-flex justify-content-center">
              <input type="text" class="form-control fs-4" id="title" name="title" placeholder="Title" maxlength="200" required>
              <label for="title" class="fs-5">Title</label>
              </div>
              <p class="text-center text-muted fw-bold"> Max Length: <mark>200</mark>characters.</p>
            </div>
          </div>

          <br>
          <br>

          <div class="row">
            <div class="col md-4">
              <select class="form-select text-dark" name="reason" aria-label="Default select example" required>
              <option selected>Reason</option>
              <option value="Appropriate Action">Appropriate Action</option>
              <option value="Coding/Deposit/Preparation of Receipt">Coding/Deposit/Preparation of Receipt</option>
              <option value="Comment/Reaction/Response">Comment/Reaction/Response</option>
              <option value="Compliance/Implementation">Compliance/Implementation</option>
              <option value="Dissemination of Information">Dissemination of Information</option>
              <option value="Draft of Reply">Draft of Reply</option>
              <option value="Endorsement/Recommendation">Endorsement/Recommendation</option>
              <option value="Follow-up">Follow-up</option>
              <option value="Investigation/Verification and Report">Investigation/Verification and Report</option>
              <option value="Notation and Return/File">Notation and Return/File</option>
              <option value="Notification/Reply to Party">Notification/Reply to Party</option>
              <option value="Study and Report to">Study and Report to</option>
              <option value="Translation">Translation</option>
              <option value="Your Information">Your Information</option>
              </select>
              <p class="text-center text-muted fw-bold">The reason for the document.</p>
            </div>

            <div class="col md-4">
              <select class="form-select text-dark" name="type" aria-label="Default select example" required>
              <option selected>Select Document Type</option>
              <option value="Certificate of Service">Certificate of Service</option>
              <option value="Disbursement of Service">Disbursement of Service</option>
              <option value="Inventory and Inspection Report">Inventory and Inspection Report</option>
              <option value="Letter">Letter</option>
              <option value="Liquidation Report">Liquidation Report</option>
              <option value="Memorandum">Memorandum</option>
              <option value="Memorandum of Agreement">Memorandum of Agreement</option>
              <option value="Memorandum Receipt">Memorandum Receipt</option>
              <option value="Official Cash Book">Official Cash Book</option>
              <option value="Personal Data Sheet">Personal Data Sheet</option>
              <option value="Purchase Order">Purchase Order</option>
              <option value="Purchase Request">Purchase Request</option>
              <option value="Referral Slip">Referral Slip</option>
              <option value="Request for Obligation of Allotments">Request for Obligation of Allotments</option>
              <option value="Requisition and Issue Voucher">Requisition and Issue Voucher</option>
              <option value="Unclassified">Unclassified</option>
              </select>
              <p class="text-center text-muted fw-bold">The type of the document.</p>
            </div>
          </div>

          <br>
          <br>
          <br>

          <div class="row">
            <div class="col md-4">
              <select class="form-select text-dark" name="yearSemID" id="yearSemID">
                <?php 
                  if(empty($row)) {
                    ?>
                    <option selected>No Year and Semester!</option>
                    <?php
                  }
                  else {
                    ?>
                      <option selected>Select Year/Semester:</option>
                    <?php
                  }
                ?>
                <?php
                  //include our connection
                  include_once('../include/database.php');

                  $database = new Connection();
                  $db = $database->open();
                  try{	
                      $sql = 'SELECT DISTINCT id, semester, schoolYear FROM yearsemester;'; 
                      foreach ($db->query($sql) as $row) {
                ?>
                  <option value="<?php echo $row['id']; ?>"> <?php echo $row['schoolYear']."-".$row['semester']; ?></option>
                  <?php
                  }

                }
                catch(PDOException $e){
                    echo "There is some problem in connection: " . $e->getMessage();
                }

                //close connection
                $database->close();
                  ?>
                </select>
                <p class="text-center text-muted fw-bold">Select the Year and Semester.</p>
            </div>

            <div class="col md-4">
              <div class="input-group">
              <span class="input-group-text">Remarks</span>
              <textarea class="form-control" name="remarks" aria-label="Remarks" maxlength="100"></textarea>
              </div>
              <p class="text-center text-muted fw-bold"> Max Length: <mark>100</mark>characters.</p>
            </div>      
          </div>

          <input name="user_id" type="number" value="<?php echo $_SESSION['userID'];?>" hidden>
          <input name="office" type="text" value="<?php echo $row1['officeName'] ?>" hidden>
          <input name="status" type="text" value="available" hidden>       

          <br>
          <br>
          <div class="d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#resetModal">Reset</button>
              <button type="submit" name="add" class="btn btn-success">Add Document</button>
            </div>
          </div>
        </form>
      </div>

      <br>
      <br>
      <br>

      <footer>
        <p>&copy;Copyright 2021 by <a href="#" class="text-white">WMSU</a>.</p>
      </footer>

    
      <!-- Modal for reset button-->
      <div class="modal fade" id="resetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="resetModalLabel">Reset</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <p>Are you sure to reset all the fields?</p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" for>No</button>
              <button type="reset" class="btn btn-success" id="liveAlertBtn" data-bs-dismiss="modal" form="mainForm">Yes</button>
              
           </div>
         </div>
       </div>
      </div>

      <script>
        var alertPlaceholder = document.getElementById('liveAlertPlaceholder')
        var alertTrigger = document.getElementById('liveAlertBtn')

        function alert(message, type) {
          var wrapper = document.createElement('div')
          wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'

          alertPlaceholder.append(wrapper)
        }

        if (alertTrigger) {
          alertTrigger.addEventListener('click', function () {
            alert('Fields has been successfully reset', 'success')
          })
        }

      </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>