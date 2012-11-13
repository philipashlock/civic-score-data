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



  <form method="post" action="/status/user_update" class="span9">
  
    <!-- Step1 School Info -->
    <div id="infoForm" class="tab-pane active">
      <h3>Change your Password</h3>
      <div id="newInfo" class="form-horizontal">
	
        <fieldset>      

		<fieldset>
          <div class="control-group info">
            <label class="control-label" for="inputEmail">Your Email: </label>
            <div class="controls"><input type="text" id="inputEmail" name="email"></div>
          </div>

          <div class="control-group info">
            <label class="control-label" for="inputPasskey">Old Password: </label>
            <div class="controls"><input type="password" id="inputPasskey" name="password"></div>
          </div>
		</fieldset>
		
        <div class="control-group info-warning">
          <label class="control-label" for="inputTeacherOpen">New Password: </label>
          <div class="controls"><input type="password" name="new_password" placeholder="*********" value=""></div>
        </div>		
      
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