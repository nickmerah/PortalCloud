      <!-- Main Content -->
      <div class="main-content">
            <section class="section">

              <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">

                  <h4 class="page-title m-b-0">School Attended</h4>
                </li>
                <li class="breadcrumb-item">
                  <a href="<?= base_url('applicant');?>">
                    <i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ul>

              <div class="col-md-9 col-xl-12">
							<div class="tab-content">
								 <div class="tab-pane fade show active" id="application" role="tabpanel">

									<div class="card">

										<div class="card-body">
											 	<h5 class="card-title mb-0"><strong>SCHOOL ATTENDED AND DATE</strong></h5> <hr>

						<table class="table table-hover my-0" width="100%" style="font-size:12px">
									<thead>
										<tr>
										  <th colspan="5"><strong>SCHOOL ATTENDED</strong></th>
									  </tr>
										<tr>
											<th>School Name</th>
                                             <th>Course of Study</th>
                                             <th>ND Matno</th>
											<th>From</th>
                                            <th>To</th>
                                        </tr>
									</thead>
									<tbody>







                                    <?php
									//check if courses has been filled

									  if ($stddetails[0]->biodata == 0 or $stddetails[0]->std_custome6 == 0)  {

								echo '<script type="text/javascript">
			alert("Kindly add your biodata and Olevel before School Details");
			window.location = "../applicant/my_application";
		</script>';  exit;}else {
									 $go = 1;
									 }

									$no =  count($std_eduhistory);
           foreach($std_eduhistory as $edu){ ?>
                                        <tr>
											<td><?= $edu->pname; ?></td>
											<td><?= $edu->programme_option; ?> </td>
                      <td><?= $edu->ndmatno; ?> </td>
                                            <td><?= $edu->fromdate; ?> </td>
                                            <td><?= $edu->todate;  ?> </td>
<?php 
$org = $edu->organization; $address = $edu->address; $itdatefrom = $edu->itdatefrom ; $itdateto= $edu->itdateto;
?>
                                        </tr>

                                        <?php } ?>

									</tbody>
								</table> <br /><table class="table table-hover my-0" width="100%" style="font-size:12px">
									<thead>
										<tr>
										  <th colspan="5"><strong>INDUSTRIAL TRAINING</strong></th>
									  </tr>
										<tr>
											<th><strong>Organization</strong></th>
                                             <th><strong>Address</strong></th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Action</th>
                                        </tr>
									</thead>
									<tbody>



							 
                                        <tr>
											<td><?= $org; ?></td>
											<td><?= $address; ?> </td>
                      <td><?= $itdatefrom; ?> </td>
                                            <td><?= $itdateto; ?> </td>
                                            <td><?php if ($std_custome5) {
												 echo 'N/A';
											 }else { ?>
                                              <a class="btn btn-primary" href="<?php echo base_url('/applicant/rem_school/'.$edu->eh_id); ?>">Remove</a>
                                            <?php } ?></td>
                                        </tr>

                                       

									</tbody>
								</table><br />

                                <?php


                               if ($stddetails[0]->stdprogramme_id == 2){

                                   $link = '<a href =  "'.base_url().'/applicant/appfinish/5" class="btn btn-info"><i class="fas fa-info"></i> Click here to Save and Continue</a>';
                               }else{
                                    $link = '<a href =  "'.base_url().'/applicant/appfinish/5" class="btn btn-info"><i class="fas fa-info"></i> Click here to Save and Continue</a>';
                               }




                                if ($std_custome5) {  echo ' <a href =  "'.base_url().'/applicant/declares" class="btn btn-success"><i class="fas fa-check"></i>Proceed to Declaration</a>   '; 
                                }elseif(count($std_eduhistory) == 0){ ?>

                               <strong>ADD SCHOOL ATTENDED  DETAILS</strong>
                                <hr /> <form   name="add_school"
    action="add_school" method="post">
                                <div class="row">





														  <div class="mb-3 col-md-12">
														<label class="form-label" for="inputLastName"><strong>Name of School</strong></label>


														<select name="schoolname"   id="schoolname"  class="form-control" required >
                   <option value="">Select Polytechnic</option>   <?php

foreach ($polys as $poly) {
?>
  <option value="<?php echo $poly->pid ?>"><?php echo $poly->pname ?></option>
  <?php
}
?>

                  </select>



</div>

<div class="mb-3 col-md-12" id="othercolor" >
														<label class="form-label" for="inputLastName"><strong>ND Matriculation No </strong></label>
														<input type="text" class="form-control" name="ndmatno"   autocomplete = "off">

</div>





 <div class="mb-3 col-md-6">
														<label class="form-label" for="inputLastName"><strong>Course of Study</strong></label>


														<select name="cos"   id="cos"  class="form-control" required>
                   <option value="">Select Course</option>   <?php

           foreach($courses as $course){
             echo "<option value='".$course->do_id."'>".$course->programme_option."</option>";
           }

?>

                  </select>



</div><div class="mb-3 col-md-6">
														<label class="form-label" for="inputCity"><strong> Grade</strong></label>
													<select name="grade"   id="grade"  class="form-control" required>
                   <option value="">Select Grade</option>   
                   <option value="First Class">First Class</option> 
                   <option value="Second Class Upper">Second Class Upper</option> 
                   <option value="Second Class Lower">Second Class Lower</option> 
                   <option value="Third Class">Third Class</option> 
                   <option value="Pass">Pass</option> 
                  </select>
</div>


             <div class="mb-3 col-md-6">
														<label class="form-label" for="inputCity"><strong>From</strong></label>
													<select name="fromdate"   id="fromdate"  class="form-control" required>
                 <option value="">Select Year</option>   <?php
$fyear = 1970;
for ($year = date('Y'); $year >= $fyear; $year--) {
?>
  <option value="<?php echo $year ?>"><?php echo $year ?></option>
  <?php
}
?>

                  </select>
</div>

<div class="mb-3 col-md-6">
														<label class="form-label" for="inputCity"><strong> To</strong></label>
													<select name="todate"   id="todate"  class="form-control" required>
                   <option value="">Select Year</option>   <?php
$tyear = 1970;
for ($syear = date('Y'); $syear >= $tyear; $syear--) {
?>
  <option value="<?php echo $syear ?>"><?php echo $syear ?></option>
  <?php
}
?>

                  </select>
</div>





<strong>ADD INDUSTRIAL TRAINING</strong>
                                <strong>DETAILS</strong>
                                <hr /> 

                                <div class="mb-3 col-md-12">
														<label class="form-label" for="inputCity"><strong>Organization</strong></label>
                            <input type="text" class="form-control" name="organization"   autocomplete = "off" required>
</div>

<div class="mb-3 col-md-12">
														<label class="form-label" for="inputCity"><strong>Address</strong></label>
                            <input type="text" class="form-control" name="address"  autocomplete = "off" required>
</div>
<div class="mb-3 col-md-6">
														<label class="form-label" for="inputCity"><strong>From</strong></label>
														<input type="date" class="form-control" name="itdatefrom"   autocomplete = "off" required>
</div>

<div class="mb-3 col-md-6">
														<label class="form-label" for="inputCity"><strong> To</strong></label>
													
														<input type="date" class="form-control" name="itdateto"  autocomplete = "off" required>
</div>


                                                     <button class="btn btn-success"><i class="fas fa-check"></i> Add   Details</button>

												</div>

                               </form>

								</div>

						</div>
								<?php  } else  {



								echo	 $link;?>

									 <?php
								}?>

								</div>



							</div>
						</div>
