<div class="modal fade" id="edit_doc<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../admin_funcs/edit_doc.php?id=<?php echo $row['id']; ?>" method="post">
        <div class="modal-body">
                <?php $oldtrackid = $row['trackingID'] ?>
                <div class="form-floating mb-3">
                <input type="text" class="form-control" id="title" name="title" placeholder="title" value = "<?php echo $row['title']; ?>" required>
                <label for="title">Title:</label>
                </div>

                <div class="form-floating mb-3">
                <input type="text" list="reasons" class="form-control" id="reason" name="reason" placeholder="reason" value = "<?php echo $row['reason']; ?>" required>
                <label for="reason">Reason:</label>
                </div>

                <div class="form-floating mb-3">
                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="remarks" value = "<?php echo $row['remarks']; ?>" required>
                <label for="remarks">Remarks:</label>
                </div>
                              
                <datalist id="reasons">
                  <option selected value="<?php echo $row['reason']; ?>"><?php echo $row['reason']; ?></option>
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
                </datalist>

                <p style="text-align:center;color:orange;">
                  Note: Please enter the appropriate details and make the changes.
                  When changing the reason you can just select in the list of reasons provided or you can enter the reason if it is not available in the given list.  
                </p>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="edit" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


