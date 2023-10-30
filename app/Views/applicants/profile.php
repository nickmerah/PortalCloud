      <!-- Main Content -->
      <div class="main-content">
            <section class="section">

              <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">

                  <h4 class="page-title m-b-0">My Profile</h4>
                </li>
                <li class="breadcrumb-item">
                  <a href="<?= base_url('applicant');?>">
                    <i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ul>

              <div class="row">
                       <div class="col-12 col-md-6 col-lg-12">
                     <div class="card">
                       <div class="card-header">
                         <h4>Biodata</h4>
                       </div>
                       <div class="card-body">
                         <?php if(isset($stddetails)): 
						 
			 
						
						 
						 ?>
                        										 <?= \Config\Services::validation()->listErrors(); ?>
                        											<form  id="update_profile" name="update_profile"
                            action="<?=base_url('applicant/update_profile_add_olevel_test')?>" method="post" enctype="multipart/form-data">
                        											<?= csrf_field()  ?>

                                                                     <?php foreach($stddetails as $biodetail):
   ?>
                                                                       <div class="row">
                                                                       													<div class="mb-3 col-md-6">
                                                                       														<label class="form-label" for="inputFirstName"><strong>Application Number</strong></label>
                                                                       														<input type="text" class="form-control" name="app_no" value="<?= $biodetail->app_no; ?>" readonly>
                                                                       													</div>
                                                                       													<div class="mb-3 col-md-6">
                                                                       														<label class="form-label" for="inputLastName"><strong>Surname</strong></label>
                                                                       														<input type="text" class="form-control" name="surname" value="<?= $biodetail->surname; ?>" readonly>
                                                                       													</div>
                                                                       												</div>
                                                                                              <div class="row">
													<div class="mb-3 col-md-6">
														<label class="form-label" for="inputFirstName"><strong>Firstname</strong></label>
														<input type="text" class="form-control" name="firstname" value="<?= $biodetail->firstname; ?>" readonly>
													</div>
													<div class="mb-3 col-md-6">
														<label class="form-label" for="inputLastName"><strong>Othername</strong></label>
														<input type="text" class="form-control" name="othernames"  value="<?= $biodetail->othernames; ?>" placeholder="Other name" autocomplete = "off">
													</div>
												</div>
                        <div class="row">
													<div class="mb-3 col-md-6">
														<label class="form-label" for="inputFirstName"><strong>Email</strong></label>
														<input type="text" class="form-control" name="student_email" value="<?= $biodetail->student_email; ?>" autocomplete = "off" readonly>
													</div>
													<div class="mb-3 col-md-6">
														<label class="form-label" for="inputLastName"><strong>GSM</strong></label>
														<input type="text" class="form-control" name="student_mobiletel" value="<?= $biodetail->student_mobiletel; ?>" autocomplete = "off" readonly>
													</div>
												</div>
                        <?php /** jamb */  if ($biodetail->stdprogramme_id==1 and $biodetail->std_programmetype==1) {?>
  <div class="row">
  <div class="mb-3 col-md-12">
														<label class="form-label" for="inputCity"><strong> Course of Study</strong></label>
													<select   id="sprog"  class="form-control"  >
                    <option value="<?= $jambdetails[0]->course; ?>"><?= $jambdetails[0]->course; ?></option>

                  </select>
													</div>		</div>
<div class="row">
                          <div class="mb-3 col-md-12">
														<label class="form-label" for="inputCity"><strong> Programme</strong></label>
													<select   name="sprog"  class="form-control"  >
                    <option value="<?= $jambdetails[0]->programme_id; ?>"><?= $jambdetails[0]->programme_name; ?></option>

                  </select>
													</div>
	</div>

  <div class="row">
    <div class="mb-3 col-md-12">
														<label class="form-label" for="inputCity"><strong> Programme Type</strong></label>
													<select  name="sprogtype"  class="form-control"  >
                      <option value="<?= $biodetail->std_programmetype; ?>"><?= $biodetail->programmet_name; ?></option>

                  </select>
                  <!-- <div> <?php echo $pdata->fee_id; ?> kfkfkfkfkfkfkk </div> -->
													</div>
  </div>
  <div class="row">
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputFirstName"><strong>Gender</strong></label>
  														<select name="gender" class="form-control">
                      
       <option value="<?= $jambdetails[0]->gender; ?>"><?= $jambdetails[0]->gender; ?></option>
      

                    </select></div>
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputLastName"><strong>Marital Status</strong></label>
  														<select name="marital_status" class="form-control" required>
                    <option value="<?php echo empty($biodetail->marital_status) ? "" : "$biodetail->marital_status"; ?>"><?php echo empty($biodetail->marital_status) ? "Select Marital Status" : "$biodetail->marital_status"; ?></option>
  <option value="Single">Single</option>
  <option value="Married">Married</option>
  <option value="Divorced">Divorced</option>
  <option value="Widowed">Widowed</option>

                    </select>
  													</div>
  												</div>
                                                <div class="row">
													<div class="mb-3 col-md-6">
														<label class="form-label" for="inputCity"><strong>State</strong></label>
													<select name="cstate"   id="sel_state"  class="form-control" required>
                    
                <option value="<?= $jambdetails[0]->state; ?>"><?= $jambdetails[0]->state; ?></option>
           
                  </select>
													</div>
													<div class="mb-3 col-md-6">
														<label class="form-label" for="inputState"><strong>LGA</strong></label>
														<select name="clga"   id="sel_lga"class="form-control" required>
                  <option value="<?= $jambdetails[0]->lga; ?>"><?= $jambdetails[0]->lga; ?></option>

                  </select>
													</div>

												</div>

                      <?php /**end of jamb */ } else{  
                        //start of others
                        ?>
<div class="row">
                        <div class="mb-3 col-md-12">
														<label class="form-label" for="inputCity"><strong> Course of Studydd</strong></label>
													<select   id="sprog"  class="form-control"  >
                    <option value="<?= $biodetail->stdcourse; ?>"><?= $biodetail->stdcourse; ?></option>

                  </select>
													</div>		</div>
<div class="row">
                          <div class="mb-3 col-md-6">
														<label class="form-label" for="inputCity"><strong> Programme</strong></label>
													<select   id="sprog"  class="form-control"  >
                    <option value="<?= $biodetail->programme_id; ?>"><?= $biodetail->programme_name; ?></option>

                  </select>
													</div>

													<div class="mb-3 col-md-6">
														<label class="form-label" for="inputCity"><strong>LGA</strong></label>
													<select name="clga"   id="sel_lga"  class="form-control" required>
                    
                          <option value="<?php echo empty($biodetail->local_gov) ? "" : "$biodetail->local_gov"; ?>"><?php echo empty($biodetail->local_gov) ? "Select  LGA" : $biodetail->local_gov; ?></option>
                   <?php
           foreach($lgas as $lga){
             echo "<option value='".$lga->lga_name."'>".$lga->lga_name."</option>";
           }
           ?>
           
                  </select>
													</div>
												

												</div>
  <div class="row">
  													<div class="mb-3 col-md-6">
  														<label class="form-label" for="inputFirstName"><strong>Gender</strong></label>
  														<select name="gender" class="form-control" required>
                      
                              <option value="<?php echo empty($biodetail->gender) ? "" : "$biodetail->gender"; ?>"><?php echo empty($biodetail->gender) ? "Select Gender" : "$biodetail->gender"; ?></option>
  <option value="Male">Male</option>
  <option value="Female">Female</option>
      

                    </select></div><div class="mb-3 col-md-6">
  														<label class="form-label" for="inputLastName"><strong>Marital Status</strong></label>
  														<select name="marital_status" class="form-control" required>
                    <option value="<?php echo empty($biodetail->marital_status) ? "" : "$biodetail->marital_status"; ?>"><?php echo empty($biodetail->marital_status) ? "Select Marital Status" : "$biodetail->marital_status"; ?></option>
  <option value="Single">Single</option>
  <option value="Married">Married</option>
  <option value="Divorced">Divorced</option>
  <option value="Widowed">Widowed</option>

                    </select>
  													</div>
  												</div> 
                      <?php /**end of others */ } ?>





                          <div class="row">

                                                 <?php if ($biodetail->birthdate == '0000-00-00') {  ?>






                                                <div class="mb-3 col-md-4">
														<label class="form-label" for="inputZip"><strong>Day of Birth</strong></label>
														<select name="dob" class="form-control" required>
                     <option value="">Select Day</option>
    <?php
for ($mday = 1; $mday<= 31; $mday++) {
?>
      <option value="<?php if (strlen($mday) == 1) {$mday = "0$mday";} echo $mday ?>"><?php echo $mday ?></option>
      <?php
}
?>

                  </select>
													</div>
                                                    <div class="mb-3 col-md-4">
														<label class="form-label" for="inputZip"><strong>Month of Birth</strong></label>
														<select name="mob" class="form-control" required>

                    <option value="">Select Month</option>
    <option value='01'>Jan</option>
  <option value='02'>Feb</option>
  <option value='03'>Mar</option>
  <option value='04'>Apr</option>
  <option value='05'>May</option>
  <option value='06'>Jun</option>
  <option value='07'>Jul</option>
  <option value='08'>Aug</option>
  <option value='09'>Sep</option>
  <option value='10'>Oct</option>
  <option value='11'>Nov</option>
  <option value='12'>Dec</option>

                  </select>
													</div>
                                                    <div class="mb-3 col-md-4">
														<label class="form-label" for="inputZip"><strong>Year of Birth</strong></label>
														<select name="yob" class="form-control" required>
                  <option value="">Select Year</option>   <?php
$tillyear = 1970;
for ($year = date('Y'); $year >= $tillyear; $year--) {
?>
  <option value="<?php echo $year ?>"><?php echo $year ?></option>
  <?php
}
?>
  </select>



                  </select>
													</div>


                                                    <?php }else {  ?>
                                                    
                                                   
                                                
                                                
                                                    
                                                       <div class="mb-3 col-md-4">
														<label class="form-label" for="inputZip"><strong>Day of Birth</strong></label>
														<select name="dob" class="form-control" required>
                     <option value="<?= date('d', strtotime($biodetail->birthdate)); ?>"><?= date('d', strtotime($biodetail->birthdate)); ?></option>
    <?php
for ($mday = 1; $mday<= 31; $mday++) {
?>
      <option value="<?php if (strlen($mday) == 1) {$mday = "0$mday";} echo $mday ?>"><?php echo $mday ?></option>
      <?php
}
?>

                  </select>
													</div>
                                                    <div class="mb-3 col-md-4">
														<label class="form-label" for="inputZip"><strong>Month of Birth</strong></label>
														<select name="mob" class="form-control" required>

                    <option value="<?= date('m', strtotime($biodetail->birthdate)); ?>"><?= date('M', strtotime($biodetail->birthdate)); ?></option>
    <option value='01'>Jan</option>
  <option value='02'>Feb</option>
  <option value='03'>March</option>
  <option value='04'>Apr</option>
  <option value='05'>May</option>
  <option value='06'>Jun</option>
  <option value='07'>Jul</option>
  <option value='08'>Aug</option>
  <option value='09'>Sept</option>
  <option value='10'>Oct</option>
  <option value='11'>Nov</option>
  <option value='12'>Dec</option>

                  </select>
													</div>
                                                    <div class="mb-3 col-md-4">
														<label class="form-label" for="inputZip"><strong>Year of Birth</strong></label>
														<select name="yob" class="form-control" required>
                  <option value="<?= date('Y', strtotime($biodetail->birthdate)); ?>"><?= date('Y', strtotime($biodetail->birthdate)); ?></option>   <?php
$tillyear = 1970;
for ($year = date('Y'); $year >= $tillyear; $year--) {
?>
  <option value="<?php echo $year ?>"><?php echo $year ?></option>
  <?php
}
?>
  </select>



                  </select>
													</div>
                                                    
                                                    
                                             

                                                    <?php } ?>





                                                </div>
  <div class="row">
    <div class="mb-3 col-md-6">
													<label class="form-label" for="inputAddress"><strong>Permanent Home Address</strong></label>
													<input type="text" class="form-control" name="student_homeaddress" placeholder="Permanent Home Address" value="<?= $biodetail->student_homeaddress; ?>" autocomplete = "off" required>
												</div>
											<div class="mb-3 col-md-6">
													<label class="form-label" for="inputAddress2"><strong>Contact Address</strong></label>
													<input type="text" class="form-control" name="contact_address" placeholder="Contact Address" value="<?= $biodetail->contact_address; ?>" autocomplete = "off" required>
												</div>
  </div>
  

                        <div class="row">
													<div class="mb-3 col-md-6">
														<label class="form-label" for="inputFirstName"><strong>Next of Kin Name</strong></label>
														<input type="text" class="form-control" name="nok" placeholder="Next of Kin Name" value="<?= $biodetail->next_of_kin; ?>" autocomplete = "off" required>
													</div>
													<div class="mb-3 col-md-6">
														<label class="form-label" for="inputLastName"><strong>Next of Kin Phone Number</strong></label>
														<input type="text" class="form-control" name="nok_tel" placeholder="Next of Kin GSM" value="<?= $biodetail->nok_tel; ?>" autocomplete = "off" required>
													</div>
												</div>


                        <div class="row">
													<div class="mb-3 col-md-6">
													<label class="form-label" for="inputAddress"><strong>Next of Kin Address</strong></label>
													<input type="text" class="form-control" name="nok_address" placeholder="Next of Kin Address" value="<?= $biodetail->nok_address; ?>" autocomplete = "off" required>
												</div>

												<div class="mb-3 col-md-6">
													<label class="form-label" for="inputAddress"><strong>Next of Kin Email Address</strong></label>
													<input type="email" class="form-control" name="nok_email" placeholder="Next of Kin Email Address" value="<?= $biodetail->nok_email; ?>" autocomplete = "off" required>
												</div>

                        	</div>
  <div class="row">
                          <?php if ($biodetail->std_photo == '') { ?>

                                <input type="hidden" class="form-control" name="stdphoto" value="<?= $biodetail->jambno.".jpg"; ?>">

                      <div class=" mb-3 col-md-12 alert alert-warning alert-dismissible" role="alert">

                     <div class="alert-message">
                       <strong>Warning!</strong> Confirm your profile information before saving
                     </div>
                   </div>
                       

                                    <?php   if ( $pstat  != 1){
                                      echo '<div class="alert alert-danger alert-dismissible" role="alert">

                                      <div class="alert-message">
                                        <strong>APPLICATION FEE PAYMENT</strong> NOT MADE.
                                      </div>
                                    </div>';


                       
                  }else{ echo '<div class="mb-3 col-md-12"><button type="submit" class="btn btn-primary">Update Your Biodata</button> <div>'; } ?>



                       <?php } else {

                         
				   
				      '<div class="mb-12 col-md-12">
            
            <button type="submit" class="btn btn-primary"> Save Your Biodata </button>
            
            <div>';
					 } ?> </div>

                                                                     <?php endforeach; ?>
                                                  <?php endif; ?>
                  
                   <br>
                   <hr>
                   <div class="card-header">
                         <h4>O'LEVEL RESULTS  - You should choose not less than 5 Subjects</h4>
                       </div>
<br>
                  
<?php if (empty($olevels)) { ?>

 
  <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>First Sitting</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" class="table">
                        
                        <tr>
                          <td colspan="3"> 
<label class="form-label" for="inputCity"><strong> Examination Type</strong></label>
<select name="examtype"   id="examtype"  class="form-control" required>
<option value="">Select Exam Type</option>
<?php $etype = array('NECO', 'WAEC/WASCE', 'NABTEB');
foreach($etype as $etypes){
echo "<option>".$etypes."</option>";
}
?>
</select>
</td>
                        </tr>
                        <tr>
                          <td colspan="3">
<label class="form-label" for="inputCity"><strong> Center No</strong></label>
<input name="centerno" type="text" class="form-control" id="centerno"   autocomplete = "off" required>    </td>
                        </tr>
                        <tr>
                          <td colspan="3">&nbsp;
<label class="form-label" for="inputCity"><strong> Examination No</strong></label>
<input name="examno" type="text" class="form-control" id="examno"   autocomplete = "off" required> </td>
                        </tr>
                        <tr>
                          <td colspan="3">
<label class="form-label" for="inputCity"><strong>Month</strong></label>
<select name="frommth"   id="frommth"  class="form-control" required>
<option value="">Select Month</option>
<option value='Jan'>Jan</option>
<option value='Feb'>Feb</option>
<option value='March'>March</option>
<option value='Apr'>Apr</option>
<option value='May'>May</option>
<option value='Jun'>Jun</option>
<option value='Jul'>Jul</option>
<option value='Aug'>Aug</option>
<option value='Sept'>Sept</option>
<option value='Oct'>Oct</option>
<option value='Nov'>Nov</option>
<option value='Dec'>Dec</option>
</select>
</td>
                        </tr>
						  <tr>
                          <td colspan="3">
<label class="form-label" for="inputCity"><strong> Year</strong></label>
<select name="toyear"   id="toyear"  class="form-control" required>
<option value="">Select Year</option>   <?php
$tyear = 1970;
for ($syear = date('Y'); $syear >= $tyear; $syear--) {
?>
<option value="<?php echo $syear ?>"><?php echo $syear ?></option>
<?php
}
?>
</select>
</td>
                        </tr>
						  <tr>
                          <td colspan="3">
                           <br> 
                          
                          
                          <div> <h6> Subject & Grades</strong></h6></div>
<div class="row">
<?php  //add multiple fields

$nos = 8;

for($i = 1; $i <= $nos ; $i++)
{
?>



<div class="mb-1 col-md-8">

<select name="subject[<?=$i ;?>]"   id="subject"  class="form-control">
<option value="">Select Subject</option>
<?php
foreach($subjects as $subject){
echo "<option>".$subject->subjectname."</option>";
}
?>
</select>
</div>


<div class="mb-1 col-md-4">

<select name="grade[<?=$i ;?>]"   id="grade"  class="form-control">
<option value=""> Grade</option>
<?php
foreach($grades as $grade){
echo "<option>".$grade->gradecode."</option>";
}
?>
</select>
</div>

<?php  }  ?>
                    </div>
                          </td></tr></table>
                  </div>
                 
                </div>
              </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Second Sitting</h4>
                  </div>
                  <div class="card-body">
                  <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" class="table">
                        
                        <tr>
                          <td colspan="3"> 
<label class="form-label" for="inputCity"><strong> Examination Type</strong></label>
<select name="examtypes"   id="examtypes"  class="form-control">
<option value="">Select Exam Type</option>
<?php $etype = array('NECO', 'WAEC/WASCE', 'NABTEB');
foreach($etype as $etypes){
echo "<option>".$etypes."</option>";
}
?>
</select>
</td>
                        </tr>
                        <tr>
                          <td colspan="3">
<label class="form-label" for="inputCity"><strong> Center No</strong></label>
<input name="centernos" type="text" class="form-control" id="centernos"   autocomplete = "off">    </td>
                        </tr>
                        <tr>
                          <td colspan="3">&nbsp;
<label class="form-label" for="inputCity"><strong> Examination No</strong></label>
<input name="examnos" type="text" class="form-control" id="examnos"   autocomplete = "off"> </td>
                        </tr>
                        <tr>
                          <td colspan="3">
<label class="form-label" for="inputCity"><strong>Month</strong></label>
<select name="frommths"   id="frommths"  class="form-control">
<option value="">Select Month</option>
<option value='Jan'>Jan</option>
<option value='Feb'>Feb</option>
<option value='March'>March</option>
<option value='Apr'>Apr</option>
<option value='May'>May</option>
<option value='Jun'>Jun</option>
<option value='Jul'>Jul</option>
<option value='Aug'>Aug</option>
<option value='Sept'>Sept</option>
<option value='Oct'>Oct</option>
<option value='Nov'>Nov</option>
<option value='Dec'>Dec</option>
</select>
</td>
                        </tr>
						  <tr>
                          <td colspan="3">
<label class="form-label" for="inputCity"><strong> Year</strong></label>
<select name="toyears"   id="toyears"  class="form-control">
<option value="">Select Year</option>   <?php
$tyear = 1970;
for ($syear = date('Y'); $syear >= $tyear; $syear--) {
?>
<option value="<?php echo $syear ?>"><?php echo $syear ?></option>
<?php
}
?>
</select>
</td>
                        </tr>
						  <tr>
                          <td colspan="3">
                           <br> 
                          
                          
                          <div> <h6> Subject & Grades</strong></h6></div>
<div class="row">
<?php  //add multiple fields

$nos = 8;

for($i = 1; $i <= $nos ; $i++)
{
?>



<div class="mb-1 col-md-8">

<select name="subjects[<?=$i ;?>]"   id="subjects"  class="form-control">
<option value="">Select Subject</option>
<?php
foreach($subjects as $subject){
echo "<option>".$subject->subjectname."</option>";
}
?>
</select>
</div>


<div class="mb-1 col-md-4">

<select name="grades[<?=$i ;?>]"   id="grades"  class="form-control">
<option value=""> Grade</option>
<?php
foreach($grades as $grade){
echo "<option>".$grade->gradecode."</option>";
}
?>
</select>
</div>

<?php  }  ?>
                    </div>
                          </td></tr></table>
                  </div>
                  </div>
                 
                </div>
              </div>


                   
 


                       <button class="btn btn-success"><i class="fas fa-check"></i> Save Biodata & O'Level Results</button>
<input name="noos" type="hidden" value="1" />
</div>


<?php  }else{ ?>

  <table class="table table-hover my-0" width="100%" style="font-size:12px">
  									<thead>
  										<tr>
  											<th>Exam Type</th>
                                            <th>Subject Name</th>
  											<th>Grade</th>
                                              <th>Date Obtained</th>
                                              <th>CenterNo</th>
                                              <th>ExamNo</th>
                                              <th>Sitting</th>
                                              
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
                                               <td><?= $olevel->sitting; ?></td>
                                              
  										</tr>

                                          <?php  } ?>

  									</tbody>
  								</table>     <br /> <br />


                  <?=	 '<a href =  "'.base_url().'/applicant/rem_allolevel" class="btn btn-danger"><i class="fas fa-check"></i> ReUpload OLevel Results </a>';?> |    <?=	 '<a href =  "'.base_url().'/applicant/appfinish/6" class="btn btn-info"><i class="fas fa-info"></i> Click here to Save and Continue </a>';?>
<?php } ?>
</form> 

                       </div>





                     </div>
                         </div>
                       </div>
                       
