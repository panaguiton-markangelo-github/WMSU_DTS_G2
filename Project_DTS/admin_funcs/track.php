<?php
        //include our connection
        include_once('../include/database.php');
        extract($_POST);
        $database = new Connection();
        $db = $database->open();

        try{	
            $sql = "SELECT * FROM logs WHERE trackingID = '".$trackID."';";
            $no = 0;
            foreach ($db->query($sql) as $row) {
                $no++;
    ?>
    <tr class="table-danger">
        <td>
            <?php echo $no; ?>
        </td>

        <td>
            <?php echo $row['trackingID']; ?>
        </td>
        
        <td>
            <?php echo $row['origin_office']; ?>
        </td>

        <td>
            <?php echo $row['office']; ?>
        </td>

        <td>
            <?php echo $row['action']; ?>
        </td>

        <td>
        <?php
            if ($row['status'] == "available"){
            ?>
                <span class="avail data"> <?php echo $row['status']; ?> </span>
        <?php
            }
            else if ($row['status'] == "terminal") {
            ?>
                <span class="term data"> <?php echo $row['status']; ?> </span>
        <?php
            }
            else {
            ?>
                <span class="pending data"> <?php echo $row['status']; ?> </span>
        <?php
            }
        ?> 
        </td>
        
        <td>
            <?php echo $row['created_at']; ?>
        </td>

        <td>
            <?php echo $row['received_at']; ?>
        </td>

        <td>
            <?php echo $row['released_at']; ?>
        </td>

        <td>
            <?php echo $row['terminal_at']; ?>
        </td>

        <td>
            <?php echo $row['remarks']; ?>
        </td>

    </tr>

    <?php 
            }
        }
        catch(PDOException $e){
            echo "There is some problem in connection: " . $e->getMessage();
        }

        //close connection
        $database->close();
?>