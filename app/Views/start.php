 
          <div class="row">

            <div class="col-12 col-sm-12 col-lg-6">
               <div class="card">
                  <div class="card-header">
                    <h4>CREATE ACCOUNT</h4>
                  </div>
                  <?= \Config\Services::validation()->listErrors(); ?> 
				  <?php if(isset($jambdetails)): ?>
 <?php foreach($jambdetails as $jambdetail):  ?>

                  <form  id="add_create" name="add_create"
  action="<?= base_url('account/store');?>" method="post">
											<?= csrf_field() ?>
                  <div class="card-body">
                    

                    <div class="form-group">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"> <i class="fas fa-user"></i></div>
                        </div>
                        <input name = "jambno" type="text" class="form-control" id="inlineFormInputGroup" value="<?=   $jambdetail[0]->jambno ; ?>" readonly="readonly" placeholder="Jamb Registration Number" required autocomplete = "off">
                      </div>
                    </div>

<div class="form-group">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"> <i class="fas fa-user"></i></div>
                        </div>
                        <input name = "log_surname" type="text" class="form-control" id="inlineFormInputGroup" value="<?php  $names = explode(" ",$jambdetail[0]->fullname);  echo $names[0]; ?>" readonly="readonly" placeholder="Fullnames" required autocomplete = "off">
                      </div>
                    </div>
                    
                    <?php
if ($names[2] == "") {
  $firstname =$names[1]; 
  $othernames = "";

}else{
  $firstname =$names[2]; 
  $othernames = $names[1];
}

?>
                    <div class="form-group">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fas fa-user-plus"></i></div>
                        </div>
                        <input name = "log_firstname" type="text" class="form-control" id="inlineFormInputGroup" value="<?=   $firstname ;?>" readonly="readonly" placeholder="Firstname" required autocomplete = "off">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                        </div>
                        <input name = "log_othernames" type="text" class="form-control" id="inlineFormInputGroup" value="<?= $othernames ;?>" placeholder="Othernames" autocomplete = "off">
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fas fa-school"></i></div>
                        </div>
                        <select name="sprogtype"   id="sprogtype"class="form-control" required>
                      <option value="<?= $jambdetail[0]->progtype ;?>"><?= $jambdetail[0]->programmet_name ;?></option>
                     

                    </select>   </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fas fa-school"></i></div>
                        </div>
                        <select name="prog_id"   id="sel_prog"  class="form-control" required>
                      <option value="<?= $jambdetail[0]->prog ;?>"><?= $jambdetail[0]->programme_name ;?></option>

                    </select>   </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-university"></i></span>
                        </div>
                        <select name="sprog"   id="sel_deptoption"class="form-control" required>
                      <option value="<?= $jambdetail[0]->course ;?>"><?= $jambdetail[0]->course ;?></option>

                    </select>

                      </div>
                    </div>
                   <?php /*   <div class="form-group">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">  <i class="fas fa-lock"></i></div>
                        </div>
                      <input  name = "pwd" type="password" minlength="4" class="form-control pwstrength" id="inlineFormInputGroup"  placeholder="Password" required data-indicator="pwindicator">
                       Your phone number will be used as your password
                      </div>

                    </div>*/?>

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
                        <input name = "log_gsm" type="number" class="form-control" id="inlineFormInputGroup"   placeholder="Phone Number (This will be used as your password)" required autocomplete = "off">
                      </div>
                    </div>

                   

                    <div class="form-group">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fas fa-user-lock"></i></div>
                        </div>
                        <input type="number" class="form-control" name = "captchaResult" id="inlineFormInputGroup" placeholder="Solve the Math: <?php $min_number = 1;
	$max_number = 9;

	$random_number1 = mt_rand($min_number, $max_number);
	$random_number2 = mt_rand($min_number, $max_number);
			echo $random_number1 . ' + ' . $random_number2 . ' = '; ?>"

	required autocomplete = "off">
                      </div>  <input name="firstNumber" type="hidden" value="<?= $random_number1; ?>" />
                      <input name="secondNumber" type="hidden" value="<?= $random_number2; ?>" />
                    </div>
<div align = "center"> 
   <button class="btn btn-success mr-1" type="submit">CREATE ACCOUNT</button> 

</div>






</div> </form> <?php endforeach; ?>
                                          <?php endif; ?>
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
      <script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
 