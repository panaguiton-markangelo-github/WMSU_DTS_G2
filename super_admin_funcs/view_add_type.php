<div class="modal fade" id="add_type" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/add_type.php" method="post">
        <div class="modal-body">

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="type" name="type" placeholder="Type" required>
              <label for="type">Type:</label>
            </div>

            <p style="text-align: center;color:orange;">
                Note: Document types refers to what kind/type a document is. 
                <b>For example: Memorandum is a type of document.</b>    
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