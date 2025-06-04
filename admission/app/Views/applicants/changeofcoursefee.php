      <!-- Main Content -->
      <div class="main-content">
            <section class="section">

              <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">

                  <h4 class="page-title m-b-0">Change of Course Fee</h4>
                </li>
                <li class="breadcrumb-item">
                  <a href="<?= base_url('applicant');?>">
                    <i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ul>

              <div class="col-md-9 col-xl-12">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="payslip" role="tabpanel">
<div id="printableArea">
									<div class="card"><br /><div class="col-md-9 col-xl-12">

                    <div class="row">



                    													<div class="col-md-8">
                                                                      <?php foreach($stddetails as $stddetail): ?>
                    														<div class="mb-3">
                    															<label class="form-label" for="inputUsername"><strong>Application No:</strong> </label>
                    															 <?= $stddetail->app_no; ?>
                    														</div>
                    														<div class="mb-3">
                    															<label class="form-label" for="inputUsername"><strong>Fullnames:</strong> </label>
                    															<strong>  <?= $stddetail->surname; ?></strong>, <?= $stddetail->firstname; ?> <?= $stddetail->othernames; ?>
                    														</div>
                                                                            <div class="mb-3">
                    															<label class="form-label" for="inputUsername"><strong>Email:</strong> </label>
                    															 <?= $stddetail->student_email; ?>
                    														</div>

                                                                            <div class="mb-3">
                    															<label class="form-label" for="inputUsername"><strong>Session:</strong> </label>
                    															 <?= $cs_session; ?> / <?= $cs_session+1; ?>
                    														</div>

                                                                             <div class="mb-3">
                    															<label class="form-label" for="inputUsername"><strong>Fee Amount:</strong> </label>
                    															 &#8358;<?= number_format($cfees); ?>
                    														</div>
                                                                             <div class="mb-3">
                    															<label class="form-label" for="inputUsername"><strong>Fee Status:</strong> </label>
                    															 <?php
$uploadbutton = false;
                    															 if ($paystatus && $paystatus[0]->trans_custom1  == 'Paid'){
                    															$gstat = "<b style='color:green'>PAID</b> 
    <form action=\"" . base_url() . "applicant/payresultverify\" method='post'>
        <button type=\"submit\" class=\"btn btn-primary\">
            <i class=\"fas fa-dollar-sign\"></i> Pay again for Result Verification
        </button>
    </form>  ";
                    															
                    															$paybutton = "<button type='button' class='btn btn-primary'>PAYMENT ALREADY MADE</button>";
                    															$printbutton = '<a href =  "'.base_url().'applicant/printreceipt" class="btn btn-success"><i class="fas fa-print"></i> Print Payment Receipt</a>';
                    															$uploadbutton = '<a href =  "'.base_url().'applicant/resultupload" class="btn btn-success"><i class="fas fa-file-upload"></i> Upload Results</a>';

                    														}else{
                    															$gstat = "<b style='color:red'>NOT PAID</b>";
                    															$printbutton = '<button type="submit" class="btn btn-success">
        <i class="fas fa-dollar-sign"></i> Pay Change of Course Fee
    </button>
                    															
                    														 ';
                    														}


                    														echo $gstat;?>  <?php endforeach; ?>
                    														</div>
                    													</div>


                    													<div class="col-md-4">
                    														<div class="text-center">
                                                                           	<img alt="Photo" src="<?= $path; ?>" class="rounded-circle img-responsive mt-3" width="135" height="131" />
                    														</div>
                    													</div>
                                                                         <?php  if(isset($stddetails)){  }else { echo '<div class="alert alert-danger alert-dismissible" role="alert">


                    											<div class="alert-message">
                    												<h4 class="alert-heading">Payment Record(s) Not Found</h4>
                    												<p>You have not generated any transaction.<br> </p>
                    												<hr>
                    												<p class="mb-0">Click on the  "Pay Result Verification" link to generate a transaction.</p>
                    											</div>
                    										</div>';} ?>
                    												</div>

                    </div>
									</div> </div>




								</div>
<form action="<?php echo base_url('applicant/paychangeofcourse'); ?>" method="POST">
                                 <?= $printbutton; ?> 
                                 </form>
                                 <br>
                                 
                                 <?php if ($uploadbutton) {  echo $uploadbutton; } ?>
 

						</div>
					</div>
