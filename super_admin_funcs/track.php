<?php
        //include our connection
        include_once('../include/database.php');
        extract($_POST);
        $database = new Connection();
        $db = $database->open();

        try{	
            $sql = "SELECT logs.*, users.name FROM logs INNER JOIN users ON logs.user_id = users.id
             WHERE trackingID = '".$trackID."' ORDER BY logged_at DESC;";
            $no = 0;
            foreach ($db->query($sql) as $row) {
                $no++;
    ?>
    <tr>
        <td>
            <?php echo $no; ?>
        </td>

        <td>
            <?php echo $row['trackingID']; ?>
        </td>

        <td>
            <?php echo $row['name']; ?>
        </td>

        <td>
            <?php echo $row['origin_office']; ?>
        </td>

        <td>
            <?php echo $row['office']; ?>
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
            <?php echo $row['created_at']; ?>
        </td>

        <td>
            <?php echo $row['received_at']; ?>
        </td>

        <td>
            <?php echo $row['released_at']; ?>
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