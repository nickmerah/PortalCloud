      <!-- Main Content -->
      <?php foreach($stddetails as $stddetail): ?> 
      <div class="main-content">
            <section class="section" >

              <ul class="breadcrumb breadcrumb-style">
                <li class="breadcrumb-item">

                <h4 class="page-title m-b-0">Admission Letter</h4>
                </li>
                <li class="breadcrumb-item">
                  <a href="<?= base_url('applicant');?>">
                    <i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item">Admission Letter</li>
              </ul>

              <div class="col-md-9 col-xl-12">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="payslip" role="tabpanel">
								    
		<div id="printableArea">						    
								    
								   

									<div class="card"><br />

                    <div align="center">
            <img src="<?= base_url('assets/img/logo.jpg');?>" alt="tops" width="102" height="103">
             <br><br> <strong style="font-size:25px"> THE OKE-OGUN POLYTECHNIC, SAKI</strong> <br>
  </h3>
        
</div>

									  <div class="card-body">
											  
											 
                    <div class="col-lg-12" >
            
             
                    <table width="100%" border="0">
  <tr>
    <td width="25%" align="left">   
         <p style="font-size:16px">   <strong>  Office of the Registrar,<br>The Oke-Ogun Polytechnic,<br>
        Saki,<br>Oyo State.<br>P.M.B 021
      <br><i>registrar@tops.edu.ng, admissions@tops.edu.ng</i> </strong>    </p>
</td>
    <td width="25%" align="right" valign="top"><?php 
                                                //$filename =  base_url('public/uploads/'.$stdphoto); 
												$picurl = "http://student.tops.edu.ng:82/portal/supportadmin/jambphoto/"; 
                                               
                                                                            
                                                                            
                                                                            if (@getimagesize($picurl.strtoupper($stddetail->jambno.".jpg"))) { ?>
										        <img alt="Photo" src="<?=  $picurl.strtoupper($stddetail->jambno.".jpg");?>"  width="135" height="131" />
										        <?php }else { ?>
										        <img alt="Photo" src="<?= base_url('public/uploads/avatar.jpg');?>" width="120" height="118" />
										        
										        <?php } ?></td>
    
  </tr>
  </table>
       
        
        
          
          
          <p>  <strong style="font-size:16px"> Dear  <?= strtoupper($stddetail->surname); ?> 
          <?= $stddetail->firstname; ?>  <?= $stddetail->othernames; ?> 
          <br><?= strtoupper($stddetail->app_no); ?> </strong>  </p>
         
        
         <div align="center"><u><strong style="font-size:19px; color:#093">PROVISIONAL OFFER OF ADMISSION INTO    <?= $stddetail->programme_name; ?>   </strong>  </u> </div></p>
        </div>
        
        <div align="justify" style="font-size:16px; line-height:2">
       
<p> I am pleased to inform you that you have been offered a provisional admission into <?= ucwords(strtolower($stddetail->programme_name)); ?>
 <b><?= ucwords(strtolower($stddetail->stdcourse)); ?></b> in the Department of <b><?= ucwords(strtolower($deptname));?></b> for the <b><?= $cs_session; ?>/<?= $cs_session+1; ?></b>   academic 
session.</p>



          <p>If this offer is acceptable to you, please login to your application portal for the payment of 
acceptance fee within two weeks of this offer.</p>

<p>On resumption, you will be required to undergo clearance at the Directorate of Academic 
Affairs, presenting the following documents before being enabled for payments of approved fees 
and charges online, and thereafter, proceed to Biometric capture and course registration.</p>
    
             
          
          
  
          <ol type="1">
          <li>This Admisson Letter </li>
          <li>Acceptance Receipt </li>
          
            <?php if ($stddetail->programme_id == "1") { ?>



            <li>Original Jamb result </li>
            <li>Jamb Admission Letter (Institution's Copy)</li>
            
            <?php  }else { ?>
            
            <li>National Diploma Certificate. </li>
            <li>Letter of Completion of Industrial Training.</li>
            
            <?php } ?>
            <li> Ordinary and Photocopy of O'level result </li>
            <li>Local Government Certificate and </li>
            <li>Attestation / Recommendation Letter to be signed by a least a level 12 Civil 
Servant Officer/Local Government Chairman/Royal Father or Religion Leader 
attaching a photocopy of Identity Card and a Passport Photograph of the officer.</li>
            
            
          </ol></p>
          <p>       Note that if you are unable to present O’level and other relevant requirements for the course 
you are being offered admission during the clearance at the Directorate of Academic Affairs 
(Admissions), your admission offer shall stand invalidated.<br>In addition, you are also mandated to: </p>
         <ul >
            <li>Undergo a medical Examination at the Polytechnic Health Service Centre </li>
            <li>Register with the Polytechnic Library, and</li>
            <li>Complete necessary documentations in all designated offices</li>

          </ul> 
          <p> Failure to make payments and complete registration within regulation time shall invalidate this 
offer.      </p>
           <p>Please note that this offer cannot be deferred.       </p>
             
            
<p>Congratulations    </p>
 
        </div>


                                          
        <div align="left"> 
   
   <table width="100%" border="0">
  <tr>
    <td width="50%" align="left"><img src="<?= base_url('assets/img/registrar_signature.png')?>" width="118" height="40" /></td>
    
  </tr>
  <tr>
    <td align="left"><strong>OJO ADEOLU AYANGBEMIGA (MR.)<br>Registrar</strong></td>
    
  </tr>
</table>
 
    
  
   </div>







									  </div>
									</div><p style="page-break-after: always;">&nbsp;</p>
    </div>
		  <input type= "button" onClick="printDiv('printableArea')"  value = "Print Admission Letter"  class='btn btn-primary'>


								</div>



							</div>
						</div>
            
            <?php endforeach; ?>
            <script type="application/javascript">
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
