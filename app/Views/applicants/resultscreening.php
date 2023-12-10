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
<?php /*
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
</script>*/?>
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
			
			 
			
			if($screeningdata){  ?>
            
            <?php foreach($jambdetails as $paydetail):
				//print_r($screeningdata);
				//print_r($jambdetails);
				?>
            
                <div class="col-md-9 col-xl-12">
							
                            <div class="tab-content">
								<div class="tab-pane fade show active" id="payslip" role="tabpanel">

									 		    
                              
<div align="center" style="background-color:#FFF">
            <img src="<?= base_url('assets/img/logo.jpg');?>" alt="TOPS" width="51" height="52"> 
             <br> 
             <strong style="font-size:20px">    THE OKE-OGUN POLYTECHNIC, SAKI</strong>  
  </h3>
        <br>    
            
        <strong style="font-size:16px"> <u>ONLINE SCREENING RESULT SHEET</u>  </strong> 
</div>   
         
							  
							        <table cellpadding="0" cellspacing="0" class="table table-bordered table-sm" style="font-size:14px">
										<thead>
											<tr>
												<th colspan="4" class="cell">APPLICANT DETAILS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td width="105" class="cell"><strong>UTME No:</strong> </td>
												<td width="220" class="cell"><?=   $paydetail->jambno; ?></td>
												<td colspan="2" rowspan="4" class="cell"><?php 

                                               
$picurl = "http://student.tops.edu.ng:82/portal/supportadmin/jambphoto/"; 
   $filename =   $picurl.$paydetail->jambno.'.JPG'; 
$chkimg = 	\App\Controllers\Applicant::getValidUrl($filename); 
                     
                            
                            
                            if ($chkimg != 0) { ?>
<img alt="Photo" src="<?=  $filename;?>"  width="135" height="131" />
<?php }else { ?>
<img alt="Photo" src="<?= base_url('public/uploads/avatar.jpg');?>" width="120" height="118" />

<?php } ?> </td>
											</tr>
											<tr>
											  
									      </tr>
											 
											<tr>
												<td class="cell"><strong>Fullnames:</strong></td>
												<td class="cell"> <?= $paydetail->fullname; ?> </td>
										    </tr>
											<tr>
												<td class="cell"><strong>Programme:</strong></td>
												<td class="cell"> <?= $paydetail->programmet_name; ?> <?= $paydetail->programme_name; ?></td>
										    </tr>
											
											 
											<tr>
												<td class="cell"><strong>Course:</strong></td>
												<td class="cell"><?= $paydetail->course; ?></td>
												<td width="62" class="cell"><strong>Session:</strong></td>
												<td width="94" class="cell"><?= $sess; ?>/<?= $sess+1; ?>  </td>
											</tr>
											
											
											<tr>
											  <td class="cell"><strong>State:</strong></td>
											  <td class="cell"> <?= $paydetail->state; ?></td>
											  <td class="cell"><strong>Gender:</strong></td>
											  <td class="cell"><?= $paydetail->gender; ?></td>
										  </tr>
										   
											<tr>
											  <td colspan="4" class="cell"><strong>O'LEVEL DETAILS</strong></td>
										  </tr>
										  <tr>
												<td class="cell"><strong>S/N</strong></td>
												<td class="cell"><strong>SUBJECT</strong></td>
												<td width="62" class="cell"><strong>GRADE</strong></td>
												<td width="94" class="cell"><strong>SCORE</strong> </td>
											</tr>
											
											 <?php    
											$mysubjects = $screeningdata[0]->subject_grades;
											$mysubject = explode(',', $mysubjects);
											
											foreach ($mysubject as $value) {
												if (strpos($value, 'Sitting') === false && strpos($value, 'UTME Score') === false) {
													$valueArray = preg_split("/\s-\s|\s\(|\)/", $value, -1, PREG_SPLIT_NO_EMPTY);
											?>
											<tr>
											  <td class="cell"><?= $i = $i+1;?></td>
											  <td class="cell"> <?= $valueArray[0] ; $tot += $valueArray[2]; ?></td>
											  <td class="cell"><?= $valueArray[1] ; ?></td>
											  <td class="cell"><?= $valueArray[2] ; ?></td>
										  </tr>
											 
										   <?php } } ?>

										   <tr>
											  <td colspan="4" class="cell">&nbsp;</td>
										  </tr>
										  <tr>
											  <td colspan="1" class="cell"><strong>O'level Score</strong></td>
											  <td colspan="3" class="cell"><?= $tot;?></td>
											  
										  </tr>
										  <tr>
											  <td colspan="1" class="cell"><strong>UTME Score</strong></td>
											  <td colspan="3" class="cell"><?php
											   $utmescore = $jambdetails[0]->score;
											  $jambcutoff = 120;
											  echo  $utmescore .' / 400 * 60 =  ';
											 echo $jambscore = ($utmescore > $jambcutoff) ? ($utmescore/400*60) : 0;
											  $sitting = ($screeningdata[0]->havesecondsitting == 1) ? 5 : 10;
											 ?> </td>
											  
										  </tr>
								 	  	
										</tbody>
									</table>
									<p align="center"> <strong>Aggregate Score : <?= $tot;?> + <?= $jambscore ;?> + Sitting (<?=  $sitting; ?>) = <?= $screeningdata[0]->score;?></strong>
								<br><b style="font-size:30px;"><?= $screeningdata[0]->score;?></b>
								
								</p>
                                    <p> &nbsp;&nbsp; You can confirm this result by scanning this QR Code:</p>
									<div id="qrcode" class="qrcode" align = "center"></div>
                               <?php $transno =  $paydetail->trans_no; endforeach; ?>
							   <p> &nbsp;&nbsp; Please, note that this result does not guarantee admission to this Institution.</p>
				  <?php } ?>		   
                  <script type="text/javascript">
    
    let website = "<?=$mysubjects;?>";
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
  <?php /*  <script>

printWindow();

</script>       */?>     
			    
		   