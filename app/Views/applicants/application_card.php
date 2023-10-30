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
								<div class="tab-pane fade show active" id="payslip" role="tabpanel">
<div id="printableArea">
									<div class="card"><br /><div align="center">
            <img src="<?= base_url('assets/img/logo.jpg');?>" alt="tops" width="102" height="103">
             <br> <strong style="font-size:20px">The Oke-Ogun Polytechnic, Saki</strong> <br>
  </h3>
        <br>
        <strong style="font-size:18px; color:#900"> <u><?= $cs_session; ?> / <?= $cs_session + 1; ?> <?=  $biodetail->programme_name; ?>  ACKNOWLEDGEMENT CARD </u>  </strong>
        
</div>
<div class="card-body">
    <h5 class="card-title mb-0"><strong>BIODATA</strong></h5> <hr>

                     <?php if(isset($stddetails)): ?>


                         <?php foreach($stddetails as $biodetail): ?>



                         <div class="row">




                          <table class="table table-bordered table-md" cellpadding="0" cellspacing="0" style="font-size:13px">

<tbody>
<tr>
  <td width="179"><strong>Application No</strong></td>
  <td colspan="2"><span class="mb-3 col-md-6">
    <?= $biodetail->app_no; ?>
  </span><span class="mb-3 col-md-12"></span></td>
  <td rowspan="4"><?php
                    
                     // $filename =  base_url('public/uploads/'.$biodetail->std_photo); 
                          $picurl = "http://student.tops.edu.ng:82/portal/supportadmin/jambphoto/";                     
                                                                            
                                                                            
                          if ($stddetails[0]->stdprogramme_id == 1 and $stddetails[0]->std_programmetype	== 1) {
                            $filename = $picurl.strtoupper($biodetail->jambno.".jpg");
                          }else{
                            $filename = $picurl.strtoupper($biodetail->std_photo);
                          }
                          $chkimg = 	\App\Controllers\Applicant::getValidUrl($filename);
                         $photo =  $chkimg != 0 ? $filename : base_url('public/uploads/avatar.jpg');                                             
                              ?>                                                  
                         
                          <img alt="Photo" src="<?= $photo ?>"  width="135" height="131" />
                                           
                                                         
                                                                              
                                                                              </td>
</tr>
<tr>
  <td><strong>Fullnames</strong></td>
  <td colspan="2"><span class="mb-3 col-md-6">
  <?php if ($stddetails[0]->stdprogramme_id == 1 and $stddetails[0]->std_programmetype	== 1) { ?>
                  <?=$jambs[0]->fullname;?>
                <?php } else { ?>
    <?= $biodetail->surname; ?>
    <?= $biodetail->firstname; ?>
    <?= $biodetail->othernames; ?>

    <?php } ?>
  </span></td>
  </tr>
<tr>
  <td><span class="mb-3"><strong>Email</strong></span></td>
  <td colspan="2"><span class="mb-3 col-md-6">
    <?= $biodetail->student_email; ?>
  </span></td>
  </tr>
<tr>
  <td><strong>Phone Number</strong></td>
  <td colspan="2"><span class="mb-3 col-md-6">
    <?= $biodetail->student_mobiletel; ?>
  </span></td>
  </tr>
<tr>
  <td><span class="mb-3"><strong>Gender</strong></span></td>
  <td width="242"><span class="mb-3 col-md-6"><?php echo  ($biodetail->gender); ?></span></td>
  <td width="260"><span class="mb-3"><strong>Marital Status</strong></span></strong></td>
  <td width="247"><span class="mb-3 col-md-6"><?php echo  ($biodetail->marital_status); ?></span></td>
    </tr>
<tr>
  <td><span class="mb-3"><strong>Date of Birth</strong>
                      </span></td>
  <td><span class="mb-3 col-md-6">
    <?= date('F d, Y', strtotime($biodetail->birthdate)); ?>
  </span></td>
  <td><strong>LGA</strong></td>
  <td><span class="mb-3 col-md-6">
    <?= $biodetail->local_gov; ?>
  </span></td>
  </tr>

<tr>
  <td><strong>State</strong></td>
  <td colspan="3"><span class="mb-3 col-md-6">
    <?= $biodetail->state_of_origin; ?>
  </span></td>
</tr>

<tr>
  <td>
    <strong>Course of Study   </strong> </td>
  <td colspan="3"><span class="mb-3 col-md-6">
    <?= $firstchoice; ?>
    </span></td>
</tr>


                <?php /*   <tr>
  <td><strong>Exam Date / Time </strong></td>
  <td colspan="3"><?= date('d-M-Y h:i:s', strtotime($examdate)); ?></td>
  </tr>*/?>
</tbody>
</table>




                             <?php endforeach; ?>
                                 <?php endif; ?>







</div>

                      <h5 class="card-title mb-0">&nbsp;</h5>
                      <h5 class="card-title mb-0"><strong>NOTICES</strong></h5>
                      <hr>
                      <div
                      <ul style="font-size:12px">
                        <li>Applicants are not allowed to enter the examination hall with any paper or mobile devices of any kind</li>
                        <li>Applicants must come along with their acknowledgement card to the examination and interview venue</li>
                      </ul>


</div>
									  </div>




								</div>


							</div><input type= "button" onClick="printDiv('printableArea')"  value = "Print Acknowledgement Card "  class='btn btn-primary'>

						</div>
					</div><script type="application/javascript">
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
