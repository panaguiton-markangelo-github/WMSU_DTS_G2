<?php
session_start();
if(!isset($_SESSION["a_username"])) 
{
  header("location: ../index.php");
}

include ("../include/alt_db.php");
try {

  $query = "SELECT * FROM office WHERE officeName = '".$_SESSION['a_officeName']."'";
  $result = mysqli_query($data, $query);
  $row = mysqli_fetch_array($result);
}
catch(PDOException $e) {
  $_SESSION['message_fail'] = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../assets/img/wmsu_logo.png"/>
  <title>Generate Report</title>
  <link rel="stylesheet" href="../assets/css/gen.css">
  <link rel="stylesheet" href="../assets/css/loading.css">
</head>
<body>
  <div id="preloader">
	</div>

  <form action="../admin_funcs/generate.php" class="decor" method="POST" target="_blank">
    <div class="form-left-decoration"></div>
    <div class="form-right-decoration"></div>
    <div class="circle"></div>
    <div class="form-inner">

    <h5><a href="homePageAdmin.php">GO BACK HOME</a></h5>

      <h1>Generate Report</h1>
      <select name="officeName" id="officeName" required>
        <option value=""> Available office: </option>
        <option value="<?php echo $_SESSION['a_officeName']?>" selected> <?php echo $_SESSION['a_officeName']." - ".$row['description']?> </option>
      </select>
      <p style="text-align:center;">Note: The system will generate a report in pdf format of the documents and users. The system will generate a report based on this office.</p> 
      <button type="submit" name="generate">Generate</button>
    </div>
  </form>

  <script>
    var loader =  document.getElementById("preloader");
    window.addEventListener("load", function(){
      loader.style.display = "none";
    })
	  </script>
</body>
</html>

