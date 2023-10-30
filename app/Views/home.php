

          <div class="row">

<div class="col-12 col-sm-12 col-lg-6">
   <div class="card">
      <div class="card-header">
        <h4>LOGIN</h4>
      </div>
      <?= \Config\Services::validation()->listErrors(); ?>
          <form  id="app_login" name="app_login"
action="account/login" method="post">
          <?= csrf_field() ?>
      <div class="card-body">
        <div class="form-group">
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fas fa-user"></i></div>
            </div>
            <input type="text" class="form-control" name = "email" id="inlineFormInputGroup" placeholder="Jamb/Form Number" required autocomplete = "off">
          </div>
        </div>

        <div class="form-group">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" class="form-control" placeholder="Password" required name = "passkey">

          </div>
        </div>
<div align = "center">
<button class="btn btn-success mr-1" type="submit">LOGIN</button> 

</div> 
<div align="right"> <a href="<?= base_url('home/getformno'); ?>"> <strong> Retrieve Form Number</strong> </a> </div>






</div> </form>
    </div><div align = "center" class = "example5"> <marquee> <?= $marquee; ?> </marquee>
</div>

</div>


<div class="col-12 col-sm-12 col-lg-6">
   <div class="card">
      <div class="card-header">
        <h4>ADMISSION PANEL</h4>
      </div>
      <div class="card-body">

             
          <div  class="col-12 col-sm-12 col-lg-12"><a href="<?= base_url('home/startup'); ?>"><button type="button" class="col-12 col-sm-12 col-lg-12 btn btn-success" onclick = "alert('You have Selected Fulltime ND Application')"  >FULL TIME ND APPLICATION</button></a></div>
          <br />   
          <div  class="col-12 col-sm-12 col-lg-12"> <a href="<?= base_url('home/startfhnd'); ?>"><button type="button" class="col-12 col-sm-12 col-lg-12 btn btn-warning" onclick = "alert('You have Selected Fulltime HND Application')"  >FULL TIME HND APPLICATION</button></a></div> <br />
        
           
          <div  class="col-12 col-sm-12 col-lg-12"> <a href="<?= base_url('home/startpnd'); ?>"><button type="button" class="col-12 col-sm-12 col-lg-12 btn btn-danger" onclick = "alert('You have Selected Parttime ND Application')"  >PART TIME ND APPLICATION</button></a></div> <br />
        
          <div  class="col-12 col-sm-12 col-lg-12"> <a href="<?= base_url('home/startphnd'); ?>"><button type="button" class="col-12 col-sm-12 col-lg-12 btn btn-primary" onclick = "alert('You have Selected Parttime HND Application')"  >PART TIME HND APPLICATION</button></a></div>  
        
        
      </div>
    </div>
<strong><p id="demo" style="text-align:center; font-size: 18px; margin-top: 0px; ; color:red"> </p> </strong>

  </div>
</div>

</section>

</div>
