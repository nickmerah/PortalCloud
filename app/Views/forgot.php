

          <div class="row">

            <div class="col-12 col-sm-12 col-lg-6">
               <div class="card">
                  <div class="card-header">
                    <h4>Forgot Password</h4>
                  </div>
                  <?= \Config\Services::validation()->listErrors(); ?>
                  <form  id="app_login" name="app_login"
  action="<?= base_url('account/forgetpass');?>" method="post">
                  <div class="card-body">
                    <div class="form-group">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fas fa-at"></i></div>
                        </div>
                        <input type="email" class="form-control" id="inlineFormInputGroup" placeholder="Email Address" required>
                      </div>
                    </div>


<div align = "center">
   <button class="btn btn-success mr-1" type="submit">Reset Password</button>

</div>






                  </div>

                </form>
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
