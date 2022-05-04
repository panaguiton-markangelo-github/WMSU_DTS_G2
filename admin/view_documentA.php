<?php
session_start();
if(!isset($_SESSION["a_username"])) {
  header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/footer.css">
</head>
<body style="background-color:#fff;">
    <nav class="navbar navbar-expand-sm navbar-dark border-bottom border-dark" style="background-color:#8e0413;">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold" >WMSU|DTS</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link fw-bold" href="homePageAdmin.php">Home</a>
              </li> 

              <li class="nav-item">
                <span class="nav-link fw-bold">--></span>
              </li>
              
              <li class="nav-item">
                <a class="nav-link active fw-bold" aria-current="page"><?php echo $_POST['track_ID'];?></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <br>
      <br>

      <div class="container">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id = "table">
                <thead>
                    <tr>
                        <th class="text-center fs-4" colspan="2">OVERVIEW OF <?php echo $_POST['track_ID'];?></th>
                    </tr>
                </thead>
    
                <tbody>
                    <tr>
                        <th class="fs-5 text-center">
                            Tracking ID:
                        </th>
        
                        <td class="fs-5 text-center">
                            <?php echo $_POST['track_ID'];?>
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
                            Remarks:
                        </th>
        
                        <td class="fs-5 text-center">
                            <?php echo $_POST['remarks'];?>
                        </td>
                    </tr>

                    <tr>
                        <th class="fs-5 text-center">
                            Year
                        </th>
                        
                        <td class="fs-5 text-center">
                            <?php echo $_POST['schoolYear'];?>
                        </td>
        
                    </tr>

                    <tr>

                        <th class="fs-5 text-center">
                            Status
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

            <form action="release_document.php" method="POST">
                <input type="text" name="trackingID" value="<?php echo $_POST['track_ID'];?>" hidden>
                <input type="text" name="userID" value="<?php echo $_SESSION['userID'];?>" hidden>
                <button type="submit" name="release_mod" class="btn btn-success ">Update Status</button>
            </form>

            <br>
            <br>

            <br>
            <br>
          </div>
          
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id = "table">
                <thead>
                    <tr>
                        <th class="text-center fs-4" colspan="2">FILE OF <?php echo $_POST['track_ID'];?></th>
                    </tr>
                </thead>
    
                <tbody>
                    <tr>
                        <th class="fs-5 text-center">
                            File:
                        </th>

                        <?php if($_POST['file'] == 'none'){
                            ?>
                            <td class="fs-5 text-center">
                               <span>No File</span>
                            </td>
                            <?php
                        }
                        else
                        {
                            ?>
                                <td class="fs-5 text-center">
                                <a href="../uploads/<?php echo $_POST['file'];?>" target="_blank"><?php echo $_POST['file'];?></a>
                            </td>
                            <?php
                        }
                        ?>
    
                    </tr>

                </tbody>
            </table>  
            <br>
            <br>
        </div>

      </div>

      <br>
      <br>
      <br>
      <br>

    <footer>
        <p>&copy;Copyright 2021 by <a href="#">WMSU</a>.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>