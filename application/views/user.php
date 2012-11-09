<?php include 'header_meta_inc_view.php';?>

<?php include 'header_inc_view.php';?>


<?php if(!empty($messages)): ?>

	<div class="span9">
	
		<?php if(isset($messages['error'])):?>	
		<div class="alert alert-error">
			<?php echo $messages['error']; ?>
		</div>
		<?php endif; ?>

		<?php if(isset($messages['success'])):?>	
		<div class="alert alert-success">
			<?php echo $messages['success']; ?>
		</div>
		<?php endif; ?>

	</div>

<?php endif; ?>



  <form method="post" action="/status/user" class="span9">
  
    <!-- Step1 School Info -->
    <div id="infoForm" class="tab-pane active">
      <h3>User Information</h3>
      <div id="newInfo" class="form-horizontal">
	
        <fieldset>      
          <div class="control-group">
            <label class="control-label" for="inputContactName">Full Name: </label>
            <div class="controls"><input type="text" id="inputContactName" name="name" value="<?php if (!empty($status['contact_point_name'])) echo $status['contact_point_name']; ?>" placeholder="First Last"></div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputContactEmail">Email: </label>
            <div class="controls"><input type="text" id="inputContactEmail" name="email" value="<?php if (!empty($status['contact_point_email'])) echo $status['contact_point_email']; ?>"></div>
          </div>
        
          <div class="control-group">
            <span class="control-label">Role:</span>
            <div class="controls">
              <select name="role">
                <option value="">-- Select Role --</option>
				<?php if (!empty($status['status'])) $entity_status = $status['status']; else $entity_status = ''; ?>
                <option value="official"<?php if ($entity_status == 'official') echo ' selected="selected"'?>>Official</option>
                <option value="volunteer"<?php if ($entity_status == 'volunteer') echo ' selected="selected"'?>>Volunteer</option>
              </select>
            </div>
          </div>
        
          <div class="control-group info-warning">
            <label class="control-label" for="inputTeacherOpen">Password </label>
            <div class="controls"><input type="text" class="datePicker" id="inputTeacherOpen" name="password" placeholder="*********" value="<?php if (!empty($status['open_date_teachers'])) echo date("m/d/Y", strtotime($status['open_date_teachers'])); ?>"></div>
          </div>


		<fieldset>
          <div class="control-group info">
            <label class="control-label" for="inputEmail">Admin Email: </label>
            <div class="controls"><input type="text" id="inputEmail" name="admin_email"></div>
          </div>

          <div class="control-group info">
            <label class="control-label" for="inputPasskey">Admin Password: </label>
            <div class="controls"><input type="password" id="inputPasskey" name="admin_password"></div>
          </div>
		</fieldset>
      
       <input type="submit" class="btn btn-success" value="Authenticate and Submit" /> 
      
      </fieldset>
    </div>
  </div>
  
  
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