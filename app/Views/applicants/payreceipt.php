      <!-- Main Content -->
	  <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
	  <style>
 

.qrcode{
  padding: 16px;
  margin-bottom: 30px;
  width: 80px;
}
.qrcode img{
  margin: 0 auto;
  box-shadow: 0 0 10px rgba(67, 67, 68, 0.25);
  padding: 4px;
  width: 80px;
}
#qrcode-container{
    display:none;
	width: 2px;
}


    </style>
      <div class="main-content">
            <section class="section" >

              <ul class="breadcrumb breadcrumb-style">
                <li class="breadcrumb-item">

                  <h4 class="page-title m-b-0">Payment Receipt</h4>
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
								    
								    <?php if(isset($paydetails)): ?>
                                                <?php foreach($paydetails as $paydetail): ?>

									<div class="card"><br />

                    <div align="center">
            <img src="<?= base_url('assets/img/logo.jpg');?>" alt="tops" width="102" height="103">
             <br> <strong style="font-size:20px"> The Oke-Ogun Polytechnic, Saki</strong> <br>
  </h3>
        <br>

        <strong style="font-size:18px"> <u><?= $paydetail->fee_name; ?> - Payment Receipt</u>  </strong>
</div>

									  <div class="card-body">
											 	<h5 class="card-title mb-0"><strong>APPLICANT'S PAYMENT  INFORMATION</strong></h5> <hr>
											 
                                              <table class="table table-bordered">

									<tbody>
									    <tr>
										      <td><strong>UTME No:</strong></td>
										      <td><span class="mb-3">
										        <?= $jambno; ?>
										      </span></td>
									        <td rowspan="4">
										        
										        
										        <?php 

                                               
												$picurl = "http://student.tops.edu.ng:82/portal/supportadmin/jambphoto/"; 
											 	 $filename =   $picurl.$stdphoto; 
											  $chkimg = 	\App\Controllers\Applicant::getValidUrl($filename); 
												                     
                                                                            
                                                                            
                                                                            if ($chkimg != 0) { ?>
										        <img alt="Photo" src="<?=  $filename;?>"  width="135" height="131" />
										        <?php }else { ?>
										        <img alt="Photo" src="<?= base_url('public/uploads/avatar.jpg');?>" width="120" height="118" />
										        
										        <?php } ?>
										        
										        
										        
										        
								            </td>
								      </tr>
									    <tr>
											<td><strong>Application No:</strong></td>
											<td><span class="mb-3">
											  <?= $paydetail->appno; ?>
											</span></td>
										</tr>
										<tr>
											<td><strong>Fullnames:</strong></td>
											<td><strong>
											  <?= $paydetail->fullnames; ?>
											</strong></td>
										</tr>
										<tr>
											<td><strong>Fee Name:</strong></td>
											<td><span class="mb-3">
											  <?= $paydetail->fee_name; ?>
											</span></td>
										</tr>
										<tr>
										  <td><span class="mb-3">
										    <label class="form-label" for="inputUsername7"><strong>RRR:</strong></label>
										  </span></td>
										  <td colspan="2"><span class="mb-3">
										    <?= $paydetail->rrr; ?>
										  </span></td>
									  </tr>
										<tr>
											<td><span class="mb-3">
											  <label class="form-label" for="inputUsername2"><strong>Session:</strong></label>
											</span></td>
											<td colspan="2"><span class="mb-3">
											  <label class="form-label" for="inputUsername9"><strong></strong></label>
                                              <?= $paydetail->trans_year; ?>
/
<?= $paydetail->trans_year+1; ?>
                                            </span></td>
										</tr>
										<tr>
										  <td><span class="mb-3">
										    <label class="form-label" for="inputUsername3"><strong>Amount:</strong></label>
										  </span></td>
										  <td colspan="2"><span class="mb-3">&#8358;
                                              <?= number_format($paydetail->fee_amount); ?>
                                          </span></td>
									  </tr>
										 
										 
										<tr>
										  <td><span class="mb-3">
										    <label class="form-label" for="inputUsername6"><strong>Date:</strong></label>
										  </span></td>
										  <td colspan="2"><span class="mb-3">
										    <?= $pt_date  = date("d-M-Y", strtotime($paydetail->t_date)); ?>
										  </span></td>
									  </tr>
										<tr>
										  <td><span class="mb-3">
										    <label class="form-label" for="inputUsername8"><strong>STATUS:</strong></label>
										  </span></td>
										  <td colspan="2"><span class="mb-3">
										    <strong>
										    <?= strtoupper($paydetail->trans_custom1); ?>
									      </strong>										  </span></td>
									  </tr>
										</tbody>
								</table>


                                          








									  </div>
									</div>
									<p><strong>You can confirm this receipt by scanning this QR Code:</strong></p>
									<div id="qrcode" class="qrcode" align = "center"></div>

									 
                                    <?php $transno =  $paydetail->trans_no; endforeach; ?>
									<script type="text/javascript">
    
      let website = "http://application.tops.edu.ng:82/apply/home/confirmapplyreceipt/<?=$transno;?>";
      if (website) {
        let qrcodeContainer = document.getElementById("qrcode");
        new QRCode(qrcodeContainer, website);
 
       // document.getElementById("qrcode-container").style.display = "block";
      } else {
        alert("Error generating code");
      }
    
  </script>
                                                     <?php endif; ?>   </div>
		  <input type= "button" onClick="printDiv('printableArea')"  value = "Print Payment Receipt"  class='btn btn-primary'>


								</div>



							</div>
</div>



<script type="application/javascript">
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

