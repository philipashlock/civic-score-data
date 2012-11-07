<?php include 'header_meta_inc_view.php';?>

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
   <script src="/mockup/js/bootstrap.js"></script>
  <script>
  $(document).ready(function() {

  });
  </script>

<?php include 'header_inc_view.php';?>


  <?php
    if (!empty($entity)) {
	?>
  <div id="schoolinfo" class="span9">
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
         <a href="../status/school/<?php echo $entity['id_nces']; ?>" role="button" class="btn btn-success"><i class="icon-star icon-white"></i>  Submit Data</a>
       </div>
     </div>
	<?php if (!empty($status['status'])): ?>
     <div id="status">
       <h3>Status</h3>
       <p><?php echo $status['status']; ?></p>
     </div>
	<?php else : ?>
     <div id="status">
       <h3>No Status Info</h3>
     </div>
	<?php endif ?>
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
        <h4>Needs and Damages</h4>
        <table class="table" id="needTable">
         <th>Category</th><th>Present?</th><th>Details</th><th>Priority?</th>
          <tr>
             <td>Electricity</td>
             <td><?php if (!empty($status['q_electricity']) {
                        switch $status['q_electricity'] {
                          case '1':
                            return echo "<icon class="icon-wrench"></i>";
                            break;
                          case '0':
                            return echo "<icon class="icon-ok"></i>";
                            break;
                          default:
                            break;
                          }
                        } else: ?>?<?php endif ?></td>
             <td><?php if (!empty($status['q_electricity_notes'])): echo $status['q_electricity_notes'];
                         else: ?>No data found<?php endif ?></td>
             <td><?php if (!empty($status['q_electricity_status_required'])): echo $status['q_electricity_status_required'];
                         else: ?>No data found<?php endif ?></td>
           </tr>
           <tr>
              <td>Supplies and Technology</td>
              <td><?php if (!empty($status['q_student_resources'])): echo $status['q_student_resources'];
                          else: ?>No data found<?php endif ?></td>
              <td><?php if (!empty($status['q_student_resources_notes'])): echo $status['q_student_resources_notes'];
                          else: ?>No data found<?php endif ?></td>
              <td><?php if (!empty($status['q_student_resources_required'])): echo $status['q_student_resources_required'];
                          else: ?>No data found<?php endif ?></td>
            </tr>
            <tr>
               <td>Water Damage</td>
               <td><?php if (!empty($status['q_building_water'])): echo $status['q_building_water'];
                           else: ?>No data found<?php endif ?></td>
               <td><?php if (!empty($status['q_building_water_notes'])): echo $status['q_building_water_notes'];
                           else: ?>No data found<?php endif ?></td>
               <td><?php if (!empty($status['q_building_water_required'])): echo $status['q_building_water_required'];
                           else: ?>No data found<?php endif ?></td>
             </tr>
             <tr>
                <td>Mold</td>
                <td><?php if (!empty($status['q_building_mold'])): echo $status['q_building_mold	'];
                            else: ?>No data found<?php endif ?></td>
                <td><?php if (!empty($status['q_building_mold_notes'])): echo $status['q_building_mold_notes'];
                            else: ?>No data found<?php endif ?></td>
                <td><?php if (!empty($status['q_building_mold_required'])): echo $status['q_building_mold_required'];
                            else: ?>No data found<?php endif ?></td>
              </tr>
              <tr>
                 <td>Structural Damage</td>
                 <td><?php if (!empty($status['q_building_structural'])): echo $status['q_building_structural'];
                             else: ?>No data found<?php endif ?></td>
                 <td><?php if (!empty($status['q_building_structural_notes'])): echo $status['q_building_structural_notes'];
                             else: ?>No data found<?php endif ?></td>
                 <td><?php if (!empty($status['q_building_structural_required'])): echo $status['q_building_structural_required'];
                             else: ?>No data found<?php endif ?></td>
               </tr>
               <tr>
                  <td>Cafeteria</td>
                  <td><?php if (!empty($status['q_building_cafeteria'])): echo $status['q_building_cafeteria'];
                              else: ?>No data found<?php endif ?></td>
                  <td><?php if (!empty($status['q_building_cafeteria_notes'])): echo $status['q_building_cafeteria_notes'];
                              else: ?>No data found<?php endif ?></td>
                  <td><?php if (!empty($status['q_building_cafeteria_required'])): echo $status['q_building_cafeteria_required'];
                              else: ?>No data found<?php endif ?></td>
                </tr>
                <tr>
                   <td>Other Contents</td>
                   <td><?php if (!empty($status['q_building_contents'])): echo $status['q_building_contents'];
                               else: ?>No data found<?php endif ?></td>
                   <td><?php if (!empty($status['q_building_contents_notes'])): echo $status['q_building_contents_notes'];
                               else: ?>No data found<?php endif ?></td>
                   <td><?php if (!empty($status['q_building_contents_required'])): echo $status['q_building_contents_required'];
                               else: ?>No data found<?php endif ?></td>
                 </tr>
                 <tr>
                    <td>ADA Compliance</td>
                    <td><?php if (!empty($status['q_building_ada'])): echo $status['q_building_ada'];
                                else: ?>No data found<?php endif ?></td>
                    <td><?php if (!empty($status['q_building_ada_notes'])): echo $status['q_building_ada_notes'];
                                else: ?>No data found<?php endif ?></td>
                    <td><?php if (!empty($status['q_building_ada_required'])): echo $status['q_building_ada_required'];
                                else: ?>No data found<?php endif ?></td>
                  </tr>
                  <tr>
                     <td>Access Damage</td>
                     <td><?php if (!empty($status['q_building_access'])): echo $status['q_building_access'];
                                 else: ?>No data found<?php endif ?></td>
                     <td><?php if (!empty($status['q_building_access_notes'])): echo $status['q_building_access_notes'];
                                 else: ?>No data found<?php endif ?></td>
                     <td><?php if (!empty($status['q_building_access_required'])): echo $status['q_building_access_required'];
                                 else: ?>No data found<?php endif ?></td>
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