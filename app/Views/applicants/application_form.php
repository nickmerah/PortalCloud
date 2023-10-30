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
<div id="printableArea">  <?php if(isset($stddetails)): ?>


                                       <?php foreach($stddetails as $biodetail): ?>
            <div class="card"><br /><div align="center">
      <img src="<?= base_url('assets/img/logo.jpg');?>" alt="tops" width="102" height="103">
       <br> <strong style="font-size:20px"> The OKE_OGUN POLYTECHNIC, SAKI (TOPS)</strong> <br>
</h3>
 

  <strong style="font-size:18px; color:#900"> <u><?= $cs_session; ?> / <?= $cs_session + 1; ?> <?=  $biodetail->programme_name; ?>  APPLICATION FORM </u>  </strong>
</div>

              <div class="card-body">







                  <h5 class="card-title mb-0"><strong>CANDIDATE'S INFORMATION</strong></h5>  

                                 



                                       <div class="row">




                                        <table class="table table-bordered table-sm" cellpadding="0" cellspacing="0" style="font-size:13px">

            <tbody>
              <tr>
                <td width="191"><strong>Application No</strong></td>
                <td colspan="2"><span class="mb-3 col-md-6">
                  <?= $biodetail->app_no; ?>
                  </span><span class="mb-3 col-md-12">
                    
                  </span></td>
                <td width="336" rowspan="3">
                                                                                
                                                                                <?php


                    
                      //$filename =  base_url('public/uploads/'.$biodetail->std_photo); 
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
                  
                  <?= $biodetail->surname; ?> <?= $biodetail->firstname; ?> <?= $biodetail->othernames; ?>
                  <?php  } ?>
                  
                </span></td>
                </tr>
               
               
              <tr>
                <td><span class="mb-3">
                  <label class="form-label" for="inputUsername2"><strong>Email</strong></label>
                </span></td>
                <td colspan="2"><span class="mb-3 col-md-6">
                  <?= $biodetail->student_email; ?>
                </span></td>
                </tr>
              <tr>
                <td><strong>Phone Number</strong></td>
                <td width="268"><span class="mb-3 col-md-6">
                  <?= $biodetail->student_mobiletel; ?>
                </span></td>
                <td width="185"><span class="mb-3"><strong>Gender</strong></span></td>
                <td><span class="mb-3 col-md-6"><?php echo  ($biodetail->gender); ?></span></td>
                </tr>
              <tr>
                <td><span class="mb-3">
                  <strong>Date of Birth</strong></span>
                                    </span></td>
                <td><span class="mb-3 col-md-6">
                  <?= date('F d, Y', strtotime($biodetail->birthdate)); ?>
                </span></td>
                <td><span class="mb-3"><strong>Marital Status</strong></span></td>
                <td><span class="mb-3 col-md-6"><?php echo  ($biodetail->marital_status); ?></span></td>
                </tr>
              <tr>
                <td><span class="mb-3">
                 <strong>Permanent Home Address</strong>
                  </span></td>
                <td colspan="3"><span class="mb-3 col-md-6">
                  <?= $biodetail->student_homeaddress; ?>
                </span></td>
              </tr>
              <tr>
                <td><span class="mb-3">
                  <label class="form-label" for="inputAddress5"><strong>Contact Address</strong></label>
                </span></td>
                <td colspan="3"><span class="mb-3 col-md-6">
                  <?= $biodetail->contact_address; ?>
                </span></td>
              </tr>
                                <tr>
                <td><strong>State</strong></td>
                <td><span class="mb-3 col-md-6">
                  <?= $biodetail->state_of_origin; ?>
                </span></td>
                <td><strong>LGA</strong></td>
                <td><span class="mb-3 col-md-6">
                  <?= $biodetail->local_gov; ?>
                </span></td>
                </tr>
              <tr>
                <td>
                  <strong>Course </strong>
               </td>

                <td colspan="3"><span class="mb-3 col-md-6">
                  <?= $firstchoice; ?>
                </span></td>
              </tr>

              </tbody>
          </table>

                  


                                             







                                           <?php endforeach; ?>
                                               <?php endif; ?>
                                         <h5 class="card-title mb-0">&nbsp;</h5>
                  <h5 class="card-title mb-0">&nbsp;</h5>
                                                 <?php

if ($stddetails[0]->stdprogramme_id == 1 and $stddetails[0]->std_programmetype == 1) {



                                                if(isset($jambs)): ?>



                                              <h5 class="card-title mb-0"><strong> UTME DETAILS</strong></h5> <hr>

      <table class="table table-bordered table-sm" width="100%">
            <thead>
              <tr>
                <th align="left"><strong>UTME No</strong></th>
                <th><?=$jambs[0]->jambno;?></th>
              </tr>

             
            </thead>
            <tbody>







                                  <tr>
                  <td colspan="2">
                              <?php

for($j = 1; $j <= 4 ; $j++)
{  $subject = "subject$j";
	  $score = "score$j"; ?>

<strong><?= $jambs[0]->$subject ?></strong>:<?=$jambs[0]->$score;  ?> &nbsp;     <?php } ?> </td>
                </tr>

                             

            </tbody>
          </table>
                                            <br>


                                       <?php  endif; ?>

                                                <?php }


                                                if ($stddetails[0]->stdprogramme_id == 2 ) {

                                                if(isset($std_eduhistory)): ?>
                                         <br />
                                              <h5 class="card-title mb-0">&nbsp;</h5>
                                              <h5 class="card-title mb-0">&nbsp;</h5>
                                              <h5 class="card-title mb-0"><strong>SCHOOL ATTENDED  AND DATES</strong></h5>
                                              <hr>

<table class="table table-bordered table-sm" width="100%" style="font-size:13px">

              <tr>
                <th>School Name</th>
                                       <th>Course of Study</th>
                                       <th>ND Matric No</th>
                <th>From</th>
                                      <th>To</th>
              </tr>

            <tbody>


                              <?php
     foreach($std_eduhistory as $edu){ ?>
                                  <tr>
                <td><?= $edu->pname; ?></td>
                <td><?= $edu->programme_option; ?> </td>
                <td><?= $edu->ndmatno; ?> </td>
                                      <td><?= $edu->fromdate; ?> </td>
                                      <td><?= $edu->todate; ?>  </td> 
                                      <?php 
$org = $edu->organization; $address = $edu->address; $itdatefrom = $edu->itdatefrom ; $itdateto= $edu->itdateto;
?>                       
              </tr>

                                  <?php } ?>

            </tbody>
          </table>
          <h5 class="card-title mb-0">&nbsp;</h5>
                                              <h5 class="card-title mb-0">&nbsp;</h5>
                                              <h5 class="card-title mb-0"><strong>INDUSTRIAL TRAINING</strong></h5>
                                              <hr>

<table class="table table-bordered table-sm" width="100%" style="font-size:13px">

              <tr>
              <th>Organization</th>
                                               <th>Address</th>
  											<th>From</th>
                                              <th>To</th>
              </tr>

            <tbody>


            <td><?= $org; ?></td>
											<td><?= $address; ?> </td>
                      <td><?= date('d-m-Y', strtotime($itdatefrom));  ?> </td>
                                            <td><?= date('d-m-Y', strtotime($itdateto));  ?>   </td>

            </tbody>
          </table>



                                       <?php endif; ?>





                                        <?php } if(isset($olevels)): ?>


                                               <h5 class="card-title mb-0">&nbsp;</h5>
                                               <h5 class="card-title mb-0">&nbsp;</h5>
                                               <h5 class="card-title mb-0"><strong>O'LEVEL RESULTS</strong></h5>
                                               <hr>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td valign="top"><table class="table table-bordered table-sm" width="100%" style="font-size:12px">
<?php $filteredFirst = array_filter($olevels, function($object) {
                                return $object->sitting === 'First';
                            });
 ?>
              <tr>
                <th colspan="4" align="left"><strong>FIRST SITTING </strong></th>
                <tr>
                  <th width="18%" align="left">Exam Type:</th>
                  <th width="40%" align="left"><?= $filteredFirst[0]->certname; ?></th>
                  <th width="16%" align="left">CenterNo:</th>
                  <th width="26%" align="left"><?= $filteredFirst[0]->centerno; ?></th>
                  <tr>
                  <th align="left">Exam Date:</th>
                  <th align="left"><?= $filteredFirst[0]->emonth; ?>
                    ,
                      <?= $filteredFirst[0]->eyear; ?></th>
                  <th align="left">ExamNo:</th>
                  <th align="left"><?= $filteredFirst[0]->examno; ?></th>
                  <tr>
              <th colspan="2" align="left">SUBJECT</th>
                          <th colspan="2" align="left">GRADE</th>
                        <tbody>
                              <?php
							    
						  
    foreach($filteredFirst as $olevel){ ?>
                                  <tr>
                <td colspan="2" align="left"><?= $olevel->subname; ?></td>
                <td colspan="2" align="left"><?= $olevel->grade; ?></td>
                          </tr>


                    <?php  } ?>
            </tbody>
          </table></td>
    <td valign="top"><table class="table table-bordered table-sm" width="100%" style="font-size:12px">
<?php   $ofilteredSecond = array_filter($olevels, function($object) {
                              return $object->sitting === 'Second';
                          });

                          $filteredSecond = array_values(array_filter($ofilteredSecond));
                          
                     
                          ?>
             
             
             <tr>
             <?php if (!empty($filteredSecond)) {  ?>    <th colspan="4" align="left"><strong>SECOND SITTING </strong></th>
             <tr>
                  <th width="19%" align="left">Exam Type:</th>
                  <th width="43%" align="left"><?= $filteredSecond[0]->certname; ?></th>
                  <th width="18%" align="left">CenterNo:</th>
                  <th width="20%" align="left"><?= $filteredSecond[0]->centerno; ?></th>
                  <tr>
                  <th align="left">Exam Date:</th>
                  <th align="left"><?= $filteredSecond[0]->emonth; ?>
                    ,
                      <?= $filteredSecond[0]->eyear; ?></th>
                  <th align="left">ExamNo:</th>
                  <th align="left"><?= $filteredSecond[0]->examno; ?></th>
                   <tr>
              <th colspan="2" align="left">SUBJECT</th>
                          <th colspan="2" align="left">GRADE</th><?php  } ?>
                       
                        <tbody>
                              <?php
							    
						  
    foreach($filteredSecond as $olevels){ ?>
                                  <tr>
                <td colspan="2" align="left"><?= $olevels->subname; ?></td>
                <td colspan="2" align="left"><?= $olevels->grade; ?></td>
                          </tr>


                    <?php  } ?>
            </tbody>  
          </table></td>
  </tr>
</table>



                                               <?php endif; ?>




                           <h5 class="card-title mb-0">&nbsp;</h5>
                           <h5 class="card-title mb-0">&nbsp;</h5>
                           <h6 class="card-title mb-0"><strong>DECLARATION/ATTESTATION</strong></h6>
                           <hr> I, <?= $biodetail->surname; ?> <?= $biodetail->firstname; ?> <?= $biodetail->othernames; ?> hereby declare that the information given in this form is correct. I understand that i will be held liable for any information therein. I also understand that if any information given is later found to be false, incomplete or misleading, The Oke-Ogun Polytechnic, Saki reserves the right to take appropriate disciplinary measures against me.
						   
<h6 class="card-title mb-0">NOTE:</h6><br>
Kindly print this form and bring it along with you if you are admitted. You will be expected to also present the followimg
documents:<br>
- O'Level Results(s)<br>
- Birth Certificates<br>
- State of Origin Certificates









</div>




      </div>

























          </div>
            </div> </div>




          </div>

                             <input type= "button" onClick="printDiv('printableArea')"  value = "Print Application Form"  class='btn btn-primary'>


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
