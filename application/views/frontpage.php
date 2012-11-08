<?php include 'header_meta_inc_view.php';?>
  
    <script>
    $(document).ready(function() {
	
      $("#results").hide();
      $("#submit").button();

	    $("#submit").click(function (event) { 
		
        event.preventDefault();
<<<<<<< HEAD
        $("#submit").button('loading');
			  var searchstring = $("#inputNameorID").val();
=======
        $(this).button('loading');

   	    var searchstring = $("#inputNameorID").val();
>>>>>>> Trying to fix loading button

				$.ajax({
				  url: '/api/schools?search=' + searchstring,
				  success: function(data) {
					
					$.each(data, function(){
              			$("#results").show();

	        			 switch(this.status) {
	        			   case 'open':
	        			      var schoolstatus = ' class="open"><i class="icon-ok-sign"></i> ' + capitaliseFirstLetter(this.status) + '</td></tr>';
	        			      break;
	        			    case 'closed':
	        			      var schoolstatus = ' class="closed"><i class="icon-minus-sign"></i> ' + capitaliseFirstLetter(this.status) + '</td></tr>';
	        			      break;
	        			    case 'relocated':
	        			      var schoolstatus = ' class="relocated"><i class="icon-warning-sign"></i> ' + capitaliseFirstLetter(this.status) + '</td></tr>';
							  break;
	        			    default:
	        			      var schoolstatus = ' >No data found</td></tr>';
	        			 }
	
						function capitaliseFirstLetter(string) {
						    return string.charAt(0).toUpperCase() + string.slice(1);
						}

			  			$('#resultsTable').append(
					        			'<tr><td><a href="../school/' + this.id_nces + '">' +
					        			 this.full_name + '</a></td><td' + schoolstatus
					      				);					   
			 							});
				    }
				  });
				
				$(this).button('reset');		  		
        
        });	
  
        $("#inputNameorID").click(function (event) {
          $("#inputLocation").prop('disabled', true);
        });
        $("#inputLocation").click(function (event) {
          $("#inputNameorID").prop('disabled', true);
        });



    });
    </script>


<?php include 'header_inc_view.php';?>

    
    <!--search form -->
    <div id="search" class="span9">
    <span class="help-block">Search to find your school:</span>
    <form class="form-horizontal">
      <fieldset>
        <div class="control-group">
          <label class="control-label" for="inputNameorID">School Name: </label>
          <div class="controls"><input type="text" id="inputNameorID" placeholder="Name"></div>
        </div>
          
        <div class="control-group">
          <label class="control-label" for="inputLocation">Location: </label>
          <div class="controls"><input type="text" id="inputLocation" placeholder="State, City, County"></div>
        </div>
<<<<<<< HEAD
          <button type="submit" class="btn btn-success" id="submit" data-loading-text="Loading..." autocomplete="off"><i class="icon-search icon-white"></i> Search</button>
=======
          <button type="button" class="btn btn-success" id="submit" data-loading-text="Loading..."><i class="icon-search icon-white"></i> Search</button>
>>>>>>> Trying to fix loading button
          <button type="submit" class="btn btn-warning" id="reset">Reset</button>

      </fieldset>
    </form>
    
    <!--results -->
    <div>
    <div id="results" class="span9">
      <h2>Results</h2>
      <table class="table" id="resultsTable">
        <th>School Info</th><th>Status</th>
        <tbody>
          <tr><td></td><td></td>
          </tr>
        </tbody>
      </table>
    </div>
    
<?php include 'footer_inc_view.php';?>