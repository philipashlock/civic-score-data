<?php include 'header_meta_inc_view.php';?>
  



<?php include 'header_inc_view.php';?>

    


	<div class="hero-unit2">
 	<h1>How's my DMV?</h1>
 	</br>
  	<h3>The hundred best and worst DMVs in the USA, as rated on Yelp*. Have you rated a public agency recently?</h3>
	<p><em>* based on available data</em></p>
  	<p>
    <a class="btn2">
      Rate my DMV
    </a>
  </p>
  </div>

<div class="row">
<div class="span1">
</div>


</div>
<br/>
<br/>
<div class="row">
  	<div class="span12">
  		<div class="span5">
  		<h2><center>The Best</center></h2>
  			<table class="table table-hover">
  				<thead>
  					<tr>
  						<th> </th>
  						<th> </th>
  						<th>DMV</th>
  						<th>Score</th>
  						<th>Reviews</th>
  					</tr>
  				</thead>
  				<tbody>
	
					<?php					
					$count = 1;
					foreach ($best_rank as $ranking) {
					?>	
						
  					<tr>
  						<td><?php echo $count?></td>  					
  						<td><img src="<?php echo $ranking['photo_url']?>" width="115px" height="115px"></td>
  						<td><?php echo "{$ranking['city']}, {$ranking['state_code']}"?></td>
  						<td>
							<?php 
								$rating = $ranking['avg_rating'];
								while ($rating > 0) {
									if($rating > 0.5) {
										echo '<i class="icon-star"></i>';
									} else {
										echo '<i class="icon-star-half"></i>';
									}
									
									$rating--;
								}								
							?>  							
						</td>
  						<td>
							<a class="btn3" href="<?php echo $ranking['url']?>">
  								Reviews
  							</a>
						</td>
  					</tr>						
						
						
						
					<?php
						$count++;
					}
					?>
															
  				</tbody>
  			</table>
  
  		</div>
  		<div class="span1">  
  		</div>
  		<div class="span5">
  		<h2><center>The Worst</center></h2>
  			<table class="table table-hover">
  				<thead>
  					<tr>
  						<th> </th>
  						<th> </th>
  						<th>DMV</th>
  						<th>Score</th>
  						<th>Reviews</th>
  					</tr>
  				</thead>
  				<tbody>
	
					<?php					
					$count = 1;
					foreach ($worst_rank as $ranking) {
					?>	
						
  					<tr>
  						<td><?php echo $count?></td>  					
  						<td><img src="<?php echo $ranking['photo_url']?>" width="115px" height="115px"></td>
  						<td><?php echo "{$ranking['city']}, {$ranking['state_code']}"?></td>
  						<td> 
							<?php 
								$rating = $ranking['avg_rating'];
								while ($rating > 0) {
									if($rating > 0.5) {
										echo '<i class="icon-star"></i>';
									} else {
										echo '<i class="icon-star-half"></i>';
									}
									
									$rating--;
								}								
							?>							
						</td>
  						<td>
							<a class="btn3" href="<?php echo $ranking['url']?>">
  								Reviews
  							</a>
						</td>
  					</tr>						
						
						
						
					<?php
						$count++;
					}
					?>
															
  				</tbody>  			
  			
  			</table>  		
  		
  		</div>
  	</div>
  </div>


    
<?php include 'footer_inc_view.php';?>