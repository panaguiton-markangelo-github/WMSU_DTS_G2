<?php
session_start();
if(!isset($_SESSION["c_username"])) {
  header("location: ../index.php");
}

include ("../include/alt_db.php");
include("../include/database.php");

?>

<?php
try {

    $query = "SELECT * FROM yearsemester WHERE activated = 'yes'";
    $result = mysqli_query($data, $query);
    $row = mysqli_fetch_array($result);


    $query1 = "SELECT officeName FROM users WHERE id = '".$_SESSION['userID']."'";
    $result1 = mysqli_query($data, $query1);
    $row1 = mysqli_fetch_array($result1);

    $query2 = "SELECT id FROM office WHERE officeName = '".$_SESSION['c_officeName']."'";
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
    <link rel="icon" type="image/png" href="../assets/img/wmsu_logo.png"/>
    <title>Add Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/checkbox.css">
</head>
<body style="background-color:#fff;">
    <script>
      function toggle(source) {
        checkboxes = document.getElementsByClassName('officeName');
        for(var i=0, n=checkboxes.length;i<n;i++) {
          checkboxes[i].checked = source.checked;
        }
      }
    </script>
    <nav class="navbar navbar-expand-sm navbar-dark border-bottom border-dark" style="background-color:#8e0413;">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold">WMSU|DTS</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link fw-bold" href="HomePageC.php">Home</a>
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
        <form action="../clerk_funcs/add_doc.php" id="mainForm" method="POST" enctype="multipart/form-data">

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
              <p class="text-center text-muted fw-bold"> Max Length: <mark>200</mark>characters <span style="color:red;">(required)</span>.</p>
            </div>
          </div>

          <br>
          <br>

          <div class="row">
            <div class="col">
              <select class="form-select text-dark" name="reason" onchange="checkvalue1(this.value)" aria-label="Default select example" required>
              <option value="" disabled selected>Reason</option>
                <?php
                    $database = new Connection();
                    $db = $database->open();
                    try{	
                        $sql = 'SELECT * FROM reasons ORDER BY reason ASC;'; 
                        foreach ($db->query($sql) as $rows) {
                  ?>
                    <option value="<?php echo $rows['reason']; ?>"> <?php echo $rows['reason'];?> </option>
                    <?php
                    }

                  }
                  catch(PDOException $e){
                      echo "There is some problem in connection: " . $e->getMessage();
                  }

                  //close connection
                  $database->close();
                ?> 
              <option value="other">Other</option>
              </select>
              
              <input type="text" name="oreason" id="checkR" placeholder="Please enter here the reason:" style='display:none'/>
              <p class="text-center text-muted fw-bold">The reason for the document <span style="color:red;">(required)</span>.</p>
            </div>

            <div class="col">
              <select class="form-select text-dark" name="type" onchange="checkvalue(this.value)" aria-label="Default select example" required>
                <option value="" disabled selected>Select Document Type</option>
                  <?php
                      $database = new Connection();
                      $db = $database->open();
                      try{	
                          $sql = 'SELECT * FROM types ORDER BY type ASC;'; 
                          foreach ($db->query($sql) as $rows) {
                    ?>
                      <option value="<?php echo $rows['type']; ?>"> <?php echo $rows['type'];?> </option>
                      <?php
                      }

                    }
                    catch(PDOException $e){
                        echo "There is some problem in connection: " . $e->getMessage();
                    }

                    //close connection
                    $database->close();
                  ?>
                <option value="other">Other</option>
              </select>

              <input type="text" name="otype" id="checkT" placeholder="Please enter here the type:" style='display:none'>
              <p class="text-center text-muted fw-bold">The type of the document <span style="color:red;">(required)</span>.</p>
            </div>
          </div>

          <br>
          <br>
          <br>

          <div class="row">
            <div class="col md-4">
              <input type="file" name="file">
              <p class="text-center text-muted fw-bold"> File upload(optional: only pdf and img are allowed with maximun size of 50mb)</p>
            </div>

            <div class="col md-4">
              <div class="input-group">
              <span class="input-group-text">Remarks</span>
              <textarea class="form-control" name="remarks" aria-label="Remarks" maxlength="100"></textarea>
              </div>
              <p class="text-center text-muted fw-bold"> Max Length(optional): <mark>100</mark>characters.</p>
            </div>      
          </div>

          <div class="row">
            <div class="col">
              <br>
              <p class="text-center text-muted fw-bold">Please select the recipient/s. Note: You can select more than one <span style="color:red;">(required)</span>.</p>
              <div class="boxes">
                  <input name="select-all" onClick="toggle(this)" type="checkbox" id="select-all" value="select-all">
                  <label for="select-all">All</label>
                <?php
                      $database = new Connection();
                      $db = $database->open();
                      try{	
                          $sql = "SELECT * FROM office WHERE officeName NOT IN ('".$_SESSION['c_officeName']."') ORDER BY officeName ASC;"; 
                          foreach ($db->query($sql) as $row3) {
                    ?>
                      <input class="officeName" name="officeName[]" type="checkbox" id="<?php echo $row3['officeName'];?>" value="<?php echo $row3['officeName'];?>">
                      <label for="<?php echo $row3['officeName'];?>"><?php echo $row3['description'];?></label>
                      <?php
                      }

                    }
                    catch(PDOException $e){
                        echo "There is some problem in connection: " . $e->getMessage();
                    }
                    //close connection
                    $database->close();
                  ?>
              </div>
            </div>
          </div>

          <input name="user_id" type="number" value="<?php echo $_SESSION['userID'];?>" hidden>
          <input name="office" type="text" value="<?php echo $row1['officeName'] ?>" hidden>
          <input name="officeID" type="text" value="<?php echo $row2['id'] ?>" hidden>
          <input name="schoolYear" type="text" value="<?php echo $row['schoolYear'] ?>" hidden>
          <input name="schoolYear_id" type="text" value="<?php echo $row['id'] ?>" hidden>
          <input name="status_draft" type="text" value="draft" hidden>    
          <input name="status_rel" type="text" value="released" hidden>  

          <br>
          <br>
          <div class="d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#resetModal">Reset</button>
              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#draftModal">Save as draft</button>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#releaseModal">Save and Release Document</button>
            </div>
          </div>
        </form>
      </div>

      <br>
      <br>
      <br>

      <footer>
        <p>&copy;Copyright 2021 by WMSU.</p>
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

      <!-- Modal for draft button-->
      <div class="modal fade" id="draftModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="resetModalLabel">Save as Draft</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <p style="text-align: center;">The document will be saved as draft and will need to be released in this office in order to be processed by other office/s.
                <br> <b>Note:This document can be released later at the pending for release tab at the home page.</b>
              </p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" for>Close</button>
              <button type="submit" name="draft" class="btn btn-success" data-bs-dismiss="modal" form="mainForm">Save changes</button>
              
           </div>
         </div>
       </div>
      </div>

      <!-- Modal for release document-->
      <div class="modal fade" id="releaseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="releaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="resetModalLabel">Save and Release Document</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

              <p class="text-center"> Are you sure to create and release the document now? The status of document would be the default which is "released",
                this can be modify in the office documents tab of the home page.
                <br>
                <b> Note: other offices will now be able to process this document if it was received by them. </b> </p>
            
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" for>No</button>
              <button type="submit" class="btn btn-success" name="add" data-bs-dismiss="modal" form="mainForm">Yes</button>
              
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

      <script>
        function checkvalue(val)
          {
              if(val==="other")
              {
                document.getElementById('checkT').style.display='block';
                document.getElementById('checkT').style.marginTop='12px';
              }
              else{
                document.getElementById('checkT').style.display='none'; 
              }
                
          }

        function checkvalue1(val)
        {
            if(val==="other")
            {
              document.getElementById('checkR').style.display='block';
              document.getElementById('checkR').style.marginTop='12px';
            }
            else{
              document.getElementById('checkR').style.display='none'; 
            }
              
        }
      </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>