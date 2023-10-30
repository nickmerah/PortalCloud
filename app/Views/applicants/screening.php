      <!-- Main Content -->
      <script type="text/javascript">
function chkcontrol(j) {
var total=0;
for(var i=0; i < document.form1.ckb.length; i++){
if(document.form1.ckb[i].checked){
total =total +1;}
if(total > 5){
alert("You can Only Select Five Subjects for Screening\nEnsure you don't submit a subject twice") 
document.form1.ckb[j].checked = false ;
return false;
}
}
} </script>
      <div class="main-content">
            <section class="section">

              <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">

                  <h4 class="page-title m-b-0">Screening</h4>
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
                       
                       <div class="card-body">
            
                   <div class="card-header">
                         <h4>O'LEVEL SCREENING</h4>
                       </div>
<br>
                  
<?php if ( empty ($olevels)) { ?>

 
  <div class="row">
               
  <div class=" mb-3 col-md-12 alert alert-danger alert-dismissible" role="alert">

<div class="alert-message">
  <strong>Error!</strong> You have not Uploaded your Olevel Results in Jamb Portal
</div>
</div>
 
</div>
 

<?php  }else{ ?>

    <div class="row">
            
               <div class=" mb-3 col-md-12 alert alert-danger alert-dismissible" role="alert">
             
             <div class="alert-message">
               <strong>Screening Requirement</strong> <br><?= $admreg; ?>
               <br>For more information <a href = "<?= base_url('public/olevel-requirements.pdf');?>" target="_blank">click here </a>
               <br><br>
              <b> You are to select ONLY 5 subjects from your combination above that you have the highest grades PREFERABLY in First Sitting.</b>
             </div>
             </div>
              
             </div>
           	<form  id="form1" name="form1"
                            action="<?=base_url('applicant/submit_screening')?>" method="post">
                        											<?= csrf_field()  ?>
  <table class="table table-hover my-0" width="100%" style="font-size:13px">
  									<thead>
  										<tr>
                                          <th></th>
  										 
                                            <th>Subject Name</th>
  											<th>Grade</th>
                                              
                                            
                                     
                                              
  									</thead>
  									<tbody>







                                      <?php
  								   
                                  /*   foreach ($olevels as $key => $object) {
                                        if ($object->subname === 'MATHEMATICS' || $object->subname === 'ENGLISH LANGUAGE') {
                                            unset($olevels[$key]);
                                        }
                                    }*/
 $i=0;
            foreach($olevels as $key => $olevel){
             
              
              ?>
                                          <tr>
                                          <td> 
                                            
                                          
                                          <input  class="form-check-input" type=checkbox 
                                          
                                     
                                          name = "sel_sub[]" id = "ckb"  value="<?= $olevel->id; ?>" onclick='chkcontrol(<?=$i;?>)';>
                                            
                                           
                                         
                                        </td>
  											 
  											<td><?= $olevel->subjects; ?> </td>
                                              <td><?= $olevel->grades; ?> </td>
                                             
                                                
                                              
  										</tr>

                                          <?php ++$i  ; } ?>

                                          <?php if ( $hasSecondSitting)  {  ?>
                                           

                                        <tr>
                                         <td colspan='3'> 
                                           
                                         
                                       
                                          
                                       <div class='mb-3 col-md-12 alert alert-warning alert-dismissible' role='alert'>
             
                                       <div class='alert-message'>
                                         
                                         <strong> SECOND SITTING UPLOADED IN APPLICATION PORTAL</strong>
                                       </div>
                                       </td>
                        
                       
                                            
                                               
                                             
                     </tr 
                                        <?php     foreach($hasSecondSitting as $keys => $olevels){
                                            ?>
                                           
                                           <tr>
                                          <td> 
                                            
                                          
                                          <input  class="form-check-input" type=checkbox 
                                          
                                     
                                          name = "sel_subs[]" id = "ckb"  value="<?= $olevels->o_id; ?>" onclick='chkcontrol(<?=$i;?>)';>
                                            
                                           
                                         
                                        </td>
  											 
  											<td><?= $olevels->subname; ?> </td>
                                              <td><?= $olevels->grade; ?> </td>
                                             
                                                
                                              
  										</tr>

                                            <?php ++$i; }    }?>

  									</tbody>
  								</table>     <br /> <br />
<?php
                  if (empty($checkcreg)) { ?>
									 
								  <button type="submit" class="btn btn-success" 
                  onClick="return confirm('Are you sure you want to change to submit selected subjects, please confirm you made the right selection because this submission is FINAL');" 
                  
                  >SUBMIT SELECTED SUBJECTS </button> 
									
							<?php	}else{
								 
								echo  ' <b style="font-size:12px; color:#C00"> SUBJECTS ALREADY SUBMITTED </b>';
								}  
                ?>
 
     </form>             
<?php } ?>


                       </div>





                     </div>
                         </div>
                       </div>
                       
