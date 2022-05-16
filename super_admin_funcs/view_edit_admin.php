<div class="modal fade" id="edit_admin<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Admin User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/edit_admin.php?id=<?php echo $row['id']; ?>" method="post">
        <div class="modal-body">
        <label for="office">Office:</label>
                  <select class="form-select text-dark" name="officeName" id="officeName" required>
                    <option selected value="<?php echo $row['officeName']; ?>"><?php echo $row['officeName']; ?> (current)</option>
                  <?php
                      $database = new Connection();
                      $db = $database->open();
                      try{	
                          $sql = 'SELECT * FROM office ORDER BY officeName ASC;'; 
                          foreach ($db->query($sql) as $row1) {
                    ?>
                      <option value="<?php echo $row1['officeName']; ?>"> <?php echo $row1['description'];?> </option>
                      <?php
                      }

                    }
                    catch(PDOException $e){
                        echo "There is some problem in connection: " . $e->getMessage();
                    }

                    //close connection
                    $database->close();
                  ?>
                </select>

                <br>

                <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="name" value = <?php echo $row['name']; ?> required>
                <label for="name">Name:</label>
                </div>

                <div class="form-floating mb-3">
                <input type="email" class="form-control" id="username" name="username" placeholder="username" value = <?php echo $row['username']; ?> required>
                <label for="username">Email:</label>
                </div>

                <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value = <?php echo $row['password']; ?> required>
                <label for="floatingInput">Password:</label>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="edit" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

