<?php
session_start();
if(!isset($_SESSION["sa_username"])) 
{
  header("location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generate Report</title>
  <link rel="stylesheet" href="../assets/css/gen.css">
  <link rel="stylesheet" href="../assets/css/loading.css">
</head>
<body>
  <div id="preloader">
	</div>

  <form action="../super_admin_funcs/generate.php" class="decor" method="POST" target="_blank">
    <div class="form-left-decoration"></div>
    <div class="form-right-decoration"></div>
    <div class="circle"></div>
    <div class="form-inner">

    <h5><a href="HomePageSA.php">GO BACK HOME</a></h5>

      <h1>Generate Report</h1>
      <select name="officeName" id="officeName" required>
        <option value="" selected>Please Select Office.</option>
        <option value="CCS">College of Computer Studies</option>
        <option value="COG">College of Agriculture</option>
        <option value="COA">College of Architecture</option>
        <option value="CAIS">College of Asian and Islamic Studies</option>
        <option value="CCJE">College of Criminal Justice Education</option>
        <option value="COE">College of Engineering</option>
        <option value="CFES">College of Forestry and Environmental Studies</option> 
        <option value="CHE">College of Home Economics</option> 
        <option value="COL">College of Law</option>     
        <option value="CLA">College of Liberal Arts</option>
        <option value="CON">College of Nursing</option>
        <option value="CPADS">College of Public Administration and Development Studies</option>
        <option value="CSSP">College of Sports Science and Physical Education</option>
        <option value="CSM ">College of Science and Mathematics</option>
        <option value="CSWD">College of Social Work and Community Development</option>   
        <option value="CTE">College of Teacher Education</option>   
        <option value="Lib">WMSU Library</option>   
        <option value="CLA">College of Liberal Arts</option>
        <option value="GRRC">Gender Research and Resource Center</option>
      </select>
      <p style="text-align:center;">Note: The system will generate a report in pdf format of the documents and users. The system will generate a report based on the chosen office.</p> 
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

