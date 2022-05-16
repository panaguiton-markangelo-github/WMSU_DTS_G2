<?php
if($row['activated'] == 'yes'){
    ?>
    <div class="modal fade" id="dact_admin<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deactivate Admin User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../super_admin_funcs/act_admin.php?id=<?php echo $row['id']; ?>" method="post">
                <div class="modal-body">
                    <input type="text" name="active" value="no" hidden>
                    <p>Are you sure to deactivate this admin user?: <?php echo $row['name']; ?></p>
                    <br>
                    <p style="text-align: center;color:orange;">Note: Deactivating this admin user, means this admin will no longer be possible
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
    <div class="modal fade" id="act_admin<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activate Admin User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php 
            if($row['activated'] == 'no'){
                ?>
                <form action="../super_admin_funcs/act_admin.php?id=<?php echo $row['id']; ?>" method="post">
                    <div class="modal-body">
                        <input type="text" name="active" value="yes" hidden>
                        <p>Are you sure to activate this admin user?: <?php echo $row['name']; ?></p>
                        <br>
                        <p style="text-align: center;color:orange;">Note: activating this admin user, means this admin user will now be allowed to login.
                        </p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="submit" name="submit" class="btn btn-success">Yes</button>
                    </div>
                </form>
                <?php
            }elseif($row['activated'] == 'yes'){
                ?>
                    <div class="modal-body">
                        <p style="text-align:center;color:orange;">Note: This admin user is already activated!.
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



