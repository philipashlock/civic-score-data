<?php include 'header_meta_inc_view.php';?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

  <script>
  $(document).ready(function() {
    $(function() {
        $( ".datePicker" ).datepicker();
    });
    
    $("#supplyDetails").hide();
    $("#electricityDetails").hide();
    $("#waterDetails").hide();
    $("#moldDetails").hide();
    $("#structureDetails").hide();
    $("#cafeteriaDetails").hide();
    $("#otherDetails").hide();
    $("#ADAcompDetails").hide();
    $("#etcDetails").hide();
    
    
    $('#myTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

	 $('#needsProceed').click(function (e) {
	e.preventDefault();
	$(this).tab('show');
	});


	$("#accessProceed").click(function (e) {
	e.preventDefault();
	$(this).tab('show');
	});

    $('.pChk').click(function() {
        if( $("#needElectricity").is(':checked')) {
            $("#electricityDetails").show();
        } else {
            $("#electricityDetails").hide();
        }
        if( $("#needSupplies").is(':checked')) {
            $("#supplyDetails").show();
        } else {
            $("#supplyDetails").hide();
        }
        if( $("#needWaterDamage").is(':checked')) {
            $("#waterDetails").show();
        } else {
            $("#waterDetails").hide();
        }
        if( $("#needMold").is(':checked')) {
            $("#moldDetails").show();
        } else {
            $("#moldDetails").hide();
        }
        if( $("#needStructure").is(':checked')) {
            $("#structureDetails").show();
        } else {
            $("#structureDetails").hide();
        }
        if( $("#needCafeteria").is(':checked')) {
            $("#cafeteriaDetails").show();
        } else {
            $("#cafeteriaDetails").hide();
        }
        if( $("#needOther").is(':checked')) {
            $("#otherDetails").show();
        } else {
            $("#otherDetails").hide();
        }
        if( $("#needADAcomp").is(':checked')) {
            $("#ADAcompDetails").show();
        } else {
            $("#ADAcompDetails").hide();
        }
        if( $("#needEtc").is(':checked')) {
            $("#etcDetails").show();
        } else {
            $("#etcDetails").hide();
        }
  });
});
  </script>

<?php include 'header_inc_view.php';?>


<?php if(isset($messages['error'])) echo $messages['error'];?>

  <div class="span9">
  <p>Do you have information about a school you work at or live near? Please submit as much specific information as you can. This information will supplement the data national recovery teams are receiving from field offices. Hopefully your help will mean that the recovery effort is more efficient and directed. Thanks for volunteering!</p>
  </div>
  
  <div class="span9">
    <ul class="nav nav-tabs span9" id="myTab">
      <li class="active" data-toggle="tab"><a href="#infoForm">School Info</a></li>
      <li><a href="#needsForm" data-toggle="tab">Needs and Damage</a></li>
      <li><a href="#accessForm" data-toggle="tab">Accessibility</a></li>
    </ul>
  </div>
  

  <form method="post" action="/status/update/<?php if (empty($status['error'])) echo "edit"; else echo "add" ?>" class="tab-content span9">
  
    <!-- Step1 School Info -->
    <div id="infoForm" class="tab-pane active">
      <h3>Step 1. School Information</h3>
      <div id="newInfo" class="form-horizontal">
        <fieldset>
      
          <div class="control-group">
            <label class="control-label" for="inputSchoolName">School Name: </label>
            <div class="controls"><input type="text" id="inputSchoolName" value="<?php if (!empty($entity['full_name'])) echo $entity['full_name']; ?>" disabled></div>
          </div>
        
          <div class="control-group">
            <label class="control-label" for="inputContactName">Point of Contact: </label>
            <div class="controls"><input type="text" id="inputContactName" name="contact_point_name" value="<?php if (!empty($status['contact_point_name'])) echo $status['contact_point_name']; ?>" placeholder="Point of Contact"></div>
          </div>
        
          <div class="control-group">
            <label class="control-label" for="inputContactPhone">Phone Number: </label>
            <div class="controls"><input type="text" id="inputContactPhone" name="contact_point_phone" value="<?php if (!empty($status['contact_point_phone'])) echo $status['contact_point_phone']; elseif (!empty($entity['phone'])) echo $entity['phone']; ?>"></div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputContactEmail">Email: </label>
            <div class="controls"><input type="text" id="inputContactEmail" name="contact_point_email" value="<?php if (!empty($status['contact_point_email'])) echo $status['contact_point_email']; ?>"></div>
          </div>
        
          <div class="control-group">
            <span class="control-label">Current School Status:</span>
            <div class="controls">
              <select name="status">
                <option value="">-- Select School Status --</option>
				<?php if (!empty($status['status'])) $entity_status = $status['status']; else $entity_status = ''; ?>
                <option value="open"<?php if ($entity_status == 'open') echo ' selected="selected"'?>>Open</option>
                <option value="relocated"<?php if ($entity_status == 'relocated') echo ' selected="selected"'?>>Relocated</option>
                <option value="closed"<?php if ($entity_status == 'closed') echo ' selected="selected"'?>>Closed</option>
              </select>
            </div>
          </div>
        
          <div class="control-group">
            <label class="control-label" for="inputTeacherOpen">When does/did your school open for staff, teachers, and other personnel? </label>
            <div class="controls"><input type="text" class="datePicker" id="inputTeacherOpen" name="open_date_teachers" placeholder="##/##/####"></div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputStudentOpen">When does/did your school open for students? </label>
            <div class="controls"><input type="text" class="datePicker" id="inputStudentOpen" name="open_date_student" placeholder="##/##/####"></div>
          </div>
      
          <div class="control-group">
            <span class="control-label">Does your school need help at this time?</span>
            <div class="controls">
              <label class="radio"><input type="radio" name="q_fema_resources" id="needsHelp1" <?php if (isset($status['q_fema_resources']) && $status['q_fema_resources'] == 1) echo ' checked="checked" '; ?>value="1">Yes</label>
              <label class="radio"><input type="radio" name="q_fema_resources" id="needsHelp0" <?php if (isset($status['q_fema_resources']) && $status['q_fema_resources'] == 0) echo ' checked="checked" '; ?>value="0">No</label>
            </div>
          </div>
      
          <button id="needsProceed" data-target="#needsForm" class="btn btn-primary">Save and Proceed to Accessibility Section <i class="icon-chevron-right icon-white"></i></button>
      
      </fieldset>
    </div>
  </div>
  
  <!-- Step2 School Needs -->
  <div id="needsForm" class="tab-pane">
    <h3>Step 2. School Needs and Damage</h3>
    <p class="help-block">Please check the statements that indicate what needs and damage your school incurred<strong> as a result of Hurricane Sandy</strong>. <br/><br/>The boxes you check will ask you to provide the specific details of the needs or damage. <br/><br/>Additionally, if the need or damage is critical to the opening of your school, please indicate that by checking the "Necessary for Opening" box, which will flag that need or damage as a priority.<br/><br/></p>
    <div id="newNeed" class="form-horizontal">
    <fieldset>  
      <div>
        <label class="checkbox"><input type="checkbox" id="needElectricity" name="q_electricity" class="pChk" value="1" <?php if (!empty($status['q_electricity'])) echo 'checked="checked"'; ?>>The school has no electricity</label>
        <div class="control-group" id="electricityDetails">
          <label class="control-label" for="inputElectricityDetails">Please explain </label>
          <div class="controls">
            <input type="text" id="inputElectricityDetails" name="q_electricity_notes" value="<?php if (!empty($status['q_electricity_notes'])) echo $status['q_electricity_notes']; ?>">
            <label class="checkbox"><input type="checkbox" value="1" name="q_electricity_status_required" <?php if (!empty($status['q_electricity_status_required'])) echo 'checked="checked"'; ?>>Necessary for Opening</label>
          </div>
        </div>
      </div> 
        
    <div>
        <label class="checkbox"><input type="checkbox" id="needSupplies" name="q_student_resources" class="pChk" value="1" <?php if (!empty($status['q_student_resources'])) echo 'checked="checked"'; ?>>The school's supplies and technology were damaged</label>
    </div>
    
    <div class="control-group" id="supplyDetails">
      <label class="control-label" for="inputSupplyDetails">Please explain </label>
      <div class="controls">
        <input type="text" id="inputSupplyDetails" name="q_student_resources_notes" value="<?php if (!empty($status['q_student_resources_notes'])) echo $status['q_student_resources_notes']; ?>">
        <label class="checkbox"><input type="checkbox" name="q_student_resources_required" value="1" <?php if (!empty($status['q_student_resources_required'])) echo 'checked="checked"'; ?>>Necessary for Opening</label>
      </div>
    </div>
    
    <div>
        <label class="checkbox"><input type="checkbox" id="needWaterDamage" name="q_building_water" class="pChk" value="1" <?php if (!empty($status['q_building_water'])) echo 'checked="checked"'; ?>>The school has water damage</label>
    </div>
    
    <div class="control-group" id="waterDetails">
      <label class="control-label" for="inputWaterDetails" name="q_building_water_notes" value="<?php if (!empty($status['q_building_water_notes'])) echo $status['q_building_water_notes']; ?>">Please explain </label>
      <div class="controls">
        <input type="text" id="inputWaterDetails">
        <label class="checkbox"><input type="checkbox" name="q_building_water_required" value="1" <?php if (!empty($status['q_building_water_required'])) echo 'checked="checked"'; ?>>Necessary for Opening</label>
      </div>
    </div>
    
    <div>
        <label class="checkbox"><input type="checkbox" id="needMold" name="q_building_mold" class="pChk" value="1" <?php if (!empty($status['q_building_mold'])) echo 'checked="checked"'; ?>>There is mold in the school</label>
    </div>
    
    <div class="control-group" id="moldDetails">
      <label class="control-label" for="inputMoldDetails">Please explain </label>
      <div class="controls">
        <input type="text" id="inputMoldDetails" name="q_building_mold_notes" value="<?php if (!empty($status['q_building_mold_notes'])) echo $status['q_building_mold_notes']; ?>">
        <label class="checkbox"><input type="checkbox" name="q_building_mold_required" value="1" <?php if (!empty($status['q_building_mold_required'])) echo 'checked="checked"'; ?>>Necessary for Opening</label>
      </div>
    </div>
        
    <div>
        <label class="checkbox"><input type="checkbox" id="needStructure" name="q_building_structural" class="pChk" value="1" <?php if (!empty($status['q_building_structural'])) echo 'checked="checked"'; ?>>The school's building has structural damage</label>
    </div>
        
    <div class="control-group" id="structureDetails">
      <label class="control-label" for="inputStructureDetails">Please explain </label>
      <div class="controls">
        <input type="text" id="inputStructureDetails" name="q_building_structural_notes" value="<?php if (!empty($status['q_building_structural_notes'])) echo $status['q_building_structural_notes']; ?>">
        <label class="checkbox"><input type="checkbox" name="q_building_structural_required" value="1" <?php if (!empty($status['q_building_structural_required'])) echo 'checked="checked"'; ?>>Necessary for Opening</label>
      </div>
    </div>
       
    <div>
        <label class="checkbox"><input type="checkbox" id="needCafeteria" name="q_building_cafeteria" class="pChk" value="1" <?php if (!empty($status['q_building_cafeteria'])) echo 'checked="checked"'; ?>>The school's cafeteria was damaged</label>
    </div>
    
    <div class="control-group" id="cafeteriaDetails">
      <label class="control-label" for="inputCafeteriaDetails">Please explain </label>
      <div class="controls">
        <input type="text" id="inputCafeteriaDetails" name="q_building_cafeteria_notes" value="<?php if (!empty($status['q_building_cafeteria_notes'])) echo $status['q_building_cafeteria_notes']; ?>">
        <label class="checkbox"><input type="checkbox" name="q_building_cafeteria_required" value="1" <?php if (!empty($status['q_building_cafeteria_required'])) echo 'checked="checked"'; ?>>Necessary for Opening</label>
      </div>
    </div>
       
    <div>
        <label class="checkbox"><input type="checkbox" id="needOther" name="q_building_contents" class="pChk" value="1" <?php if (!empty($status['q_building_contents'])) echo 'checked="checked"'; ?>>Other contents of the school's building were damaged</label>
    </div>
    
    <div class="control-group" id="otherDetails">
      <label class="control-label" for="inputOtherDetails">Please explain </label>
      <div class="controls">
        <input type="text" id="inputOtherDetails" name="q_building_contents_notes" value="<?php if (!empty($status['q_building_contents_notes'])) echo $status['q_building_contents_notes']; ?>">
        <label class="checkbox"><input type="checkbox" name="q_building_contents_required" value="1" <?php if (!empty($status['q_building_contents_required'])) echo 'checked="checked"'; ?>>Necessary for Opening</label>
      </div>
    </div>
       
    <div>
        <label class="checkbox"><input type="checkbox" id="needADAcomp" name="q_building_ada" class="pChk" value="1" <?php if (!empty($status['q_building_ada'])) echo 'checked="checked"'; ?>>The ADA compliance of the school's building was affected</label>
    </div>
    
    <div class="control-group" id="ADAcompDetails">
      <label class="control-label" for="inputADAcompDetails">Please explain </label>
      <div class="controls">
        <input type="text" id="inputADAcompDetails" name="q_building_ada_notes" value="<?php if (!empty($status['q_building_ada_notes'])) echo $status['q_building_ada_notes']; ?>">
        <label class="checkbox"><input type="checkbox" name="q_building_ada_required" value="1" <?php if (!empty($status['q_building_ada_required'])) echo 'checked="checked"'; ?>>Necessary for Opening</label>
      </div>
    </div>
       
    <div>
        <label class="checkbox"><input type="checkbox" id="needEtc" name="q_building_access" class="pChk" value="1" <?php if (!empty($status['q_building_access'])) echo 'checked="checked"'; ?>>There are other issues preventing students, faculty, and staff from physically entering the building</label>
    </div>
    
    <div class="control-group" id="etcDetails">
      <label class="control-label" for="inputEtcDetails">Please explain </label>
      <div class="controls">
        <input type="text" id="inputEtcDetails" name="q_building_access_notes" value="<?php if (!empty($status['q_building_access_notes'])) echo $status['q_building_access_notes']; ?>">
        <label class="checkbox"><input type="checkbox" name="q_building_access_required" value="1" <?php if (!empty($status['q_building_access_required'])) echo 'checked="checked"'; ?>>Necessary for Opening</label>
      </div>
    </div>     

  <input type="hidden" name="entity_nces_id" value="<?php echo $entity['id_nces']; ?>" /> 
  <input type="hidden" name="entity_type" value="school" />

            <button id="accessProceed" data-target="#accessForm" class="btn btn-primary">Save and Proceed to Needs Section <i class="icon-chevron-right icon-white"></i></button>
  
  </fieldset>
  </div>
  </div>    <!-- End Step2 School Needs -->
  
    <!-- Step3 School Access -->
    <div id="accessForm" class="tab-pane">
      <h3>Step 3. School Accessibilty</h3>
      <div id="newAccess" class="form-horizontal">
        <fieldset>
      

          <div class="control-group">
            <label class="control-label" for="inputTransStatusStud">What mode of transportation is available to students? </label>
            <div class="controls"><input type="text" id="inputTransStatusStud" name="q_student_transport" value="<?php if (!empty($status['q_student_transport'])) echo $status['q_student_transport']; ?>" placeholder="Student Transportation Status"></div>
          </div>
      
          <div class="control-group">
            <label class="control-label" for="inputStudentPercent">What (approximate) percentage of your students can get to school? </label>
            <div class="controls"><input type="text" id="inputStudentPercent" name="q_student_percentage" value="<?php if (!empty($status['q_student_percentaged'])) echo $status['q_student_percentage']; ?>" placeholder="Attendance%"></div>
          </div>

          <div class="control-group">
            <label class="control-label" for="inputTransStatusTeach">What mode of transportation is available to faculty and staff? </label>
            <div class="controls"><input type="text" id="inputTransStatusTeach" name="q_teacher_transport" value="<?php if (!empty($status['q_teacher_transportd'])) echo $status['q_teacher_transport']; ?>" placeholder="Teacher Transportation Status"></div>
          </div>
      
          <div class="control-group">
            <label class="control-label" for="inputTeacherPercent">What (approximate) percentage of faculty and staff can get to school? </label>
            <div class="controls"><input type="text" id="inputTeacherPercent" name="q_teacher_percentage" value="<?php if (!empty($status['q_teacher_percentaged'])) echo $status['q_teacher_percentage']; ?>" placeholder="Attendance%"></div>
          </div>


          Email: <input type="text" name="email" id="inputEmail">
          Password: <input type="password" name="password" id="inputPasskey">
      
          <input type="submit" class="btn btn-success" value="Authenticate and Submit" /> 
          <p class="help-inline"><i class="icon-question-sign"></i>In order to submit new school data you need to obtain a passkey. To request a passkey click <a href=""> here </a></p>
      
        </fieldset>
      </div>
    </div>  <!-- End Step3 School Access -->
      

  
  </form>

<?php include 'footer_inc_view.php';?>

  <!--submission modal -->
  <div id="submitModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="submitModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="submitModalLabel">Submit Info: Authentication</h3>
    </div>
    <div class="modal-body">
      <p>Please enter your passkey. If you don't have a passkey, request one <a href"">here</a>.</p>
      <form>
        <fieldset>
          <input type="text" name="passkey" id="inputPasskey">
          <input type="submit" class="btn btn-success" value="Submit and Return to School Page" />
          <button class="btn btn-success">Cancel</button>  
        </fieldset>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
  </div>
  </div>
  </body>
</html>