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

       <?php if ($stddetails[0]->ndcert != 0 ) { ?>




                                             	<h5 class="card-title mb-0"><strong>INDUSTRIAL TRAINING </strong></h5> <hr>

						<table class="table table-hover my-0" width="100%" style="font-size:12px">
									<thead>
										<tr>
										  <th>Certificate</th>
										  <th>Action</th>
									  </tr>
										<tr>
											<th><img alt="Photo" src="<?= base_url('public/certs/'.$stddetails[0]->ndcert);?>"   width="90" height="100" /></th>


                                             <th>



                                            <a class="btn btn-primary" href="<?php echo base_url('/applicant/rem_ndcert'); ?>">Remove</a>

                                            </th>
										</tr>
									</thead>
									<tbody>







                                    <?php


									  if ($stddetails[0]->biodata == 0 or $stddetails[0]->std_custome6 == 0 or $stddetails[0]->std_custome5)  {

								echo '<script type="text/javascript">
			alert("Kindly add your biodata and Olevel before School Details");
			window.location = "../applicant/my_application";
		</script>';  exit;}else {
									 $go = 1;
									 }
									?>

                                    </tbody>
								</table> <br /> <br /> <?php    echo  $link = '<a href =  "'.base_url().'/applicant/appfinish/5" class="btn btn-info"><i class="fas fa-info"></i> Click here to Save and Continue</a>';
								 ?>

                     <?php }else{ ?>

                               <strong>INDUSTRIAL TRAINING</strong>
                                <hr /> <form   name="addcert"
    action="addcert" method="post" enctype="multipart/form-data">
                                <div class="row">





								<div class="mb-3 col-md-12">
														<label class="form-label" for="inputCity"><strong>Organization</strong></label>
                            <input type="text" class="form-control" name="matno"  value="" autocomplete = "off" required>
</div>

<div class="mb-3 col-md-12">
														<label class="form-label" for="inputCity"><strong>Address</strong></label>
                            <input type="text" class="form-control" name="matno"  value="" autocomplete = "off" required>
</div>
<div class="mb-3 col-md-6">
														<label class="form-label" for="inputCity"><strong>From</strong></label>
														<input type="date" class="form-control" name="matno"  value="" autocomplete = "off" required>
</div>

<div class="mb-3 col-md-6">
														<label class="form-label" for="inputCity"><strong> To</strong></label>
													
														<input type="date" class="form-control" name="matno"  value="" autocomplete = "off" required>
</div>

<button class="btn btn-success"><i class="fas fa-check"></i> Save</button>

												</div>

                               </form>

								</div>

						</div>



									<?php } ?>

								</div>



							</div>
						</div>	</div>
