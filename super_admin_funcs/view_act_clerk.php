<?php
if($row['activated'] == 'yes'){
    ?>
    <div class="modal fade" id="dact_clerk<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deactivate Clerk User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../super_admin_funcs/act_clerk.php?id=<?php echo $row['id']; ?>" method="post">
                <div class="modal-body">
                    <input type="text" name="active" value="no" hidden>
                    <p>Are you sure to deactivate this clerk user?: <?php echo $row['name']; ?></p>
                    <br>
                    <p style="text-align: center;color:orange;">Note: Deactivating this clerk user, means this clerk will no longer be possible
                        to login.
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
    <div class="modal fade" id="act_clerk<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activate Clerk User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php 
            if(empty($row1)){
                ?>
                <form action="../super_admin_funcs/act_clerk.php?id=<?php echo $row['id']; ?>" method="post">
                    <div class="modal-body">
                        <input type="text" name="active" value="yes" hidden>
                        <p>Are you sure to activate this clerk user?: <?php echo $row['name']; ?></p>
                        <br>
                        <p style="text-align: center;color:orange;">Note: activating this clerk user, means this clerk user will now be allowed to login.
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
                        <p style="text-align:center;color:orange;">Note: This clerk user is already activated!.
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



