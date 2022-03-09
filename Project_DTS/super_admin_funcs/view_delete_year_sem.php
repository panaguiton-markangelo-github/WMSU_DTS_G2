<div class="modal fade" id="delete_year_sem<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete School Year and Semester</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/delete_year_sem.php?id=<?php echo $row['id']; ?>" method="post">
        <div class="modal-body">
            <p>Are you sure to delete this School Year: <?php echo $row['schoolYear']; ?>, <?php  echo $row['stat']; ?></p>
            <br>
            <p style="text-align: center;color:red;">Note: Deleting this year means all affliated documents will be also deleted, 
              this will indicate that those documents are not necessary anymore. However, those documents can still be tracked.
              <br> Max documents: 9999
            </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
          <button type="submit" name="delete" class="btn btn-success">Yes</button>
        </div>
      </form>
    </div>
  </div>
</div>