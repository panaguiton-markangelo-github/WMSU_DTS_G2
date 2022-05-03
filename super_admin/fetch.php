<?php
include '../include/alt_db.php';

if(isset($_POST['request'])){
    $request = $_POST['request'];
    $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
    INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
    INNER JOIN users ON users.id = documents.user_id WHERE documents.type = '$request'
    ORDER BY documents.id DESC;";
    $result = mysqli_query($data, $query);
    $count = mysqli_num_rows($result);

?>

<table>
    <?php 
    if($count){
    ?>
        <thead>                   
            <tr>
                <th>
                    No.
                </th>

                <th>
                    Originating Office
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
            ?>
            <tr>
                <td>
                    <?php echo $no ;?>
                </td>

                <td>
                    <?php echo $row['officeName']; ?>
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
                    <form id="viewForm" action="view_documentSA.php" method="POST">
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
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>

</table>

<?php
} 
?>