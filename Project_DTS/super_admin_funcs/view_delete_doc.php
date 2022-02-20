<div class="modal fade" id="delete_docs<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/delete_doc.php?id=<?php echo $row['id']; ?>" method="post">
        <div class="modal-body">
          <p class="text-center">Are you sure to delete document? : <?php echo $row['title']."."; ?> 
          <br>
             The document would still be visible when tracked.
          </p>
          <br>

          <p class="text-danger text-center">
            Note: If a document is already tagged as terminal, it means the document has reached its last stop in the indicated current office.
            However, the status of the document could still be edited, if a mistake has been done.
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