<?php include 'header_meta_inc_view.php';?>

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
   <script src="/mockup/js/bootstrap.js"></script>
  <script>
  $(document).ready(function() {
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
    })

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


  <div class="span9">
  <p>Do you have information about a school you work at or live near? Please submit as much specific information as you can. This information will supplement the data national recovery teams are receiving from field offices. Hopefully your help will mean that the recovery effort is more efficient and directed. Thanks for volunteering!</p>
  </div>
  
  <div class="span9">
    <ul class="nav nav-tabs span9" id="myTab">
      <li class="active"><a href="#infoForm">School Info</a></li>
      <li><a href="#accessForm">Accessibility</a></li>
      <li><a href="#needsForm">Needs and Damage</a></li>
    </ul>
  </div>
  
  <form method="post" action="/status/update" class="tab-content span9">
  
    <!-- Step1 School Info -->
    <div id="infoForm" class="tab-pane active">
      <h3>Step 1. School Information</h3>
      <div id="newInfo" class="form-horizontal">
        <fieldset>
      
          <div class="control-group">
            <label class="control-label" for="inputSchoolName">School Name: </label>
            <div class="controls"><input type="text" id="inputSchoolName" value="<?php echo $entity['full_name']; ?>" disabled></div>
          </div>
        
          <div class="control-group">
            <label class="control-label" for="inputContactName">Point of Contact: </label>
            <div class="controls"><input type="text" id="inputContactName" placeholder="Point of Contact"></div>
          </div>
        
          <div class="control-group">
            <label class="control-label" for="inputContactPhone">Phone Number: </label>
            <div class="controls"><input type="text" id="inputContactPhone" value="<?php echo $entity['phone']; ?>"></div>
          </div>
        
          <div class="control-group">
            <span class="control-label">Current School Status:</span>
            <div class="controls">
              <select name="status">
                <option>-- Select School Status --</option>
                <option>Open</option>
                <option>Relocated</option>
                <option>Closed</option>
              </select>
            </div>
          </div>
        
          <div class="control-group">
            <label class="control-label" for="inputOpenDate">When does/did your school open/relocate? </label>
            <div class="controls"><input type="text" id="inputOpenDate" placeholder="Open Date"></div>
          </div>
      
          <div class="control-group">
            <span class="control-label">Does your school need help at this time?</span>
            <div class="controls">
              <label class="radio"><input type="radio" name="optionsRadios" id="needsHelp1" value="yes">Yes</label>
              <label class="radio"><input type="radio" name="optionsRadios" id="needsHelp0" value="no">No</label>
            </div>
          </div>
      
          <button id="submitInfo" class="btn btn-success">Submit and Return to School Page</button>
          <button id="needsProceed" class="btn btn-primary" disabled>Save and Proceed to Accessibility Section <i class="icon-chevron-right icon-white"></i></button>
      
      </fieldset>
    </div>
  </div>
  
    <!-- Step2 School Access -->
    <div id="accessForm" class="tab-pane">
      <h3>Step 2. School Accessibilty</h3>
      <div id="newAccess" class="form-horizontal">
        <fieldset>
      
          <div class="control-group">
            <label class="control-label" for="inputTransStatusStud">What mode of transportation is available to students? </label>
            <div class="controls"><input type="text" id="inputTransStatusStud" placeholder="Student Transportation Status"></div>
          </div>
      
          <div class="control-group">
            <label class="control-label" for="inputStudentPercent">What (approximate) percentage of your students can get to school? </label>
            <div class="controls"><input type="text" id="inputStudentPercent" placeholder="Attendance%"></div>
          </div>

          <div class="control-group">
            <label class="control-label" for="inputTransStatusTeach">What mode of transportation is available to faculty and staff? </label>
            <div class="controls"><input type="text" id="inputTransStatusTeach" placeholder="Teacher Transportation Status"></div>
          </div>
      
          <div class="control-group">
            <label class="control-label" for="inputTeacherPercent">What (approximate) percentage of faculty and staff can get to school? </label>
            <div class="controls"><input type="text" id="inputTeacherPercent" placeholder="Attendance%"></div>
          </div>
      
          <button class="btn btn-success">Submit and Return to School Page</button>
          <button id="needsProceed" class="btn btn-primary" disabled>Save and Proceed to Needs Section <i class="icon-chevron-right icon-white"></i></button>
      
        </fieldset>
      </div>
    </div>  <!-- End Step2 School Access -->
      
    <!-- Step3 School Needs -->
    <div id="needsForm" class="tab-pane">
      <h3>Step 3. School Needs and Damage</h3>
      <p class="help-block">Please check the statements that indicate what needs and damage your school incurred<strong> as a result of Hurricane Sandy</strong>. <br/><br/>The boxes you check will ask you to provide the specific details of the needs or damage. <br/><br/>Additionally, if the need or damage is critical to the opening of your school, please indicate that by checking the "Necessary for Opening" box, which will flag that need or damage as a priority.<br/><br/></p>
      <div id="newNeed" class="form-horizontal">
      <fieldset>  
        <div>
          <label class="checkbox"><input type="checkbox" id="needElectricity" class="pChk" value="">The school has no electricity</label>
          <div class="control-group" id="electricityDetails">
            <label class="control-label" for="inputElectricityDetails">Please explain </label>
            <div class="controls">
              <input type="text" id="inputElectricityDetails">
              <label class="checkbox"><input type="checkbox" value="">Necessary for Opening</label>
            </div>
          </div>
        </div>
          
      <div>
          <label class="checkbox"><input type="checkbox" id="needSupplies" class="pChk" value="">The school's supplies and technology were damaged</label>
      </div>
      
      <div class="control-group" id="supplyDetails">
        <label class="control-label" for="inputSupplyDetails">Please explain </label>
        <div class="controls">
          <input type="text" id="inputSupplyDetails">
          <label class="checkbox"><input type="checkbox" value="">Necessary for Opening</label>
        </div>
      </div>
      
      <div>
          <label class="checkbox"><input type="checkbox" id="needWaterDamage" class="pChk" value="">The school has water damage</label>
      </div>
      
      <div class="control-group" id="waterDetails">
        <label class="control-label" for="inputWaterDetails">Please explain </label>
        <div class="controls">
          <input type="text" id="inputWaterDetails">
          <label class="checkbox"><input type="checkbox" value="">Necessary for Opening</label>
        </div>
      </div>
      
      <div>
          <label class="checkbox"><input type="checkbox" id="needMold" class="pChk" value="">There is mold in the school</label>
      </div>
      
      <div class="control-group" id="moldDetails">
        <label class="control-label" for="inputMoldDetails">Please explain </label>
        <div class="controls">
          <input type="text" id="inputMoldDetails">
          <label class="checkbox"><input type="checkbox" value="">Necessary for Opening</label>
        </div>
      </div>
          
      <div>
          <label class="checkbox"><input type="checkbox" id="needStructure" class="pChk" value="">The school's building has structural damage</label>
      </div>
          
      <div class="control-group" id="structureDetails">
        <label class="control-label" for="inputStructureDetails">Please explain </label>
        <div class="controls">
          <input type="text" id="inputStructureDetails">
          <label class="checkbox"><input type="checkbox" value="">Necessary for Opening</label>
        </div>
      </div>
         
      <div>
          <label class="checkbox"><input type="checkbox" id="needCafeteria" class="pChk" value="">The school's cafeteria was damaged</label>
      </div>
      
      <div class="control-group" id="cafeteriaDetails">
        <label class="control-label" for="inputCafeteriaDetails">Please explain </label>
        <div class="controls">
          <input type="text" id="inputCafeteriaDetails">
          <label class="checkbox"><input type="checkbox" value="">Necessary for Opening</label>
        </div>
      </div>
         
      <div>
          <label class="checkbox"><input type="checkbox" id="needOther" class="pChk" value="">Other contents of the school's building were damaged</label>
      </div>
      
      <div class="control-group" id="otherDetails">
        <label class="control-label" for="inputOtherDetails">Please explain </label>
        <div class="controls">
          <input type="text" id="inputOtherDetails">
          <label class="checkbox"><input type="checkbox" value="">Necessary for Opening</label>
        </div>
      </div>
         
      <div>
          <label class="checkbox"><input type="checkbox" id="needADAcomp" class="pChk" value="">The ADA compliance of the school's building was affected</label>
      </div>
      
      <div class="control-group" id="ADAcompDetails">
        <label class="control-label" for="inputADAcompDetails">Please explain </label>
        <div class="controls">
          <input type="text" id="inputADAcompDetails">
          <label class="checkbox"><input type="checkbox" value="">Necessary for Opening</label>
        </div>
      </div>
         
      <div>
          <label class="checkbox"><input type="checkbox" id="needEtc" class="pChk" value="">There are other issues preventing students, faculty, and staff from physically entering the building</label>
      </div>
      
      <div class="control-group" id="etcDetails">
        <label class="control-label" for="inputEtcDetails">Please explain </label>
        <div class="controls">
          <input type="text" id="inputEtcDetails">
          <label class="checkbox"><input type="checkbox" value="">Necessary for Opening</label>
        </div>
      </div>     

    <input type="hidden" name="entity_nces_id" value="<?php echo $entity['id_nces']; ?>" /> 
    <input type="hidden" name="entity_type" value="school" /> 

    <input type="submit" class="btn btn-success" value="Submit and Return to School Page" /> 
    </fieldset>
    </div>
    </div>    <!-- End Step3 School Needs -->
  
  </form>

<?php include 'footer_inc_view.php';?>