<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>TOPS .:: Home | Application Portal</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="THE OKE-OGUN POLYTECHNIC SAKI">
         
    
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
 <script>

function printWindow(){

   bV = parseInt(navigator.appVersion)

   if (bV >= 4) window.print()

}

</script>

<script type="text/javascript">
 

 
 
 document.addEventListener("contextmenu", function(e){
    e.preventDefault();
}, false);


window.onbeforeunload = function (e) {
    // Cancel the event
    e.preventDefault();

    // Chrome requires returnValue to be set
    e.returnValue = 'Really want to quit the game?';
};

 
document.onkeydown = function (e) {
    e = e || window.event;//Get event

    if (!e.ctrlKey) return;

    var code = e.which || e.keyCode;//Get key code

    switch (code) {
        case 83://Block Ctrl+S
        case 87://Block Ctrl+W -- Not work in Chrome and new Firefox
            e.preventDefault();
            e.stopPropagation();
            break;
    }
};
</script>
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
</head>  
	    
	   
	 				   
				<body bgcolor="#FFFFFF">
                
                <?php 
			
			 
			
			if($paydetails){  ?>
            
            <?php foreach($paydetails as $paydetail): ?>
            
                <div class="col-md-9 col-xl-12">
							
                            <div class="tab-content">
								<div class="tab-pane fade show active" id="payslip" role="tabpanel">

									 <br />			    
                              
<div align="center" style="background-color:#FFF">
            <img src="<?= base_url('assets/img/logo.jpg');?>" alt="TOPS" width="102" height="103"> 
             <br> 
             <strong style="font-size:20px">    THE OKE-OGUN POLYTECHNIC, SAKI</strong> <br> 
  </h3>
        <br>    
            
        <strong style="font-size:18px"> <u><?= strtoupper($paydetail->fee_name); ?> - PAYMENT RECEIPT</u>  </strong> 
</div>  <br>  
         
							  
							        <table cellpadding="0" cellspacing="0" class="table table-bordered" style="font-size:15px">
										<thead>
											<tr>
												<th colspan="4" class="cell">Payment Details</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td width="105" class="cell"><strong>UTME No:</strong> </td>
												<td width="220" class="cell"><?=   $jambno; ?></td>
												<td colspan="2" rowspan="4" class="cell"><?php 

                                               
$picurl = "http://student.tops.edu.ng:82/portal/supportadmin/jambphoto/"; 
  $filename =   $picurl.$stdphoto; 
$chkimg = 	\App\Controllers\Applicant::getValidUrl($filename); 
                     
                            
                            
                            if ($chkimg != 0) { ?>
<img alt="Photo" src="<?=  $filename;?>"  width="135" height="131" />
<?php }else { ?>
<img alt="Photo" src="<?= base_url('public/uploads/avatar.jpg');?>" width="120" height="118" />

<?php } ?> </td>
											</tr>
											<tr>
											  <td class="cell"><strong>Application No:</strong></td>
											  <td class="cell"> <?= $paydetail->appno; ?></td>
									      </tr>
											<tr>
												<td class="cell"><strong>Fullnames:</strong></td>
												<td class="cell"> <?= $paydetail->fullnames; ?> </td>
										    </tr>
											<tr>
												<td class="cell"><strong>Programme:</strong></td>
												<td class="cell"> <?= $programmet_name; ?> <?= $programme_name; ?></td>
										    </tr>
											
											 
											<tr>
												<td class="cell"><strong>Course:</strong></td>
												<td class="cell"><?= $stdcourse; ?></td>
												<td width="62" class="cell"><strong>Session:</strong></td>
												<td width="94" class="cell"><?= $paydetail->trans_year; ?>/<?= $paydetail->trans_year+1; ?>  </td>
											</tr>
											
											
											<tr>
											  <td class="cell"><strong>RRR:</strong></td>
											  <td class="cell"> <?= $paydetail->rrr; ?></td>
											  <td class="cell"><strong>TransID:</strong></td>
											  <td class="cell"><?= $paydetail->trans_no; ?></td>
										  </tr>
										  <tr>
											  <td class="cell"><strong>Date:</strong></td>
											  <td class="cell">  <?= $pt_date  = date("d-M-Y", strtotime($paydetail->t_date)); ?></td>
										      <td class="cell"><strong>Status:</strong></td>
										      <td class="cell"><span class="bg-success badge"><strong>
										        <?= strtoupper($paydetail->trans_custom1); ?>
										      </strong></span></td>
										  </tr>
											<tr>
											  <td colspan="4" class="cell"><strong>Transaction Details</strong></td>
										  </tr>
										 
											<tr>
											  <td class="cell"><strong>S/N</strong></td>
											  <td class="cell"><strong>Feename</strong></td>
											  <td colspan="2" class="cell"><strong>Fee Amount</strong></td>
										  </tr>
								 	<tr>
									  <td class="cell">1.</td>
									  <td class="cell"><?= $paydetail->fee_name; ?> </td>
									  <td colspan="2" class="cell">&#8358; <?= number_format($paydetail->fee_amount); ?></td>
									  </tr> 	
										</tbody>
									</table>
						        
                                    <p> &nbsp;&nbsp; You can confirm this receipt by scanning this QR Code:</p>
									<div id="qrcode" class="qrcode" align = "center"></div>
                               <?php $transno =  $paydetail->trans_no; endforeach; ?>
				  <?php } ?>		   
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
				</div></div></div>	 
	           
	 	</body>	               
	             
          </html>       
    <script>

printWindow();

</script>            
			    
		   