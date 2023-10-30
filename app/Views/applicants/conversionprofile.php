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
                            action="<?=base_url('applicant/update_profile_to_conversion')?>" method="post" enctype="multipart/form-data">
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
                      <option value="2">PART TIME</option>

                  </select>
                 
													</div>
  </div>
   
                                               
                                                
                      <?php /**end of others */ } ?>





                      
  <div class="row">
                          <?php if ($biodetail->is_converted == 0) { ?>

                                <input type="hidden" class="form-control" name="stdphoto" value="<?= $biodetail->jambno.".jpg"; ?>">

                      <div class=" mb-3 col-md-12 alert alert-danger alert-dismissible" role="alert">

                     <div class="alert-message">
                       <strong>Warning!</strong>  I hereby confirm that all the information supplied are true and my application should be converted to Part time.
                     </div>
                   </div>
                       

                                    <?php   if ( $pstat  == 1 and $coversionfeestatus == "Paid" && $biodetail->is_converted == 0){


                       echo '<div class="mb-3 col-md-12"><button type="submit" class="btn btn-primary"> Confirm and Save</button> <div>';
                  }else{ echo '<div class="alert alert-danger alert-dismissible" role="alert">

                     <div class="alert-message">
                       <strong>APPLICATION FEE PAYMENT</strong> NOT MADE.
                     </div>
                   </div>'; } ?>



                       <?php } else {

                         echo '<div class="alert alert-success alert-dismissible" role="alert">

                     <div class="alert-message">
                       <strong>Success!</strong> Conversion already Saved.
                     </div>
                   </div>'; 
				   
				   
					 } ?> </div>

                                                                     <?php endforeach; ?>
                                                  <?php endif; ?>
                   </form>




                       </div>





                     </div>
                         </div>
                       </div>
                       
