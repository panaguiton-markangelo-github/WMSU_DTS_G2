<div class="modal fade" id="add_office" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Office</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/add_office.php" method="post">
        <div class="modal-body">

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="officeName" name="officeName" placeholder="Office Name" maxlength="3" required>
              <label for="officeName">Office name:</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="description" name="description" placeholder="Description" maxlength="150" required>
              <label for="description">Description(Full Office Name):</label>
            </div>

            <p style="text-align: center;color:yellow;">
                Note: Only maximum of 3 characters are allowed for the office name field, please enter only the abbreviation of the office. 
                <b>For example: CCS for College of Computer Studies.</b>
                You can put the full name of the office in the description field, max length of 150 characters.     
            </p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="add" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>