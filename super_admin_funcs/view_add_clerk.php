<div class="modal fade" id="add_clerk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Clerk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/add_clerk.php" method="post">
        <div class="modal-body">
            <label for="office">Office:</label>
                <select class="form-select text-dark" name="officeName" id="officeName" required>
                  <option value="" selected>Please Select Office.</option>
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
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
              <label for="name">Name:</label>
            </div>

            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="username" name="username" placeholder="Username" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" required>
              <label for="username">Email:</label>
            </div>

            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              <label for="password">Password:</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="userType" name="userType" value="clerk" hidden>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="add" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>