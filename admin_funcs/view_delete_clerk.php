<div class="modal fade" id="delete_clerk<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Clerk User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../admin_funcs/delete_clerk.php?id=<?php echo $row['id']; ?>" method="post">
        <div class="modal-body">
            <p>Are you sure to delete clerk user? : <?php echo $row['username']; ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
          <button type="submit" name="delete" class="btn btn-success">Yes</button>
        </div>
      </form>
    </div>
  </div>
</div>