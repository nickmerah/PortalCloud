      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">
              <h4 class="page-title m-b-0">Dashboard</h4>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('applicant');?>">
                <i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ul>
          
          <?php

                           if ( $pstat  == 1){
                             $fstat = "<b style='color:green'>PAID</b>";

                           }else{
                             $fstat = "<b style='color:red'>NOT PAID</b> | <a href = '".base_url('applicant/payappfees')."'>PAY NOW</a>";

                           }

                           if ( $appbiodata  == 1){
                             $bstat = "<b style='color:green'>Completed</b>";

                           }else{
                             $bstat = "<b style='color:red'>Incomplete</b>";

                           }
                           
                           if ( $astat  == 1){
                             $acstat = "<b style='color:green'>PAID</b>";

                           }else{
                             $acstat = "<b style='color:red'>NOT PAID</b>";

                           }


                           ?>
           <?php if(isset($stddetails)): ?>
              <?php foreach($stddetails as $stddetail): ?>
          <div class="alert alert-light alert-has-icon">
                     <div class="alert-icon"><i class="far fa-user"></i></div>
                     <div class="alert-body">
                       <div class="alert-title">
															 <?php if ($stddetail->stdprogramme_id == 1) {
                                    echo $stddetail->jambno;

                               }else {echo $stddetail->app_no;}  ?> | <strong>  <?= $fnames; ?></strong> |
															  <?= $stddetail->programmet_name; ?> <?= $stddetail->aprogramme_name; ?> <?= $stddetail->stdcourse; ?>

|
															 <?= $cs_session; ?> / <?= $cs_session+1; ?>

                            </div>

                     </div>
                   </div>
          <div class="row">

            <div class="col-lg-3 col-sm-4">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="info-box7-block">
                    <h6 class="m-b-20 text-right">Application Fee</h6>
                    <h4 class="text-right"><i
                        class="fas fa-dollar-sign pull-left bg-green c-icon"></i><span>&#8358;   <?=  number_format($appfees) ;?></span>
                    </h4>

                  </div>
                </div>
              </div>
            </div>


            <div class="col-lg-3 col-sm-6">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="info-box7-block">
                    <h6 class="m-b-20 text-right">Application Status</h6>
                    <h4 class="text-right"><i class="fas fa-users pull-left bg-cyan c-icon"></i><span>
<?php if ($appstatus) {
    echo $ap =  "<b style='color:green'>Submitted</b>";
}else{
  echo $ap =  "<b style='color:red; font-size:22px'>Not Submitted</b>";
} ?>


                    </span>
                    </h4>

                  </div>
                </div>
              </div>
            </div>
            
             <div class="col-lg-3 col-sm-6">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="info-box7-block">
                    <h6 class="m-b-20 text-right">Admission Status</h6>
                    <h4 class="text-right"><i class="fas fa-user-tag pull-left bg-red c-icon"></i><span>
<?php if ($admstatus) {
    echo $ad =  "<b style='color:green'>Admitted</b>";
}else{
  echo $ad =  "<b style='color:red; font-size:22px'>Not Admitted</b>";
} ?>


                    </span>
                    </h4>

                  </div>
                </div>
              </div>
            </div>
            
             <div class="col-lg-3 col-sm-6">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="info-box7-block">
                    <h6 class="m-b-20 text-right">Clearance Status</h6>
                    <h4 class="text-right"><i class="fas fa-user-check pull-left bg-blue c-icon"></i><span>
<?php if ($clearstatus) {
    echo $ac =  "<b style='color:green'>Cleared</b>";
}else{
  echo $ac =  "<b style='color:red; font-size:22px'>Not Cleared</b>";
} ?>


                    </span>
                    </h4>

                  </div>
                </div>
              </div>
            </div>


          </div>

          <div style="font-size:16px; color:#FFF"> <marquee  bgcolor="green" > For Successful Application Fee Payment, not reflecting, Click 'My Payments', and then, Click the 'Check Payment Status' button </marquee>
</div>
 
<div style="font-size:16px; color:#FFF"> <marquee  bgcolor="green" > For Successful Acceptance Fee Payment, not reflecting, Click 'Admission Panel', then 'Check Payment', and then, Click the 'Check Payment Status' button </marquee>
</div>
          <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>My Activity</h4>
                </div>
                <div class="card-body">
                  <div id="activity-scroll">
                    <ul class="activity-list">
                      <li> <i class="activity-icon bg-success"></i>
                        <h5>Application Fee </h5>
                        <span class="font-13"> <?= $fstat; ?> </span>
                      </li>
                      <li> <i class="activity-icon bg-info"></i>
                        <h5>Biodata </h5> <span
                          class="font-13"><?= $bstat; ?></span>
                      </li>
                      <li> <i class="activity-icon bg-warning"></i>
                        <h5>Application Forms</h5>
                        <span class="font-13"><?= $ap; ?></span>
                      </li>

                        <li> <i class="activity-icon bg-danger"></i>
                        <h5>Admission Status</h5>
                        <span class="font-13"><?= $ad; ?></span>
                      </li>
                      
                      <li> <i class="activity-icon bg-secondary"></i>
                        <h5>Acceptance Fee</h5>
                        <span class="font-13"><?= $acstat; ?></span>
                      </li>
                      
                      
                      <li> <i class="activity-icon bg-primary"></i>
                        <h5>Clearance Status</h5>
                        <span class="font-13"><?= $ac; ?></span>
                      </li>

                    </ul>
                  </div>
                </div>
              </div>
            </div>


          </div>
        <?php endforeach; ?>
                                          <?php endif; ?>

        </section>

      </div>
