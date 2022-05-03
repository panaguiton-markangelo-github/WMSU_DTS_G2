<?php 
if(empty($row1)){
$_SESSION['year_m'] = "No school year. Please add it first as soon as possible.";
}

?>

<div class="modal fade" id="add_year_sem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">               
        <h5 class="modal-title">Add New School Year</h5>                      
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/add_year_sem.php" method="post">
        <div class="modal-body">
            <?php
            if(empty($row2)){
              ?>
                <div class="container">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div style="margin-left:10px;text-align:center;">
                            <?php 
                                echo "<h5>No date range set for semesters and summer. Please add it as soon as possible by initializing default date range first.<h5>";
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
              <?php
            }
            else {
 
                $first_sem = strtotime($row2['first_sem_date']);
                $end_first_sem = strtotime($row2['end_first_sem_date']);
                $second_sem = strtotime($row2['sec_sem_date']);
                $end_second_sem = strtotime($row2['end_sec_sem_date']);

                $summer = strtotime($row2['summer_date']);
                $end_summer = strtotime($row2['end_summer_date']);

                $first_sem_date = date("m-d", $first_sem);
                $e_first_sem_date = date("m-d", $end_first_sem);

                $second_sem_date = date("m-d", $second_sem);
                $e_second_sem_date = date("m-d", $end_second_sem);

                $summer_date = date("m-d", $summer);
                $e_summer_date = date("m-d", $end_summer);

                if(empty($row1['id'])){
                  if($first_sem_date <= date("m-d") && date("m-d") <= $e_first_sem_date){
                    $start_year = date("Y");
                    $start_year_con = strtotime($start_year);
                    $next_year = strtotime("+ 1 year", $start_year_con);
                    $next_year_final = date("Y", $next_year);

                  }
                  else if($second_sem_date <= date("m-d") && date("m-d") <=  $e_second_sem_date) {
                    $start_year_s = date("Y");
                    $start_year_con = strtotime($start_year_s);
                    $start_year_con2 = strtotime("- 1 year", $start_year_con);
                    $start_year = date("Y", $start_year_con2);

                    $next_year_final = date("Y");
                  }

                  else if($summer_date <= date("m-d") && date("m-d") <=  $e_summer_date){
                    $start_year_s = date("Y");
                    $start_year_con = strtotime($start_year_s);
                    $start_year_con2 = strtotime("- 1 year", $start_year_con);
                    $start_year = date("Y", $start_year_con2);

                    $next_year_final = date("Y");
                  }
                }

                elseif(!empty($row1['id'])){
                  if($first_sem_date <= date("m-d") && date("m-d") <= $e_first_sem_date){
                    
                    $start_year_s = date("Y");
                    $start_year_con = strtotime($start_year_s);
                    $start_year = date("Y", $start_year_con);

                    $next_year = strtotime("+ 1 year", $start_year_con);
                    $next_year_final = date("Y", $next_year);
                  }
                  else if($second_sem_date <= date("m-d") && date("m-d") <=  $e_second_sem_date) {
                    $start_year_s = date("Y");
                    $start_year_con = strtotime($start_year_s);
                    $start_year_con2 = strtotime("- 1 year", $start_year_con);
                    $start_year = date("Y", $start_year_con2);

                    $next_year_final = date("Y");
                  }
                  else if($summer_date <= date("m-d") && date("m-d") <=  $e_summer_date){
                    $start_year_s = date("Y");
                    $start_year_con = strtotime($start_year_s);
                    $start_year_con2 = strtotime("- 1 year", $start_year_con);
                    $start_year = date("Y", $start_year_con2);

                    $next_year_final = date("Y");
                  }
                }

                if($first_sem_date <= date("m-d") && date("m-d") <= $e_first_sem_date){
                    $status = "1st semester";
                    
                }
                else if($second_sem_date <= date("m-d") && date("m-d") <=  $e_second_sem_date) {
                    $status = "2nd semester";

                }
                else if($summer_date <= date("m-d") && date("m-d") <=  $e_summer_date){
                    $status = "summer";
                }
              ?>
                <div class="row d-flex justify-content-center align-content-center">
                  <div class="col">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" list="s_year" id="startYear" name="startYear" minlength="4" maxlength="4" max="<?php echo $next_year_final;?>" min="<?php echo $start_year;?>" required>
                      <label for="startYear">Year:</label>
                    </div>     
                  </div>

                  <div class="col-1">
                      <span>TO</span>
                  </div>

                  <div class="col">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="endYear" list="e_year" name="endYear" minlength="4" maxlength="4" max="<?php echo $next_year_final;?>" min="<?php echo $start_year;?>" required>
                      <label for="endYear">Year:</label>
                    </div>
                  </div>
                </div>

                <datalist id="s_year">
                  <option value="<?php echo $start_year;?>"> Suggestion: <?php echo $start_year;?> </option>
                </datalist>

                <datalist id="e_year">
                  <option value=""> Suggestion: </option>
                  <option value="<?php echo $next_year_final;?>"> Suggestion: <?php echo $next_year_final;?> </option>
                </datalist>

                <input type="text" class="form-control" id="status" name="status" value="<?php echo $status?>" hidden>

              <?php

                if(empty($row1)){
                  ?>  
                  <select class="form-select text-dark" name="activate" id="officeName" required>
                    <option value="" selected>Activate: click to select yes/no</option>
                    <option value="yes">Activate: yes</option>
                    <option value="no">Activate: no</option>
                  </select>
                  <?php
                }
                elseif(!empty($row1)){
                  ?>
                  <br>
                  <p style="text-align:center;color:orange;">Note: There is already an active school year.,
                  </p>
                  <?php
                }
                ?>
                <br>
                <p style="text-align:center;color:orange;">Note: The semester/summer is automatically set base on the date range set by the system.
                  If you want to change the date range, please click the "edit date range" button to change
                  the date range of semester/summer located at the settings page.
                </p>

                <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                      <button type="submit" name="add" class="btn btn-success">Save changes</button>
                </div>
              
              <?php
            }
              ?>                  
        </div>
      </form>
    </div>
  </div>
</div>