<?php
session_start();
sleep(1);
include '../include/alt_db.php';

if(isset($_POST['request'])){

    $request = $_POST['request'];
    if($request == "none"){
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE yearsemester.activated = 'yes' AND users.officeName = '".$_SESSION['a_officeName']."'
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);
    }
    else{
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE documents.type = '$request' AND yearsemester.activated = 'yes'  AND users.officeName = '".$_SESSION['a_officeName']."'
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);
    }

    
?>

<table id="data_table_2" class="table table-striped table-hover">
    <?php 
    if($count){
    ?>
        <thead>                   
            <tr>
                <th>
                    No.
                </th>

                <th>
                    Tracking ID
                </th>
                
                <th>
                    Title
                </th>

                <th>
                    Type
                </th>

                <th>
                    Reason
                </th>

                <th>
                    Remarks
                </th>

                <th>
                    Status
                </th>

                <th>
                    School Year
                </th>

                <th>
                    Receive
                </th>

            </tr>
            <?php
    }
    else{
        echo "Sorry! No record found! click <a href='../admin/office_docs.php'> here </a> to reset the filter.";
    }
            ?>
        </thead>

        <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)){
                $no++;
            ?>
            <tr>
                <td>
                    <?php echo $no ;?>
                </td>

                <td>
                    <?php echo $row['trackingID']; ?>
                </td>

                <td>
                    <?php echo $row['title']; ?>
                </td>

                <td>
                    <?php echo $row['type']; ?>
                </td>

                <td>
                    <?php echo $row['reason']; ?>
                </td>

                <td>
                    <?php echo $row['remarks']; ?>
                </td>

                <td>
                    
                <?php
                    if ($row['status'] == "draft"){
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

                <td>
                    <?php echo $row['schoolYear']; ?>
                </td>

                <td>
                    <form id="receiveForm" action="../admin_funcs/view_receive.php" method="POST">
                        <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_SESSION["userID"];?>" hidden>
                        <input type="text" name="rec_trackingID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                        
                        <button id="submit" type="submit"><span class = "las la-arrow-circle-down"></span></button>
                    </form>
                </td>
            </tr>

            <?php
            }
            ?>
        </tbody>

</table>

<script>
    $(document).ready(function() {
        $('#data_table_2').DataTable({
            "processing":true
        });
    });
</script>

<?php
} 
?>

<!--filter school year-->

<?php
if(isset($_POST['request_year'])){

    $request_year = $_POST['request_year'];

    if($request_year== "none"){
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE yearsemester.activated = 'yes'  AND users.officeName = '".$_SESSION['a_officeName']."'
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);
    }
    else{
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE documents.schoolYear = '$request_year' AND yearsemester.activated = 'yes'  AND users.officeName = '".$_SESSION['a_officeName']."'
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);     
    }

    

?>

<table id="data_table_3" class="table table-striped table-hover">
    <?php 
    if($count){
    ?>
        <thead>                   
            <tr>
                <th>
                    No.
                </th>

                <th>
                    Tracking ID
                </th>
                
                <th>
                    Title
                </th>

                <th>
                    Type
                </th>

                <th>
                    Reason
                </th>

                <th>
                    Remarks
                </th>

                <th>
                    Status
                </th>

                <th>
                    School Year
                </th>

                <th>
                    Receive
                </th>

            </tr>
            <?php
    }
    else{
        echo "Sorry! No record found! click <a href='../admin/office_docs.php'> here </a> to reset the filter.";
    }
            ?>
        </thead>

        <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)){
                $no++;
            ?>
            <tr>
                <td>
                    <?php echo $no ;?>
                </td>

                <td>
                    <?php echo $row['trackingID']; ?>
                </td>

                <td>
                    <?php echo $row['title']; ?>
                </td>

                <td>
                    <?php echo $row['type']; ?>
                </td>

                <td>
                    <?php echo $row['reason']; ?>
                </td>

                <td>
                    <?php echo $row['remarks']; ?>
                </td>

                <td>
                    
                <?php
                    if ($row['status'] == "draft"){
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

                <td>
                    <?php echo $row['schoolYear']; ?>
                </td>

                <td>
                    <form id="receiveForm" action="../admin_funcs/view_receive.php" method="POST">
                        <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_SESSION["userID"];?>" hidden>
                        <input type="text" name="rec_trackingID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                        
                        <button id="submit" type="submit"><span class = "las la-arrow-circle-down"></span></button>
                    </form>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>

</table>

<script>
    $(document).ready(function() {
        $('#data_table_3').DataTable({
            "processing":true
        });
    });
</script>

<?php
} 
?>

<!--filter document type archives-->

<?php
if(isset($_POST['request_arc'])){

    $request_arc = $_POST['request_arc'];

    if($request_arc == "none"){
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE yearsemester.activated = 'no' AND users.officeName = '".$_SESSION['a_officeName']."'
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);
    }
    else{
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE documents.type = '$request_arc' AND yearsemester.activated = 'no' AND users.officeName = '".$_SESSION['a_officeName']."'
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);     
    }
    

?>

<table id="data_table_3" class="table table-striped table-hover">
    <?php 
    if($count){
    ?>
        <thead>                   
            <tr>
                <th>
                    No.
                </th>

                <th>
                    Tracking ID
                </th>
                
                <th>
                    Title
                </th>

                <th>
                    Type
                </th>

                <th>
                    Reason
                </th>

                <th>
                    Remarks
                </th>

                <th>
                    Status
                </th>

                <th>
                    School Year
                </th>

                <th>
                    Receive
                </th>

            </tr>
            <?php
    }
    else{
        echo "Sorry! No record found! click <a href='../admin/archives.php'> here </a> to reset the filter.";
    }
            ?>
        </thead>

        <tbody>
        <?php
            while($row = mysqli_fetch_assoc($result)){
                $no++;
            ?>
            <tr>
                <td>
                    <?php echo $no ;?>
                </td>

                <td>
                    <?php echo $row['trackingID']; ?>
                </td>

                <td>
                    <?php echo $row['title']; ?>
                </td>

                <td>
                    <?php echo $row['type']; ?>
                </td>

                <td>
                    <?php echo $row['reason']; ?>
                </td>

                <td>
                    <?php echo $row['remarks']; ?>
                </td>

                <td>
                    
                <?php
                    if ($row['status'] == "draft"){
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

                <td>
                    <?php echo $row['schoolYear']; ?>
                </td>

                <td>
                    <form id="receiveForm" action="../admin_funcs/view_receive.php" method="POST">
                        <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_SESSION["userID"];?>" hidden>
                        <input type="text" name="rec_trackingID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                        
                        <button id="submit" type="submit"><span class = "las la-arrow-circle-down"></span></button>
                    </form>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>

</table>

<script>
    $(document).ready(function() {
        $('#data_table_3').DataTable({
            "processing":true
        });
    });
</script>

<?php
} 
?>

<!--filter document school year archives-->

<?php
if(isset($_POST['request_arc_year'])){

    $request_arc_year = $_POST['request_arc_year'];

    if($request_arc_year == "none"){
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE yearsemester.activated = 'no' AND users.officeName = '".$_SESSION['a_officeName']."'
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);
    }
    else{
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE documents.schoolYear = '$request_arc_year' AND yearsemester.activated = 'no' AND users.officeName = '".$_SESSION['a_officeName']."'
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);     
    }

    

?>

<table id="data_table_3" class="table table-striped table-hover">
    <?php 
    if($count){
    ?>
        <thead>                   
             <tr>
                <th>
                    No.
                </th>

                <th>
                    Tracking ID
                </th>
                
                <th>
                    Title
                </th>

                <th>
                    Type
                </th>

                <th>
                    Reason
                </th>

                <th>
                    Remarks
                </th>

                <th>
                    Status
                </th>

                <th>
                    School Year
                </th>

                <th>
                    Receive
                </th>

            </tr>
            <?php
    }
    else{
        echo "Sorry! No record found! click <a href='../admin/archives.php'> here </a> to reset the filter.";
    }
            ?>
        </thead>

        <tbody>
        <?php
            while($row = mysqli_fetch_assoc($result)){
                $no++;
            ?>
            <tr>
                <td>
                    <?php echo $no ;?>
                </td>

                <td>
                    <?php echo $row['trackingID']; ?>
                </td>

                <td>
                    <?php echo $row['title']; ?>
                </td>

                <td>
                    <?php echo $row['type']; ?>
                </td>

                <td>
                    <?php echo $row['reason']; ?>
                </td>

                <td>
                    <?php echo $row['remarks']; ?>
                </td>

                <td>
                    
                <?php
                    if ($row['status'] == "draft"){
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

                <td>
                    <?php echo $row['schoolYear']; ?>
                </td>

                <td>
                    <form id="receiveForm" action="../admin_funcs/view_receive.php" method="POST">
                        <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_SESSION["userID"];?>" hidden>
                        <input type="text" name="rec_trackingID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                        
                        <button id="submit" type="submit"><span class = "las la-arrow-circle-down"></span></button>
                    </form>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>

</table>

<script>
    $(document).ready(function() {
        $('#data_table_3').DataTable({
            "processing":true
        });
    });
</script>

<?php
} 
?>

<!--incoming filter type-->
<?php
if(isset($_POST['request_inc_ty'])){

    $request_inc_ty = $_POST['request_inc_ty'];

    if($request_inc_ty== "none"){
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE yearsemester.activated = 'yes'  AND (SELECT FIND_IN_SET('".$_SESSION["a_officeName"]."', recipients))
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);
    }
    else{
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE documents.type = '$request_inc_ty' AND yearsemester.activated = 'yes'  AND (SELECT FIND_IN_SET('".$_SESSION["a_officeName"]."', recipients))
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);     
    }

    

?>

<table id="data_table_3" class="table table-striped table-hover">
    <?php 
    if($count){
    ?>
        <thead>                   
            <tr>
                <th>
                    No.
                </th>

                <th>
                    Tracking ID
                </th>
                
                <th>
                    Title
                </th>

                <th>
                    Type
                </th>

                <th>
                    Reason
                </th>

                <th>
                    Remarks
                </th>

                <th>
                    Status
                </th>

                <th>
                    School Year
                </th>

                <th>
                    Receive
                </th>

            </tr>
            <?php
    }
    else{
        echo "Sorry! No record found! click <a href='../admin/incoming_docs.php'> here </a> to reset the filter.";
    }
            ?>
        </thead>

        <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)){
                $no++;
            ?>
            <tr>
                <td>
                    <?php echo $no ;?>
                </td>

                <td>
                    <?php echo $row['trackingID']; ?>
                </td>

                <td>
                    <?php echo $row['title']; ?>
                </td>

                <td>
                    <?php echo $row['type']; ?>
                </td>

                <td>
                    <?php echo $row['reason']; ?>
                </td>

                <td>
                    <?php echo $row['remarks']; ?>
                </td>

                <td>
                    
                <?php
                    if ($row['status'] == "draft"){
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

                <td>
                    <?php echo $row['schoolYear']; ?>
                </td>

                <td>
                    <form id="receiveForm" action="../admin_funcs/view_receive.php" method="POST">
                        <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_SESSION["userID"];?>" hidden>
                        <input type="text" name="rec_trackingID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                        
                        <button id="submit" type="submit"><span class = "las la-arrow-circle-down"></span></button>
                    </form>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>

</table>

<script>
    $(document).ready(function() {
        $('#data_table_3').DataTable({
            "processing":true
        });
    });
</script>

<?php
} 
?>

<!--incoming filter year-->
<?php
if(isset($_POST['request_inc_y'])){

    $request_inc_y = $_POST['request_inc_y'];

    if($request_inc_y== "none"){
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE yearsemester.activated = 'yes'  AND (SELECT FIND_IN_SET('".$_SESSION["a_officeName"]."', recipients))
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);
    }
    else{
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
        INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id WHERE documents.schoolYear = '$request_inc_y' AND yearsemester.activated = 'yes'  AND (SELECT FIND_IN_SET('".$_SESSION["a_officeName"]."', recipients))
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);     
    }

    

?>

<table id="data_table_3" class="table table-striped table-hover">
    <?php 
    if($count){
    ?>
        <thead>                   
            <tr>
                <th>
                    No.
                </th>

                <th>
                    Tracking ID
                </th>
                
                <th>
                    Title
                </th>

                <th>
                    Type
                </th>

                <th>
                    Reason
                </th>

                <th>
                    Remarks
                </th>

                <th>
                    Status
                </th>

                <th>
                    School Year
                </th>

                <th>
                    Receive
                </th>

            </tr>
            <?php
    }
    else{
        echo "Sorry! No record found! click <a href='../admin/incoming_docs.php'> here </a> to reset the filter.";
    }
            ?>
        </thead>

        <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)){
                $no++;
            ?>
            <tr>
                <td>
                    <?php echo $no ;?>
                </td>

                <td>
                    <?php echo $row['trackingID']; ?>
                </td>

                <td>
                    <?php echo $row['title']; ?>
                </td>

                <td>
                    <?php echo $row['type']; ?>
                </td>

                <td>
                    <?php echo $row['reason']; ?>
                </td>

                <td>
                    <?php echo $row['remarks']; ?>
                </td>

                <td>
                    
                <?php
                    if ($row['status'] == "draft"){
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

                <td>
                    <?php echo $row['schoolYear']; ?>
                </td>

                <td>
                    <form id="receiveForm" action="../admin_funcs/view_receive.php" method="POST">
                        <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_SESSION["userID"];?>" hidden>
                        <input type="text" name="rec_trackingID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                        
                        <button id="submit" type="submit"><span class = "las la-arrow-circle-down"></span></button>
                    </form>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>

</table>

<script>
    $(document).ready(function() {
        $('#data_table_3').DataTable({
            "processing":true
        });
    });
</script>

<?php
} 
?>
