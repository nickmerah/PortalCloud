      <!-- Main Content -->
      <div class="main-content">
            <section class="section">

              <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">

                  <h4 class="page-title m-b-0">Document Upload</h4>
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

      

<?php 
 $showITform = false;
$resultname = "Jamb";
 if ($stddetails[0]->stdprogramme_id == 2 )  {
    $resultname = "ND";
    $showITform = true;
}



if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

<?php if ($getdocs) { ?>
                                             	<h5 class="card-title mb-0"><strong> DOCUMENT UPLOAD</strong></h5> <hr>

					<table border="1" cellpadding="10" cellspacing="0" width="100%" style="  border-collapse: collapse;">
									<thead>
										<tr>
										  <th>DOCUMENT NAME</th>
										  
										  <th>ACTION</th>
										 
									  </tr>
									  <?php foreach($getdocs as $docs) { ?>
										<tr>
											<th> <?= $docs->docname;?></th>

	<th> <a href="<?= base_url('writable/uploads/' . $docs->uploadname); ?>" target="_blank">
    View Document
</a></th>
                                            
										</tr>
										<?php } ?>
									</thead>
									<tbody>

 
                                    </tbody>
								</table>
								<br>
 <a class="btn btn-danger" 
   href="<?php echo base_url('/applicant/rem_doc/' . $docs->stdid); ?>" 
   onclick="return confirm('Are you sure you want to re-upload the documents? This will remove any existing uploaded documents.');">
    ReUpload Documents
</a>
  <?php }else{ ?>
  
  <hr />
                               <strong>UPLOAD DOCUMENT</strong>
                               <div class="alert alert-warning">
    <strong>File Upload Guidelines:</strong>
    <ul>
        <li>Only PDF files are allowed.</li>
        <li>Minimum file size: 100KB.</li>
    </ul>
</div>
<hr />

<form name="addcert" action="addcert" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="mb-3 col-md-12">
            <label class="form-label" for="file"><strong> <?= $resultname;?> Result</strong></label>
            <input name="jamb_nd_result" type="file" class="form-control" required id="jamb_nd_result" accept=".pdf" />
        </div>
        
        <div class="mb-3 col-md-12">
            <label class="form-label" for="o_level"><strong> O’ Level Result (If you have 2 results, combine in one(1) file)</strong></label>
            <input name="o_level_result" type="file" class="form-control" required id="o_level" accept=".pdf" />
        </div>

        <div class="mb-3 col-md-12">
            <label class="form-label" for="birth_certificate"><strong> Birth Certificate</strong></label>
            <input name="birth_certificate" type="file" class="form-control" required id="birth_certificate" accept=".pdf" />
        </div>

        <div class="mb-3 col-md-12">
            <label class="form-label" for="lga_proof"><strong> Proof of LGA</strong></label>
            <input name="lga_proof" type="file" class="form-control" required id="lga_proof" accept=".pdf" />
        </div>

        <div class="mb-3 col-md-12">
            <label class="form-label" for="attestation_letter"><strong> Attestation Letter</strong></label>
            <input name="attestation_letter" type="file" class="form-control" required id="attestation_letter" accept=".pdf" />
        </div>
        <?php if ($showITform) { ?>
        <div class="mb-3 col-md-12">
            <label class="form-label" for="nd_admission_letter_jamb_result"><strong> ND Admission Letter / Jamb Result </strong></label>
            <input name="nd_admission_letter_jamb_result" type="file" class="form-control" required id="nd_admission_letter_jamb_result" accept=".pdf" />
        </div>
        
         <div class="mb-3 col-md-12">
            <label class="form-label" for="it_letter"><strong> IT Letter</strong></label>
            <input name="it_letter" type="file" class="form-control" required id="it_letter" accept=".pdf" />
        </div>
         <?php } ?>
    </div>
    
    <button type="submit" class="btn btn-primary">Upload Documents</button>
</form> <?php } ?>

								</div>

						</div>



								 

								</div>



							</div>
						</div>	</div>
