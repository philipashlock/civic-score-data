<?php include 'header_meta_inc_view.php';?>

  <script>
  $(document).ready(function() {

  });
  </script>

<?php include 'header_inc_view.php';?>


  <?php
    if (!empty($entity)) {
	?>
  <div id="schoolinfo" class="span9">
	
	<?php if (!empty($district)): ?>
     <div class="row">
       <div id="districtName" class="span6">
         <h3><?php if(isset($district['state_district_name'])) echo $district['state_district_name']; elseif(isset($district['agency_name'])) echo 'District: ' . $district['agency_name']; ?></h3>
         <address>
           <h4>Address:</h4><br/>
           <?php echo $district['location_address']; ?><br/>
           <?php echo $district['location_city']; ?>, <?php echo $district['location_state']; ?> <?php echo $district['location_zip']; ?><br/>
           <p><a href="https://maps.google.com/?q=<?php echo $district['latitude']; ?>,<?php echo $district['longitude']; ?>">View on a map</a></p>

           <h4>Phone:</h4> <?php if (!empty($district_status['contact_point_phone'])) echo $district_status['contact_point_phone']; elseif (!empty($district['state_phone'])) echo $district['state_phone'];   elseif (!empty($district['phone'])) echo $district['phone']?><br/>
           <h4>Email:</h4> <?php if (!empty($district_status['contact_point_email'])) echo $district_status['contact_point_email']; elseif (!empty($district['supt_email'])) echo $district['supt_email']; else echo "No email address listed"; ?><br/>
           <h4>Website:</h4> <?php if (!empty($district_status['website'])) echo '<a href="' . $district_status['website']. '">' . $district_status['website'] . '</a>'; elseif (!empty($district['website'])) echo '<a href="' . $district['website']. '">' . $district['website'] . '</a>';?><br/>

         </address>
       </div>
       <div class="span3">
         <a href="../status/district/<?php echo $district['agency_id_nces']; ?>" role="button" class="btn btn-success"><i class="icon-star icon-white"></i> Edit District</a>
       </div>
     </div>	

     <div id="status">
        <h3>Status</h3>
	<?php if (!empty($district_status['status'])): echo ""?>
       <p><icon></i><?php echo $district_status['status']; ?></p>
	<?php else : ?>
      <p>No Status Data Found</p>
	<?php endif ?>
	     </div>

	<?php endif; ?>

     <div class="row">
       <div id="schoolName" class="span6">
         <h3><?php echo $entity['full_name']; ?></h3>
         <address>
           <h4>Address:</h4><br/>
           <?php echo $entity['location_address']; ?><br/>
           <?php echo $entity['location_city']; ?>, <?php echo $entity['location_state']; ?> <?php echo $entity['location_zip']; ?><br/>
           <p><a href="https://maps.google.com/?q=<?php echo $entity['latitude']; ?>,<?php echo $entity['longitude']; ?>">View on a map</a></p>
           <h4>Phone:</h4> <?php if (!empty($status['contact_point_phone'])) echo $status['contact_point_phone']; elseif (!empty($entity['phone'])) echo $entity['phone']; ?><br/>
           <h4>Email:</h4> <?php if (!empty($status['contact_point_email'])) echo $status['contact_point_email']; else echo "No email address listed"; ?><br/>
         </address>
       </div>
       <div class="span3">
         <a href="../status/school/<?php echo $entity['id_nces']; ?>" role="button" class="btn btn-success"><i class="icon-star icon-white"></i> Edit School</a>
       </div>
     </div>
     <div id="status">
        <h3>Status</h3>
	<?php if (!empty($status['status'])): echo ""?>
       <p><icon></i><?php echo $status['status']; ?></p>
	<?php else : ?>
      <p>No Status Data Found</p>
	<?php endif ?>
	     </div>
     <div id="details">
       <h3>Details</h3>
       <h4>Accessibility</h4>
       <table class="table" id="accessTable">
         <th>Personnel Category</th><th>Transporation</th><th>Attendance %</th>
         <tr>
           <td>Students</td>
           <td>	<?php if (!empty($status['q_student_transport'])): echo $status['q_student_transport'];
                      else: ?>No data found<?php endif ?></td>
           <td>	<?php if (!empty($status['q_student_percentage'])): echo $status['q_student_percentage'];
                      else: ?>No data found<?php endif ?></td>
         </tr>
         <tr>
           <td>Teachers and Staff</td>
           <td>	<?php if (!empty($status['q_teacher_transport'])): echo $status['q_teacher_transport'];
                      else: ?>No data found<?php endif ?></td>
           <td>	<?php if (!empty($status['q_teacher_percentage'])): echo $status['q_teacher_percentage'];
                      else: ?>No data found<?php endif ?></td>
           </tr>
        </table>


		<?php 		
		function format_needs($needs_type) {
			if (isset($needs_type)) { 
				if ($needs_type == 1) 		return '<i class="icon-wrench"></i> '; 
				elseif ($needs_type == 0) 	return '<i class="icon-ok"></i> ';
			} else {						return 'No data found'; } 
		}	
		function format_req($req_flag) {
			if (isset($req_flag)) { 
				if ($req_flag == 1) 		return '<i class="icon-ok"></i> '; 
				elseif ($req_flag == 0) 	return '';
			} else {						return 'No data found'; } 
		}		
		?>

        <h4>Needs and Damages</h4>
        <table class="table" id="needTable">
         <th>Category</th><th>Present?</th><th>Details</th><th>Priority?</th>
          <tr>
             <td>Electricity</td>
             <td>
				<?php echo format_needs($status['q_electricity']); ?>
			 </td>
             <td><?php if (!empty($status['q_electricity_notes'])): echo $status['q_electricity_notes'];
                         else: ?>No data found<?php endif ?></td>
             <td><?php if (isset($status['q_electricity_status_required'])): echo $status['q_electricity_status_required'];
                         else: ?>No data found<?php endif ?></td>
           </tr>
           <tr>
              <td>Supplies and Technology</td>
              <td>				
				<?php echo format_needs($status['q_student_resources']); ?>
			  </td>
              <td><?php if (!empty($status['q_student_resources_notes'])): echo $status['q_student_resources_notes'];
                          else: ?>No data found<?php endif ?></td>
              <td><?php echo format_req($status['q_student_resources_required']); ?></td>
            </tr>
            <tr>
               <td>Water Damage</td>
	           <td>				
			     <?php echo format_needs($status['q_building_water']); ?>
			   </td>
               <td><?php if (!empty($status['q_building_water_notes'])): echo $status['q_building_water_notes'];
                           else: ?>No data found<?php endif ?></td>
               <td><?php echo format_req($status['q_building_water_required']); ?></td>
             </tr>
             <tr>
                <td>Mold</td>
	           <td>				
			     <?php echo format_needs($status['q_building_mold']); ?>
			   </td>
                <td><?php if (!empty($status['q_building_mold_notes'])): echo $status['q_building_mold_notes'];
                            else: ?>No data found<?php endif ?></td>
                <td><?php echo format_req($status['q_building_mold_required']); ?></td>
              </tr>
              <tr>
                 <td>Structural Damage</td>
	           <td>				
			     <?php echo format_needs($status['q_building_structural']); ?>
			   </td>

                 <td><?php if (!empty($status['q_building_structural_notes'])): echo $status['q_building_structural_notes'];
                             else: ?>No data found<?php endif ?></td>
                 <td><?php echo format_req($status['q_building_structural_required']); ?></td>
               </tr>
               <tr>
                  <td>Cafeteria</td>
	           <td>				
			     <?php echo format_needs($status['q_building_cafeteria']); ?>
			   </td>

                  <td><?php if (!empty($status['q_building_cafeteria_notes'])): echo $status['q_building_cafeteria_notes'];
                              else: ?>No data found<?php endif ?></td>
                  <td><?php echo format_req($status['q_building_cafeteria_required']); ?></td>
                </tr>
                <tr>
                   <td>Other Contents</td>
		           <td>				
				     <?php echo format_needs($status['q_building_contents']); ?>
				   </td>

                   <td><?php if (!empty($status['q_building_contents_notes'])): echo $status['q_building_contents_notes'];
                               else: ?>No data found<?php endif ?></td>
                   <td><?php echo format_req($status['q_building_contents_required']); ?></td>
                 </tr>
                 <tr>
                    <td>ADA Compliance</td>
		           <td>				
				     <?php echo format_needs($status['q_building_ada']); ?>
				   </td>

                    <td><?php if (!empty($status['q_building_ada_notes'])): echo $status['q_building_ada_notes'];
                                else: ?>No data found<?php endif ?></td>
                    <td><?php echo format_req($status['q_building_ada_required']); ?></td>
                  </tr>
                  <tr>
                     <td>Access Damage</td>
		           <td>				
				     <?php echo format_needs($status['q_building_access']); ?>
				   </td>

                     <td><?php if (!empty($status['q_building_access_notes'])): echo $status['q_building_access_notes'];
                                 else: ?>No data found<?php endif ?></td>
                     <td><?php echo format_req($status['q_building_access_required']); ?></td>
                   </tr>

         </table>
       </table>
     </div>
  </div>
    </div>
  <?php
  }
  ?>

<?php include 'footer_inc_view.php';?>