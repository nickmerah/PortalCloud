      <!-- Main Content -->
      <div class="main-content">
            <section class="section">

              <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">

                  <h4 class="page-title m-b-0">Declaration</h4>
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
  											 	<h5 class="card-title mb-0"><strong>BIODATA</strong></h5> <hr>

                                           <?php if(isset($stddetails)): ?>


                                               <?php foreach($stddetails as $biodetail): ?>
                                               <div class="row">
                                               <div class="mb-3 col-md-12">
                                               <label class="form-label" for="inputFirstName"><strong>Photo</strong></label>
  													<br />
													  <?php
                    
					// $filename =  base_url('public/uploads/'.$biodetail->std_photo); 
						 $picurl = "http://student.tops.edu.ng:82/portal/supportadmin/jambphoto/";                     
																		   
																		   
																		   if ($biodetail->std_photo != "") { ?>
																				<img alt="Photo" src="<?=  $picurl.$biodetail->std_photo;?>"  width="135" height="131" />
																			   <?php }else { ?>
																			   
																				<img alt="Photo" src="<?= base_url('public/uploads/avatar.jpg');?>"  width="135" height="131" />
																				

																			   <?php } ?>


  													</div>
                                                      </div>

  												<div class="row">
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputFirstName"><strong>Application Number</strong></label>
  													<br /><?= $biodetail->app_no; ?>
  													</div>
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputLastName"><strong>Surname</strong></label>
  														<br /><?= $biodetail->surname; ?>

  													</div>
  												</div>

                                                  <div class="row">
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputFirstName"><strong>Firstname</strong></label>
  														<br /><?= $biodetail->firstname; ?>

  													</div>
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputLastName"><strong>Othername</strong></label>
                                                       <br />   <?= $biodetail->othernames; ?>

  													</div>
  												</div>

                                                   <div class="row">
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputFirstName"><strong>Email</strong></label>
                                                         <br /> <?= $biodetail->student_email; ?>

  													</div>
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputLastName"><strong>Phone Number</strong></label>
                                                         <br /> <?= $biodetail->student_mobiletel; ?>

  													</div>
  												</div>

                                                   <div class="row">
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputFirstName"><strong>Gender</strong></label>
                                                         <br /> <?php echo  ($biodetail->gender); ?>
  														 </div>
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputLastName"><strong>Marital Status</strong></label>
  													<br /> <?php echo  ($biodetail->marital_status); ?>
  													</div>
  												</div>

                                                  <div class="row">


                                                  <div class="mb-3 col-md-6">
  												 <label class="form-label" for="inputAddress"><strong>Date of Birth</strong></label>
  													<br /><?= date('F d, Y', strtotime($biodetail->birthdate)); ?>
  													</div>



                                                  </div>





  												<div class="mb-3">
  													<label class="form-label" for="inputAddress"><strong>Permanent Home Address</strong></label><br /><?= $biodetail->student_homeaddress; ?>

  												</div>
  												<div class="mb-3">
  													<label class="form-label" for="inputAddress2"><strong>Contact Address</strong></label><br /> <?= $biodetail->contact_address; ?>

  												</div>
                                                  <div class="row">
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputCity"><strong>State</strong></label><br /> <?= $biodetail->state_of_origin; ?>

  													</div>
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputState"><strong>LGA</strong></label><br /> <?= $biodetail->local_gov; ?>

  													</div>

  												</div>
                                                  <div class="row">
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputFirstName"><strong>Next of Kin Name</strong></label><br /> <?= $biodetail->next_of_kin; ?>

  													</div>
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputLastName"><strong>Next of Kin Phone Number</strong></label><br /> <?= $biodetail->nok_tel; ?>

  													</div>
  												</div>
                                                 <div class="row">
                                                  <div class="mb-3 col-md-6">
  													<label class="form-label" for="inputAddress"><strong>Next of Kin Address</strong></label><br /><?= $biodetail->nok_address; ?>

  												</div>

  												 <div class="mb-3 col-md-6">
  													<label class="form-label" for="inputAddress"><strong>Next of Kin Email</strong></label><br /><?= $biodetail->nok_email; ?>

  												</div></div>


                                                  <hr />

                                                   <h5 class="card-title mb-0"><strong>COURSE OF STUDY</strong></h5> <hr>
                                                      <div class="row">
  												 
  													<div class="mb-3 col-md-12">
  														<label class="form-label" for="inputState"><strong>Course of Study</strong></label><br /> <?= $firstchoice; ?>

  													</div>

  												</div>




                                                   <?php endforeach; ?>
                                                       <?php endif; ?>

                                                        <?php

if ($stddetails[0]->stdprogramme_id == 1 and $stddetails[0]->std_programmetype == 1) {



                                                        if(isset($jambs)): ?>

                                                       <hr />

                                                      <h5 class="card-title mb-0"><strong> UTME DETAILS</strong></h5> <hr>
  							 	  <div class="row">
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputCity"><strong>UTME No</strong></label><br /> <?=$jambs[0]->jambno;?>

  													</div>
  											 

  												</div>
  						<table class="table table-hover my-0" width="100%">
  									<thead>
  										<tr>
  											<th>Subject</th>
                                               <th>Score</th>

  										</tr>
  									</thead>
  									<tbody>







                                     <?php

   for($j = 1; $j <= 4 ; $j++)
   {
	   $subject = "subject$j";
	  $score = "score$j";
	   
	    ?>
                                          <tr>
  												<td><?= $jambs[0]->$subject ;?></td>
  											<td><?= $jambs[0]->$score ;?> </td>


  										</tr>

                                          <?php } ?>

  									</tbody>
  								</table>
                                                  
                                                  <div class="row">
  													<div class="mb-3 col-md-6">
  															<label class="form-label" for="inputCity"><strong>UTME Score </strong></label>:  <?= $jambs[0]->score ;?>
  													</div>
  												 
  												</div>

                                               <?php  endif; ?>

                                                        <?php  }

                                                        if ($stddetails[0]->stdprogramme_id == 2 ) {

                                                        if(isset($std_eduhistory)): ?>

                                                       <hr />
                                                      <h5 class="card-title mb-0"><strong>SCHOOL ATTENDED  AND DATES</strong></h5> <hr>

  						<table class="table table-hover my-0" width="100%">
  									<thead>
  										<tr>
  												<th>School Name</th>
                                               <th>Course of Study</th>
											   <th>ND Matric No</th>
  											<th>From</th>
                                              <th>To</th>
  										</tr>
  									</thead>
  									<tbody>







                                      <?php
             foreach($std_eduhistory as $edu){ ?>
                                          <tr>
  											<td><?= $edu->pname; ?></td>
  											<td><?= $edu->programme_option; ?> </td>
											  <td><?= $edu->ndmatno; ?> </td>
                                              <td><?= $edu->fromdate; ?> </td>
                                              <td><?= $edu->todate; ?> </td>
											  <?php 
$org = $edu->organization; $address = $edu->address; $itdatefrom = $edu->itdatefrom ; $itdateto= $edu->itdateto;
?>
  										</tr>

                                          <?php } ?>

  									</tbody>
  								</table>

								  <hr />
                                                      <h5 class="card-title mb-0"><strong>INDUSTRIAL TRAINING</strong></h5> <hr>

  						<table class="table table-hover my-0" width="100%">
  									<thead>
  										<tr>
  											<th>Organization</th>
                                               <th>Address</th>
  											<th>From</th>
                                              <th>To</th>
  										</tr>
  									</thead>
  									<tbody>







                                   
            
                                          <tr>
										  <td><?= $org; ?></td>
											<td><?= $address; ?> </td>
                      <td><?= $itdatefrom; ?> </td>
                                            <td><?= $itdateto; ?> </td>

  										</tr>

                                        

  									</tbody>
  								</table>

                                               <?php endif; ?>
                                               <br />
                                                <?php } if(isset($olevels)): ?>

                                                     <hr />

                                                       <h5 class="card-title mb-0"><strong>O'LEVEL RESULTS</strong></h5> <hr>

  						<table class="table table-hover my-0" width="100%">
  									<thead>
  										<tr>
  											<th>Exam Type</th>
                                            <th>Subject Name</th>
  											<th>Grade</th>
                                              <th>Date Obtained</th>
                                              <th>CenterNo</th>
                                              <th>ExamNo</th>
  									</thead>
  									<tbody>







                                      <?php
            foreach($olevels as $olevel){ ?>
                                          <tr>
  											<td><?= $olevel->certname; ?></td>
  											<td><?= $olevel->subname; ?> </td>
                                              <td><?= $olevel->grade; ?> </td>
                                              <td> <?= $olevel->emonth; ?>, <?= $olevel->eyear; ?> </td>
                                              <td><?= $olevel->centerno; ?></td>
                                               <td><?= $olevel->examno; ?></td>

  										</tr>

                                          <?php  } ?>

  									</tbody>
  								</table>


                                                       <?php endif; ?>






                                <hr />
  											 	<h5 class="card-title mb-0"><strong>DECLARATION/ATTESTATION</strong></h5> <hr>
                                                   I, <strong><?= $biodetail->surname; ?> <?= $biodetail->firstname; ?> <?= $biodetail->othernames; ?></strong>  hereby declare that the information given in this form is correct. I understand that i will be held liable for any information therein. I also understand that if any information given is later found to be false, incomplete or misleading, The Oke-Ogun Polytechnic, Saki reserves the right to take appropriate disciplinary measures against me.
  <br />

  <form   name="appfinishs"  action="appfinishs" method="post">
  <div class="mb-3 col-md-12">

  </div>



  </div>

  <?php if ($biodetail->std_custome9 == 1 ) {  ?>

  <div class="alert alert-success alert-dismissible" role="alert">

  											<div class="alert-message">
  												<strong>Congratulation!</strong> Your Application has been Submitted.
  											</div>
  										</div>

  <?php }else { ?>


  <div class="alert alert-danger alert-dismissible" role="alert">

  											<div class="alert-message">
  												<strong>Warning!</strong> Your Application cannot be edited after Submission
  											</div>
  										</div>


  							<button class="btn btn-success"><i class="fas fa-check"></i>  Submit Application</button>
  						<?php } ?>


  						</div>

  							</form>

  								</div>



  							</div>
  						</div>
