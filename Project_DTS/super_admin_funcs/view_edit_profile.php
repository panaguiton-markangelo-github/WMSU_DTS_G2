<div class="modal fade" id="edit_profile<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/edit_profile.php?id=<?php echo $row['id']; ?>" method="post">
        <div class="modal-body">
                <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value = "<?php echo $row['name']; ?>" required>
                <label for="name">Name:</label>
                </div>

                <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="New password" required>
                <label for="password">New password:</label>
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

