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


<?php include 'header_inc_view.php';?>

    




<div data-role="page">

	<div data-role="header">
		<h1>FAQ Answers</h1>
	</div><!-- /header -->

	<div data-role="content">	

		<input type="search" value="Search">
		
		<?php


	
	  if(!empty($answers)) {		
      
	  	echo '<ul data-role="listview" data-inset="true">';
      
      
	  	foreach ($answers as $answer) {
      
	  		echo '<li><a href="/answers/' . $answer['faq_id'] . '">' . $answer['question'] . '</a></li>';
      
	  	}
      
	  	echo '</ul>';

		}
		
		
	  if(!empty($answer)) {		

	  	echo $answer['question'];

		echo '<div>';
	  	echo $answer['answer_html'];	
		echo '</div>';
	
		echo '<div>';
	  	echo $answer['last_updated'];	
		echo '</div>';
	
		echo '<div>';
	  	echo $answer['topic'];	
		echo '</div>';	
	
		}		
		
		?>		

	
	</div><!-- /content -->

</div><!-- /page -->



    
<?php include 'footer_inc_view.php';?>