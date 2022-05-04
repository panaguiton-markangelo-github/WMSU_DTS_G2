<?php
session_start();
sleep(1);
include '../include/alt_db.php';
if(isset($_POST['request'])){

    $request = $_POST['request'];
    if($request == "none"){
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, yearsemester.stat
        FROM documents INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id
        WHERE users.officeName = '".$_SESSION['a_officeName']."'
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);
    }
    else{
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, yearsemester.stat
        FROM documents INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id
        WHERE users.officeName = '".$_SESSION['a_officeName']."' AND documents.type = '$request'
        ;";
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
                
                </th>

                <th>
                    
                </th>

                <th>
                    View
                </th>

            </tr>
            <?php
    }
    else{
        echo "Sorry! No record found!";
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

                <td>
                    <?php echo $row['schoolYear']; ?>
                </td>

                <td>
                    <a style ="margin-right:10px;" class="btn btn-danger btn-sm p-2" data-bs-toggle="modal" data-bs-target="#delete_doc<?php echo $row['id']; ?>">Delete</a>
                </td>

                <td>
                    <a class="btn btn-success btn-sm p-2" data-bs-toggle="modal" data-bs-target="#edit_doc<?php echo $row['id']; ?>">Edit</a>
                </td>

                <td>
                    <form id="viewForm" action="view_documentC.php" method="POST">
                        <input type="text" name="track_ID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                        <input type="text" name="title" id="title" value= "<?php echo $row['title'];?>" hidden>
                        <input type="text" name="type" id="type" value= "<?php echo $row['type'];?>" hidden>
                        <input type="text" name="reason" id="reason" value= "<?php echo $row['reason'];?>" hidden>
                        <input type="text" name="remarks" id="remarks" value= "<?php echo $row['remarks'];?>" hidden>
                        <input type="text" name="status" id="status" value= "<?php echo $row['status'];?>" hidden>
                        <input type="text" name="file" id="file" value= "<?php echo $row['file'];?>" hidden>

                        <input type="text" name="schoolYear" id="schoolYear" value= "<?php echo $row['schoolYear'];?>" hidden>
                        <button id="submit" type="submit"><span class = "las la-info"></span></button>
                    </form>
                    <?php include('view_edit_doc.php');?>
                    <?php include('view_delete_doc.php');?>
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
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, yearsemester.stat
        FROM documents INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id
        WHERE users.officeName = '".$_SESSION['a_officeName']."'
        ORDER BY documents.id DESC;";
        $result = mysqli_query($data, $query);
        $count = mysqli_num_rows($result);
    }
    else{
        $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, yearsemester.stat
        FROM documents INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
        INNER JOIN users ON users.id = documents.user_id
        WHERE users.officeName = '".$_SESSION['a_officeName']."' AND documents.schoolYear = '$request_year'
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
                
                </th>

                <th>
                    
                </th>


                <th>
                    View
                </th>

            </tr>
            <?php
    }
    else{
        echo "Sorry! No record found!";
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

                <td>
                    <?php echo $row['schoolYear']; ?>
                </td>

                <td>
                    <a style ="margin-right:10px;" class="btn btn-danger btn-sm p-2" data-bs-toggle="modal" data-bs-target="#delete_doc<?php echo $row['id']; ?>">Delete</a>
                </td>

                <td>
                    <a class="btn btn-success btn-sm p-2" data-bs-toggle="modal" data-bs-target="#edit_doc<?php echo $row['id']; ?>">Edit</a>
                </td>

                <td>
                    <form id="viewForm" action="view_documentC.php" method="POST">
                        <input type="text" name="track_ID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                        <input type="text" name="title" id="title" value= "<?php echo $row['title'];?>" hidden>
                        <input type="text" name="type" id="type" value= "<?php echo $row['type'];?>" hidden>
                        <input type="text" name="reason" id="reason" value= "<?php echo $row['reason'];?>" hidden>
                        <input type="text" name="remarks" id="remarks" value= "<?php echo $row['remarks'];?>" hidden>
                        <input type="text" name="status" id="status" value= "<?php echo $row['status'];?>" hidden>
                        <input type="text" name="file" id="file" value= "<?php echo $row['file'];?>" hidden>

                        <input type="text" name="schoolYear" id="schoolYear" value= "<?php echo $row['schoolYear'];?>" hidden>
                        <button id="submit" type="submit"><span class = "las la-info"></span></button>
                    </form>
                    <?php include('view_edit_doc.php');?>
                    <?php include('view_delete_doc.php');?>
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
