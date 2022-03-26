<?php
if($row['activated'] == 'yes'){
    ?>
    <div class="modal fade" id="dact_year<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deactivate School year</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../super_admin_funcs/act_year.php?id=<?php echo $row['id']; ?>" method="post">
                <div class="modal-body">
                    <input type="text" name="active" value="no" hidden>
                    <p>Are you sure to deactivate this school year?: <?php echo $row['schoolYear']; ?>, <?php  echo $row['stat']; ?></p>
                    <br>
                    <p style="text-align: center;color:red;">Note: Deactivating this school year, means it will no longer be possible
                        to attached this school year to documents and it is now possible to have another school year to be activated.
                    </p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                <button type="submit" name="submit" class="btn btn-success">Yes</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    <?php
}
elseif($row['activated'] == 'no'){
    ?>
    <div class="modal fade" id="act_year<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activate School year</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php 
            if(empty($row1)){
                ?>
                <form action="../super_admin_funcs/act_year.php?id=<?php echo $row['id']; ?>" method="post">
                    <div class="modal-body">
                        <input type="text" name="active" value="yes" hidden>
                        <p>Are you sure to activate this school year?: <?php echo $row['schoolYear']; ?>, <?php  echo $row['stat']; ?></p>
                        <br>
                        <p style="text-align: center;color:red;">Note: activating this school year, means this school year will be
                            attached to documents and only one active school year is possible.
                        </p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="submit" name="submit" class="btn btn-success">Yes</button>
                    </div>
                </form>
                <?php
            }elseif(!empty($row1)){
                ?>
                    <div class="modal-body">
                        <p style="text-align:center;color:red;">Note: There is already an active school year. It is not possible to have more than 1 active school year at the same time.
                        Please deactivate an existing active school year and try again!.
                        </p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Okay!</button>
                    </div>
                <?php
            }

            ?>

            

            </div>
        </div>
        </div>
    <?php
}
?>



