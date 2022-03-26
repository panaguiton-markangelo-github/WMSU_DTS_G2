<div class="modal fade" id="default_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Initialize Default Date Range</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/default_date.php" method="post">
        <div class="modal-body">
            <p style="text-align: center;">1st Semester</p>
            <label for="start_month">Starting Month/Day:</label>
            <select class="form-select text-dark" name="start_month_1" id="start_month_1" readonly>
                <option value="August" selected>August</option>
            </select>
            <br>

            <select class="form-select text-dark" name="start_day_1" id="start_day_1" readonly>
                <option value="01" selected>01</option>           
            </select>

            <br>

            <label for="end_month">Ending Month/Day:</label>
            <select class="form-select text-dark" name="end_month_1" id="end_month_1" readonly>
                <option value="December" selected>December</option>
            </select>
            <br>

            <select class="form-select text-dark" name="end_day_1" id="end_day_1" readonly>
                <option value="01" selected>01</option>
            </select>

            <br>
            <p style="text-align: center;">2nd Semester</p>
            <label for="start_month">Starting Month/Day:</label>
            <select class="form-select text-dark" name="start_month_2" id="start_month_2" readonly>
                <option value="January" selected>January</option>
            </select>
            <br>

            <select class="form-select text-dark" name="start_day_2" id="start_day_2" readonly>
                <option value="01" selected>01</option>           
            </select>

            <br>

            <label for="end_month">Ending Month/Day:</label>
            <select class="form-select text-dark" name="end_month_2" id="end_month_2" readonly>
                <option value="May" selected>May</option>
            </select>
            <br>

            <select class="form-select text-dark" name="end_day_2" id="end_day_2" readonly>
                <option value="01" selected>01</option>
            </select>

            <br>

            <p style="text-align: center;">Summer</p>
            <label for="start_month">Starting Month/Day:</label>
            <select class="form-select text-dark" name="start_month_3" id="start_month_3" readonly>
                <option value="June" selected>June</option>
            </select>
            <br>

            <select class="form-select text-dark" name="start_day_3" id="start_day_3" readonly>
                <option value="01" selected>01</option>           
            </select>

            <br>

            <label for="end_month">Ending Month/Day:</label>
            <select class="form-select text-dark" name="end_month_3" id="end_month_3" readonly>
                <option value="July" selected>July</option>
            </select>
            <br>

            <select class="form-select text-dark" name="end_day_3" id="end_day_3" readonly>
                <option value="01" selected>01</option>
            </select>
           
            <p style="text-align:center;color:green;">Note: This will change the date range of the semesters and summer.
            </p>
            

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>