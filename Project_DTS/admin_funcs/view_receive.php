<?php
session_start();
if(!isset($_SESSION["a_username"])) {
  header("location: ../index.php");
}
?>

<?php
//include our connection
include_once('../include/database.php');

$database = new Connection();
$db = $database->open();
try{	
    $sql = "SELECT documents.trackingID, documents.title, documents.type, documents.reason, documents.status, documents.remarks, logs.office, logs.origin_office FROM documents 
    INNER JOIN logs ON documents.trackingID = logs.trackingID 
    WHERE documents.trackingID = '".$_POST['rec_trackingID']."' ORDER BY logs.id DESC LIMIT 1;";
    foreach ($db->query($sql) as $row) {
      }
    }
catch(PDOException $e){
    echo "There is some problem in connection: " . $e->getMessage();
    }

    //close connection
    $database->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Release Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/footer.css">
</head>
<body style="background-color:#fff;">
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

    <nav class="navbar navbar-expand-sm navbar-dark border-bottom border-dark" style="background-color:#8e0413;">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold">WMSU|DTS</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link fw-bold" href="../admin/homePageAdmin.php">Home</a>
              </li> 

              <li class="nav-item">
                <a class="nav-link fw-bold text-white">--></a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link active fw-bold" aria-current="page">Receive Document</a>
              </li>

              <li class="nav-item">
                <a class="nav-link fw-bold text-white">--></a>
              </li>
                       
              <li class="nav-item">
                <a class="nav-link fw-bold text-white"><?php echo $_POST['rec_trackingID'];?></a>
              </li>
                      
            </ul>
          </div>
        </div>
      </nav>
      <br>
      <br>
      
      <div class="container text-center">
        <h4>RECEIVE DOCUMENT</h4>
        <?php
        if(empty($row)){
          $_SESSION['e_message'] = "The tracking ID is incorrect! Please double check it and try again!";
          $_SESSION['e_id'] = $_POST['rec_trackingID'];
            header("Location: ../admin/homePageAdmin.php?error=incorrect?id");
            die();
        }
         ?>             
      </div>
      <br>
      <hr style="color: black;">
      <br>

          <div class="container">

            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                      <th class="text-center fs-4" colspan="2">OVERVIEW OF <?php echo $_POST['rec_trackingID'];?></th>
                    </tr>
                </thead>

                <tbody>
                  <tr>
                    <th class="fs-5 text-center">
                        Tracking ID:
                    </th>

                    <td class="fs-5 text-center">
                        <?php echo $row['trackingID'];?>
                    </td>
                  </tr>

                  <tr>
                      <th class="fs-5 text-center">
                          Title:
                      </th>

                      <td class="fs-5 text-center">
                          <?php echo $row['title'];?>
                      </td>
                  </tr>

                  <tr>
                      <th class="fs-5 text-center">
                          Type:
                      </th>

                      <td class="fs-5 text-center">
                          <?php echo $row['type'];?>
                      </td>
                  </tr>

                  <tr>
                      <th class="fs-5 text-center">
                          Reason:
                      </th>

                      <td class="fs-5 text-center">
                          <?php echo $row['reason'];?>
                      </td>
                  </tr>

                  
                  <tr>
                      <th class="fs-5 text-center">
                          Originating Office:
                      </th>

                      <td class="fs-5 text-center">
                          <?php echo $row['origin_office'];?>
                      </td>
                  </tr>

                  <tr>
                      <th class="fs-5 text-center">
                          Current Office:
                      </th>

                      <td class="fs-5 text-center">
                          <?php echo $row['office'];?>
                      </td>
                  </tr>

                  <tr>
                      <th class="fs-5 text-center">
                          Remarks:
                      </th>

                      <td class="fs-5 text-center">
                          <?php echo $row['remarks'];?>
                      </td>
                  </tr>

                  <tr>
                      <th class="fs-5 text-center">
                          Status:
                      </th>

                      <td class="fs-5 text-center">
                      <?php
                            if ($row['status'] == "pending"){
                            ?>
                                <span style="color: red;"><?php echo $row['status']; ?></span>
                        <?php
                            }
                            else {
                            ?>
                                <span style="color: green;"><?php echo $row['status']; ?></span>
                            <?php
                            }
                        ?>
                      </td>
                  </tr>
                </tbody>
              </table>
            </div>


            <form action="../admin_funcs/receive.php"  id="mainSec" method="POST">
              <br>
              <br>
              <!--fix this issue here.-->
              <input type="text" name="rec_trackingID"  value="<?php echo $_POST["rec_trackingID"];?>" hidden>
              <input type="text" name="status"  value="<?php echo $row["status"];?>" hidden>

              <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_POST["userID"];?>" hidden>
              <br>
              <br>
            </form>
            <div class="d-flex justify-content-center">
                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                  <a href="../admin/homePageAdmin.php" type="button" class="btn btn-danger">No</a>
                  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#receiveModal">Okay</button>
                </div>
              </div>
          </div>
      <br>
      <br>
      <br>

      <!-- Modal for receive document-->
      <div class="modal fade" id="receiveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="finalModalLabel">Receive Document</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <p>Do you wish to receive this document?</p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" for>No</button>
              <button type="submit" name="submit" class="btn btn-success" data-bs-dismiss="modal" form="mainSec">Yes</button>
           </div>
         </div>
       </div>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>