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
    <title>Forward Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/checkbox.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body style="background-color:#fff;">
    <script>
      $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $(':officeName').each(function() {
                this.checked = true;                        
            });
        } else {
            $(':officeName').each(function() {
                this.checked = false;                       
            });
        }
    }); 
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
                <span class="nav-link fw-bold">--></span>
              </li>

              <?php if(!empty($_POST['rec_link'])){
                  ?>
                  <li class="nav-item">
                    <a class="nav-link fw-bold" href="received_docs.php">Received Documents</a>
                </li> 
                  <?php
              }
              else{
                  ?>     
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="released_docs.php">Released Documents</a>
                </li> 
                  <?php
              }
              ?>

              <li class="nav-item">
                <span class="nav-link fw-bold">--></span>
              </li>
              
              <li class="nav-item">
                <a class="nav-link active fw-bold" aria-current="page">Forward Document</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <br>
      <br>

      <div class="container text-center">
        <h4>Forward DOCUMENT</h4> 
      </div>

      <br>

      <div class="container">
        <div id="liveAlertPlaceholder"></div>
      </div>

      <hr style="color: black;">
      <br>

      <div class="container">
      <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                  <th class="text-center fs-4" colspan="2">OVERVIEW OF <?php echo $_POST['trackingID'];?></th>
                </tr>
            </thead>

            <tbody>
              <tr>
                <th class="fs-5 text-center">
                    Tracking ID:
                </th>

                <td class="fs-5 text-center">
                    <?php echo $_POST['trackingID'];?>
                </td>
              </tr>

              <tr>
                  <th class="fs-5 text-center">
                      Title:
                  </th>

                  <td class="fs-5 text-center">
                      <?php echo $_POST['title'];?>
                  </td>
              </tr>

              <tr>
                  <th class="fs-5 text-center">
                      Type:
                  </th>

                  <td class="fs-5 text-center">
                      <?php echo $_POST['type'];?>
                  </td>
              </tr>

              <tr>
                  <th class="fs-5 text-center">
                      Reason:
                  </th>

                  <td class="fs-5 text-center">
                      <?php echo $_POST['reason'];?>
                  </td>
              </tr>

              <tr>
                  <th class="fs-5 text-center">
                      Status:
                  </th>

                  <td class="fs-5 text-center">
                    <?php
                        if ($_POST['status'] == "draft"){
                        ?>
                            <span style="color: red;"><?php echo $_POST['status']; ?></span>
                    <?php
                        }
                        else {
                        ?>
                            <span style="color: green;"><?php echo $_POST['status']; ?></span>
                        <?php
                        }
                    ?>
                  </td>
              </tr>
            </tbody>
          </table>
        </div>

        <form action="../clerk_funcs/for_doc.php" id="mainForm" method="POST" >

          <br>
          <br>
          <div class="row">
              <div class="col md-4">
                <div class="input-group mb-3">
                <label class="input-group-text" for="trackingID">Tracking ID</label>
                <input type="text" class="form-control" name="trackingID" value="<?php echo $_POST['trackingID']?>" id = "trackingID" readonly>
                </div>
                <p class="text-center text-muted fw-bold">Tracking ID of the document.</p>
              </div>

            <div class="col">
              <div class="boxes">
                  <input name="select-all" type="checkbox" id="select-all" value="select-all">
                  <label for="select-all">All</label>
                <?php
                      $database = new Connection();
                      $db = $database->open();
                      try{	
                          $sql = 'SELECT * FROM office ORDER BY officeName ASC;'; 
                          foreach ($db->query($sql) as $row1) {
                    ?>
                      <input name="officeName[]" type="checkbox" id="<?php echo $row1['officeName'];?>" value="<?php echo $row1['officeName'];?>">
                      <label for="<?php echo $row1['officeName'];?>"><?php echo $row1['officeName'];?></label>
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
            <p class="text-center text-muted fw-bold">You can select multiple recipients.</p>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <select class="form-select text-dark" name="reason" onchange="checkvalue1(this.value)" aria-label="Default select example" required>
              <option value="" selected>Reason</option>
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
              <p class="text-center text-muted fw-bold">The reason for the document.</p>
            </div>

              <div class="col md-4">
              <div class="input-group">
              <span class="input-group-text">Remarks</span>
              <textarea class="form-control" name="remarks" aria-label="Remarks" maxlength="100"></textarea>
              </div>
              <p class="text-center text-muted fw-bold"> Max Length(optional): <mark>100</mark>characters.</p>
            </div>   
            
          </div>

          <br>
          <br>
          <br>

             
          </div>
    
          <input name="status" type="text" value="forwarded" hidden>  
          <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_POST["userID"];?>" hidden> 
          <input name="userID" type="number" value="<?php echo $_SESSION['userID'];?>" hidden>

          <br>
          <br>
          <div class="d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#resetModal">Reset</button>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#forwardModal">Save and Forward</button>
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

  
      <!-- Modal for release document-->
      <div class="modal fade" id="forwardModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="releaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="resetModalLabel">Save and Forward Document</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

              <p class="text-center"> Are you sure to save and forward this document to the specified office/s?
                <br>
                <b> Note: This document will now be tagged as forwarded. </b> </p>
            
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" for>No</button>
              <button type="submit" class="btn btn-success" name="submit" data-bs-dismiss="modal" form="mainForm">Yes</button>
              
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