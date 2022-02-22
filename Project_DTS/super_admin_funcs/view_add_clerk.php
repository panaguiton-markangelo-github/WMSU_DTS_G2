<div class="modal fade" id="add_clerk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Clerk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/add_clerk.php" method="post">
        <div class="modal-body">
            <label for="office">Office:</label>
                <select class="form-select text-dark" name="officeName" id="officeName" required>
                  <option selected>Please Select Office.</option>
                  <option value="ICS">Institute of Computer Studies</option>
                  <option value="COG">College of Agriculture</option>
                  <option value="COA">College of Architecture</option>
                  <option value="CAIS">College of Asian and Islamic Studies</option>
                  <option value="CCJE">College of Criminal Justice Education</option>
                  <option value="COE">College of Engineering</option>
                  <option value="CFES">College of Forestry and Environmental Studies</option> 
                  <option value="CHE">College of Home Economics</option> 
                  <option value="COL">College of Law</option>     
                  <option value="CLA">College of Liberal Arts</option>
                  <option value="CON">College of Nursing</option>
                  <option value="CPADS">College of Public Administration and Development Studies</option>
                  <option value="CSSP">College of Sports Science and Physical Education</option>
                  <option value="CSM ">College of Science and Mathematics</option>
                  <option value="CSWD">College of Social Work and Community Development</option>   
                  <option value="CTE">College of Teacher Education</option>   
                  <option value="Lib">WMSU Library</option>   
                  <option value="CLA">College of Liberal Arts</option>
                  <option value="GRRC">Gender Research and Resource Center</option>
                </select>

                <br>
                
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
              <label for="name">Name:</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
              <label for="username">Email:</label>
            </div>

            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              <label for="password">Password:</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="userType" name="userType" value="clerk" hidden>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="add" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>