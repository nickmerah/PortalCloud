 
          <div class="row">

<div class="col-12 col-sm-12 col-lg-6">
   <div class="card">
      <div class="card-header">
        <h4>CREATE ACCOUNT - <?=$formname;?> APPLICANTS</h4>
      </div>
      <?= \Config\Services::validation()->listErrors(); ?> 


      <form  id="add_create" name="add_create"
action="<?= base_url('account/storepart');?>" method="post" enctype="multipart/form-data">
          <?= csrf_field() ?>
      <div class="card-body">
      
      
        


<div class="form-group">
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text"> <i class="fas fa-user"></i></div>
            </div>
            <input name = "log_surname" type="text" class="form-control" id="inlineFormInputGroup"   placeholder="Surname" required autocomplete = "off">
          </div>
        </div>
        
        
        <div class="form-group">
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fas fa-user-plus"></i></div>
            </div>
            <input name = "log_firstname" type="text" class="form-control" id="inlineFormInputGroup"   placeholder="Firstname" required autocomplete = "off">
          </div>
        </div>

        <div class="form-group">
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
            </div>
            <input name = "log_othernames" type="text" class="form-control" id="inlineFormInputGroup"   placeholder="Othernames" autocomplete = "off">
          </div>
        </div>
         <div class="form-group">
          <div class="input-group mb-2">
            <div class="input-group-prepend">

              <div class="input-group-text"><i class="fas fa-at"></i></div>
            </div>
            <input name = "log_email" type="email" class="form-control" id="inlineFormInputGroup"  placeholder="Email Address" required autocomplete = "off">
          </div>
        </div>

        <div class="form-group">
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text"> <i class="fas fa-phone"></i></div>
            </div>
            <input name = "log_gsm" type="number" class="form-control" id="inlineFormInputGroup"   placeholder="Phone Number [this will be used as your password]" required autocomplete = "off">
          </div>
        </div>
         <div class="form-group">
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fas fa-school"></i></div>
            </div>
            <select name="sprogtype"   id="sprogtype"class="form-control" required>
          <?php  
foreach($progtypes as $progtype){
 echo "<option value='".$progtype->programmet_id."'>".$progtype->programmet_name."</option>";
} 
?>
         

        </select>   </div>
        </div>

        <div class="form-group">
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fas fa-book-open"></i></div>
            </div>
            <select name="prog_id"   id="prog_id"  class="form-control" required>
          
           <?php  
foreach($progs as $prog){
 echo "<option value='".$prog->programme_id."'>".$prog->programme_name.' - '. $prog->aprogramme_name."</option>";
} 
?>
        </select>   </div>
        </div>

        <div class="form-group">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-university"></i></span>
            </div>
            <select name="sprog"   id="sel_deptoption"class="form-control" required>
          <option value="">Select Course of Study </option>
<?php  
foreach($cos as $progtype){
 echo "<option value='".strtoupper($progtype->programme_option)."'>".strtoupper($progtype->programme_option)."</option>";
} 
?>
        </select>

          </div>
        </div>
       
        <div class="form-group">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
            </div>
            <select name="cstate"   id="cstate"  class="form-control" required>
                    
                          <option value="<?php echo empty($biodetail->state_of_origin) ? "" : "$biodetail->state_of_origin"; ?>"><?php echo empty($biodetail->state_of_origin) ? "Select  State of Origin" : $biodetail->state_name; ?></option>
                   <?php
           foreach($states as $state){
             echo "<option value='".$state->state_name."'>".$state->state_name."</option>";
           }
           ?>
           
                  </select>

          </div>
        </div>
       
<div class="form-group">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-upload"></i>&nbsp; Upload Passport</span>
            </div>
            <input name="file" type="file" class="form-control" accept=".jpg"/>

          </div>
        </div>
       

        <div class="form-group">
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fas fa-user-lock"></i>&nbsp; Solve the Math: <?php $min_number = 1;
$max_number = 10;

$random_number1 = mt_rand($min_number, $max_number);
$random_number2 = mt_rand($min_number, $max_number);
echo $random_number1 . ' + ' . $random_number2 . ' = '; ?></div>
            </div>
            <input type="number" class="form-control" name = "captchaResult" id="inlineFormInputGroup"  

required autocomplete = "off">
          </div>  <input name="firstNumber" type="hidden" value="<?= $random_number1; ?>" />
          <input name="secondNumber" type="hidden" value="<?= $random_number2; ?>" />
        </div>
<div align = "center">
<button class="btn btn-success mr-1" type="submit">CREATE ACCOUNT</button>

</div>






</div> </form>  
    </div><div align = "center" class = "example5"> <marquee> <?= $marquee; ?> </marquee>
</div>

</div>

<div class="col-12 col-sm-12 col-lg-6">
   <div class="card">
      <div class="card-header">
        <h4>NOTICES:</h4>
      </div>
      <div class="card-body">

        <ol>
        
          <li>THIS IS <strong style="font-size:28px; color:red; text-decoration:blink"><?=$formname;?> APPLICATION</strong>, If you are here by mistake, please go back and choose the right application option</li>
          <li>Application form payment can be purchased online or in Bank Branches nationwide with your REMITA RRR</li>
          <li>Please endeavor to wait till after 24 hours before you retry payment with your ATM card if you have any technical/failed issue.</li>

        </ol>
      </div>
    </div>
<strong><p id="demo" style="text-align:center; font-size: 18px; margin-top: 0px; ; color:red"> </p> </strong>

  </div>
</div>

</section>

</div><script src="<?=base_url('assets/js/jquery.min.js')?>"></script>

