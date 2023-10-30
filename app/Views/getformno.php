<div class="row">
  <div class="col-12 col-md-6 col-lg-6">
    <div class="card">
  <div class="card-header">
 <h4>Retrieve Form No</h4>
</div>
<div class="card-body">
 <div class="table-responsive">
  <form  id="app_login" name="app_login"
action="<?= base_url('account/getformno');?>" method="post">  
<?= csrf_field() ?>

<table class="table table-bordered table-md">
     <tr>

       <th>Enter your Phone Number </th>
       <th><div class="form-group">
<div class="input-group mb-3">

  <span class="input-group-text"><i class="fas fa-phone"></i></span>

<input id="signin-password" name="log_gsm" type="text" autocomplete = "off" class="form-control signin-password" placeholder="Phone Number" required="required">

</div>
</div></th>

     </tr>
     <tr>
       <td colspan="2" align="center"><button class="btn btn-success mr-1" type="submit">CHECK</button> </td>
     </tr>

     <?php if (isset($fdata)) { ?>
     <tr>

       <td colspan="2" align="center"><strong>Applicant's Details </strong></td>
     </tr>
  <?php //print_r($fdata);  
  foreach($fdata as $fd) {?>
  <tr>
       <td>Form No</td>
       <td><?= $fd['log_username'];?></td>
     </tr>
     <tr>
       <td>Fullname</td>
       <td><?= $fd['log_surname'];?> <?= $fd['log_firstname'];?> <?= $fd['log_othernames'];?></td>
     </tr>
     <tr>
       <td>Phone Number</td>
       <td><?= $fd['log_gsm'];?></td>
     </tr>
<?php }} ?>

   </table></form>
 </div>
</div>

</div>
<div align = "center" class = "example5"> <marquee> <?= $marquee; ?> </marquee>
</div>
</div>


<div class="col-12 col-sm-12 col-lg-6">
   <div class="card">
      <div class="card-header">
        <h4>NOTICES:</h4>
      </div>
      <div class="card-body">

        <ol>
          <li>Please Use the Top Menu for your Application processes</li>
          <li>Application form payment can be purchased online or in Bank Branches nationwide with your REMITA RRR</li>
          <li>Please endeavor to wait till after 24 hours before you retry payment with your ATM card if you have any technical/failed issue.</li>

        </ol>
      </div>
    </div>
<strong><p id="demo" style="text-align:center; font-size: 18px; margin-top: 0px; ; color:red"> </p> </strong>

  </div>
</div>

</section>

</div>
