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

    
    <!--search form -->
    <div id="search" class="row-fluid">
	    <span class="help-block">FAQ Search:</span>
	    <form class="form-horizontal">
	      <fieldset>
	        <div class="control-group">
	          <label class="control-label" for="inputNameorID">Question: </label>
	          <div class="controls"><input type="text" id="inputNameorID" placeholder="Name"></div>
	        </div>

	          <button type="submit" class="btn btn-success" id="submit" data-loading-text="Loading..." autocomplete="off"><i class="icon-search icon-white"></i> Search</button>

	      </fieldset>
	    </form>
    </div>

    <!--results -->
    <div id="results" class="row-fluid">
      <h2>Results</h2>
      <table class="table table-striped" id="resultsTable">
        <th>Question</th><th>Topic</th>
        <tbody>
          <tr>
			<td></td>
			<td></td>
          </tr>
        </tbody>
      </table>
    </div>
    
<?php include 'footer_inc_view.php';?>