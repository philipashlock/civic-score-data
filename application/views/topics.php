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

	if(!empty($subtopics[0]['topic'])) $heading = $subtopics[0]['topic'];

	$title = (!empty($heading)) ? $heading : 'FAQs';

	?>




<div data-role="page" data-add-back-btn="true">

	<div data-role="header">
		<h1>FAQs</h1>
					<a href="/" data-icon="home" class="ui-btn-right">Home</a>
	</div><!-- /header -->

	<div data-role="content">	

		<input type="search" value="Search">
		
		<?php

		if(!empty($topics)) {		

			echo '<ul data-role="listview" data-inset="true">';


			foreach ($topics as $topic) {


				$url = urlencode($topic['topic']);
				echo '<li><a href="/topics/subtopics?name=' . $url . '">' . $topic['topic'] . '</a></li>';

			}

		echo '</ul>';

		}
		?>		

	
	</div><!-- /content -->

</div><!-- /page -->



    
<?php include 'footer_inc_view.php';?>