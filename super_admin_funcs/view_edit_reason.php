<div class="modal fade" id="edit_reason<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Document Reason</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/edit_reason.php?id=<?php echo $row['id']; ?>" method="post">
        <div class="modal-body">
              <div class="form-floating mb-3">
              <input type="text" class="form-control" id="reason" name="reason" placeholder="Reason" value = "<?php echo $row['reason']; ?>" required>
              <label for="reason">Reason:</label>
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

