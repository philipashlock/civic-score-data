<?php include 'header_meta_inc_view.php';?>
  
    <script>
    $(document).ready(function() {
	
      $("#results").hide();
      $("#submit").button();

	    $("#submit").click(function (event) { 
		
        event.preventDefault();
        $(this).button('loading');

   	    var searchstring = $("#inputNameorID").val();

		if (searchstring) {
			ajax_url = 'answer?search=' + searchstring;
		}
	

				$.ajax({
				  url: '/api/' + ajax_url,
				  success: function(data) {
					
					$.each(data, function(){
              			$("#results").show();


			  			$('#resultsTable').append(
					        			'<tr><td><a href="../answer/' + this.faq_id + '">' +
					        			 this.question + '</a></td><td>' + this.topic + '</td>'
					      				);					   
			 							});
				    }
				  });
				
				$(this).button('reset');		  		
        
        });	
 



    });
    </script>

    
<?php

if(!empty($search)) {
	
	$heading = 'Search: ' . $search;
}

else if(!empty($answers[0]['topic'])) {

	$heading = $answers[0]['topic'];
	
	if (!empty($answers[0]['sub_topic'])) $heading = $answers[0]['sub_topic'] . ' &bull; ' . $heading;
}

else if(!empty($answer['question'])) $heading = $answer['question'];


$title = $heading;

?>

<?php include 'header_inc_view.php';?>

		
		<?php


	
	  if(!empty($answers)) {		
      
	  	echo '<ul data-role="listview" data-inset="true">';
      
      
	  	foreach ($answers as $answer) {
      
	  		echo '<li><a href="/answers/' . $answer['faq_id'] . '">' . $answer['question'] . '</a></li>';
      
	  	}
      
	  	echo '</ul>';
		$answer = null;
		}
		
		
	  if(!empty($answer)) {		

	  	echo "<h3>{$answer['question']}</h3>";

		echo '<div class="ui-body ui-body-d ui-corner-all">';
	  	echo $answer['answer_html'];	

		echo '<p style="font-style : italic; color : #ccc">Last Updated: ';
	  	echo date("F j, Y, g:ia", strtotime($answer['last_updated']));	
		echo '</p>';


		echo '</div>';
	


		
		echo '<a href="/topics/subtopics/?name=' . urlencode($answer['topic']) . '" data-theme="b" data-icon="arrow-l" data-role="button">' . $answer['topic'] . '</a>';
	
	
		}		
		
		?>		

	
	</div><!-- /content -->

</div><!-- /page -->



    
<?php include 'footer_inc_view.php';?>