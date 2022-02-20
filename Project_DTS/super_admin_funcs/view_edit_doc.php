<div class="modal fade" id="edit_docs<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/edit_doc.php?id=<?php echo $row['id']; ?>" method="post">
        <div class="modal-body">
                <?php $oldtrackid = $row['trackingID'] ?>
                <div class="form-floating mb-3">
                <input type="text" class="form-control" id="title" name="title" placeholder="title" value = "<?php echo $row['title']; ?>" required>
                <label for="title">Title:</label>
                </div>

                <div class="form-floating mb-3">
                <input type="text" class="form-control" id="trackingID" name="trackingID" placeholder="trackingID" value = "<?php echo $row['trackingID']; ?>" required>
                <label for="trackingID">Tracking ID:</label>
                </div>

                <label for="type">Type:</label>
                <select class="form-select text-dark" name="type" id="type">
                  <option selected value="<?php echo $row['type']; ?>"><?php echo $row['type']; ?></option>
                  <option value="Certificate of Service">Certificate of Service</option>
                  <option value="Disbursement of Service">Disbursement of Service</option>
                  <option value="Inventory and Inspection Report">Inventory and Inspection Report</option>
                  <option value="Letter">Letter</option>
                  <option value="Liquidation Report">Liquidation Report</option>
                  <option value="Memorandum">Memorandum</option>
                  <option value="Memorandum of Agreement">Memorandum of Agreement</option>
                  <option value="Memorandum Receipt">Memorandum Receipt</option>
                  <option value="Official Cash Book">Official Cash Book</option>
                  <option value="Personal Data Sheet">Personal Data Sheet</option>
                  <option value="Purchase Order">Purchase Order</option>
                  <option value="Purchase Request">Purchase Request</option>
                  <option value="Referral Slip">Referral Slip</option>
                  <option value="Request for Obligation of Allotments">Request for Obligation of Allotments</option>
                  <option value="Requisition and Issue Voucher">Requisition and Issue Voucher</option>
                  <option value="Unclassified">Unclassified</option>
                </select>
                
                <br>
                <label for="reason">Reason:</label>
                <select class="form-select text-dark" name="reason" id="reason">
                  <option selected value="<?php echo $row['reason']; ?>"><?php echo $row['reason']; ?></option>
                  <option value="Appropriate Action">Appropriate Action</option>
                  <option value="Coding/Deposit/Preparation of Receipt">Coding/Deposit/Preparation of Receipt</option>
                  <option value="Comment/Reaction/Response">Comment/Reaction/Response</option>
                  <option value="Compliance/Implementation">Compliance/Implementation</option>
                  <option value="Dissemination of Information">Dissemination of Information</option>
                  <option value="Draft of Reply">Draft of Reply</option>
                  <option value="Endorsement/Recommendation">Endorsement/Recommendation</option>
                  <option value="Follow-up">Follow-up</option>
                  <option value="Investigation/Verification and Report">Investigation/Verification and Report</option>
                  <option value="Notation and Return/File">Notation and Return/File</option>
                  <option value="Notification/Reply to Party">Notification/Reply to Party</option>
                  <option value="Study and Report to">Study and Report to</option>
                  <option value="Translation">Translation</option>
                  <option value="Your Information">Your Information</option>
                </select>

                <br>

                <div class="form-floating mb-3">
                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="remarks" value = "<?php echo $row['remarks']; ?>" required>
                <label for="remarks">Remarks:</label>
                </div>

                <label for="status">Status:</label>
                <select class="form-select text-dark" name="status" id="status">
                  <option selected value="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></option>
                  <option value="available">Available</option>
                  <option value="pending">Pending</option>
                  <option value="terminal">Terminal</option>
                </select>

                <br>
                
                <label for="semester">Semester:</label>
                <select class="form-select text-dark" name="semester" id="semester">
                <option selected value="<?php echo $row['semester']; ?>"><?php echo $row['semester']; ?></option>
                  <?php
                    //include our connection
                    include_once('../include/database.php');

                    $database = new Connection();
                    $db = $database->open();
                    try{	
                        $sql = 'SELECT DISTINCT semester FROM yearsemester;';    
                        foreach ($db->query($sql) as $row1) {
                ?>
                  <option value="<?php echo $row1['semester']; ?>"><?php echo $row1['semester']; ?></option>
                  <?php
                  }
                }
                catch(PDOException $e){
                    echo "There is some problem in connection: " . $e->getMessage();
                }

                //close connection
                $database->close();
                  ?>
                </select>

                <br>

                <label for="schoolYear">School Year:</label>
                <select class="form-select text-dark" name="schoolYear" id="schoolYear">
                <option selected value="<?php echo $row['schoolYear']; ?>"><?php echo $row['schoolYear']; ?></option>
                  <?php
                    //include our connection
                    include_once('../include/database.php');

                    $database = new Connection();
                    $db = $database->open();
                    try{	
                        $sql = 'SELECT DISTINCT schoolYear FROM yearsemester;'; 
                        foreach ($db->query($sql) as $row2) {
                ?>
                  <option value="<?php echo $row2['schoolYear']; ?>"><?php echo $row2['schoolYear']; ?></option>
                  <?php
                  }
                }
                catch(PDOException $e){
                    echo "There is some problem in connection: " . $e->getMessage();
                }

                //close connection
                $database->close();
                  ?>
                </select>

                <br>

                <p class="text-danger text-center">
                  Note: If a document is already tagged as terminal, it means the document has reached its last stop in the indicated current office.
                  However, the status of the document could still be edited, if a mistake has been done.
                </p>         
                
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="edit" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

