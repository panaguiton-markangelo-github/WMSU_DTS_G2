<div class="modal fade" id="edit_office<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Office</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/edit_office.php?id=<?php echo $row['id']; ?>" method="post">
        <div class="modal-body">

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="officeName" name="officeName" placeholder="Office Name" maxlength="3" value="<?php echo $row['officeName']; ?>" required>
              <label for="officeName">Office name:</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="description" name="description" placeholder="Description" maxlength="150" value="<?php echo $row['description']; ?>" required>
              <label for="description">Description:</label>
            </div>

            <p style="text-align: center;color:green;">
                Note: Only maximum of 3 characters are allowed for the office name field, please enter only the abbreviation of the office. 
                <b>For example: ICS for Institute of Computer Studies.</b>
                You can put the full name of the office in the description field, max length of 150 characters.     
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