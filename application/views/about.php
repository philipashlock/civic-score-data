<?php include 'header_meta_inc_view.php';?>
  



<?php include 'header_inc_view.php';?>

    


	<div class="hero-unit2">
 	<h1>About CivicScore</h1>
 	</br>
  	<h3>A prototype project developed at FOCAS</h3>
  	<p>
		More info
  	</p>
  </div>

<?php

if(!empty($message)) {
	echo $message;
}


?>

<form method="post" action="/about/subscribe">
	
	<fieldset>
	<label for="email">Your Email</label>
	<input type="text" name="email" id="email">
	</fieldset>
	<input type="submit" value="Subscribe">
			
</form>

    
<?php include 'footer_inc_view.php';?>