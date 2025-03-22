      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

          <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">
              <h4 class="page-title m-b-0">Dashboard</h4>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('applicant'); ?>">
                <i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ul>


          <?php

          if ($pstat  == 1) {
            $fstat = "<b style='color:green'>PAID</b>";
          } else {
            $fstat = "<b style='color:red'>NOT PAID</b> | <a href = '" . base_url('applicant/payappfees') . "'>PAY NOW</a>";
          }

          if ($appbiodata  == 1) {
            $bstat = "<b style='color:green'>COMPLETED</b>";
          } else {
            $bstat = "<b style='color:red'>INCOMPLETE</b>";
          }

          if ($acceptfeestatus  == 1) {
            $acstat = "<b style='color:green'>PAID</b>";
          } else {
            $acstat = "<b style='color:red'>NOT PAID</b>";
          }

          if ($vstat == 1) {
            $avstat = "<b style='color:green'>PAID</b>";
          } else {
            $avstat = "<b style='color:red'>NOT PAID</b>";
          }


          ?>
          <?php if (isset($stddetails)) : ?>
            <?php foreach ($stddetails as $stddetail) : ?>
              <div class="alert alert-light alert-has-icon">
                <div class="alert-icon"><i class="far fa-user"></i></div>
                <div class="alert-body">
                  <div class="alert-title"> <small>
                      <?= $stddetail->jambno; ?> | <strong> <?= $stddetail->surname; ?></strong>, <?= $stddetail->firstname; ?> <?= $stddetail->othernames; ?> |
                      <strong> <?= $stddetail->aprogramme_name; ?> <?= $stddetail->programme_option; ?> </strong>|
                      <?= $cs_session; ?> / <?= $cs_session + 1; ?></small>

                  </div>

                </div>
              </div>

              <div class="marquee-container">
                <div class="marquee">
                  If you have successfully made payment and its not reflecting, click on 'Check Payment' to reprocess.
                </div>
              </div>
              <div class="row">

                <div class="col-lg-4 col-sm-4">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="info-box7-block">
                        <h6 class="m-b-20 text-right">Application Fee</h6>
                        <h4 class="text-right"><i class="fas fa-dollar-sign pull-left bg-green c-icon"></i><span>&#8358; <?= number_format($appfees); ?></span>
                        </h4>

                      </div>
                    </div>
                  </div>
                </div>


                <div class="col-lg-4 col-sm-6">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="info-box7-block">
                        <h6 class="m-b-20 text-right">Application Status</h6>
                        <h4 class="text-right"><i class="fas fa-users pull-left bg-cyan c-icon"></i><span>
                            <?php if ($appstatus) {
                              echo $ap =  "<b style='color:green'>SUBMITTED</b>";
                            } else {
                              echo $ap =  "<b style='color:red'>NOT SUBMITTED</b>";
                            } ?>


                          </span>
                        </h4>

                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="info-box7-block">
                        <h6 class="m-b-20 text-right">Admission Status</h6>
                        <h4 class="text-right"><i class="fas fa-user-tag pull-left bg-red c-icon"></i><span>
                            <?php if ($admstatus) {
                              echo $ad =  "<b style='color:green'>ADMITTED</b>";
                            } else {
                              echo $ad =  "<b style='color:red'>NOT ADMITTED</b>";
                            } ?>


                          </span>
                        </h4>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php if ($admstatus) { ?>
                <div class="alert alert-warning" role="alert">
                  <strong>Notice:</strong> Please be advised that you are required to accept your admission by paying the acceptance fee within two weeks. Failure to do so will result in forfeiting the admission.
                </div>
                <br> <?php } ?>


              <?php
              if ($clearancestatus[0]->eclearance == -1) { ?>
                <div class="alert alert-danger" role="alert">
                  <strong>Clearance Status:</strong> <?= $clearancestatus[0]->reject; ?>
                </div>
                <br> <?php } else if ($clearancestatus[0]->eclearance == 1) { ?>
                <div class="alert alert-success" role="alert">
                  <strong>Clearance Status:</strong> Congratulations!, you have been successfully cleared.
                </div>
              <?php } else {
                    } ?>

              <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                  <div class="activities">

                    <div class="activity">
                      <div class="activity-icon bg-success text-white">
                        <i class="fas fa-money-bill"></i>
                      </div>
                      <div class="activity-detail">
                        <div class="mb-2">
                          <span class="text-job">
                            <h6>Application Fee </h6>
                          </span>

                        </div>
                        <p><span class="font-13"> <?= $fstat; ?> </span></p>
                      </div>
                    </div>


                    <div class="activity">
                      <div class="activity-icon bg-info text-white">
                        <i class="fas fa-user-alt"></i>
                      </div>
                      <div class="activity-detail">
                        <div class="mb-2">
                          <span class="text-job">
                            <h6>Biodata </h6>
                          </span>

                        </div>
                        <p><span class="font-13"> <?= $bstat; ?> </span></p>
                      </div>
                    </div>

                    <div class="activity">
                      <div class="activity-icon bg-warning text-white">
                        <i class="fab fa-wpforms"></i>
                      </div>
                      <div class="activity-detail">
                        <div class="mb-2">
                          <span class="text-job">
                            <h6>Application Forms </h6>
                          </span>

                        </div>
                        <p><span class="font-13"> <?= $ap; ?> </span></p>
                      </div>
                    </div>

                    <div class="activity">
                      <div class="activity-icon bg-danger text-white">
                        <i class="fas fa-user-graduate"></i>
                      </div>
                      <div class="activity-detail">
                        <div class="mb-2">
                          <span class="text-job">
                            <h6>Admission Status </h6>
                          </span>

                        </div>
                        <p><span class="font-13"> <?= $ad; ?> </span></p>

                      </div>
                    </div>

                    <div class="activity">
                      <div class="activity-icon bg-secondary text-white">
                        <i class="fas fa-money-bill-alt"></i>
                      </div>
                      <div class="activity-detail">
                        <div class="mb-2">
                          <span class="text-job">
                            <h6>Acceptance Fee </h6>
                          </span>

                        </div>
                        <p><span class="font-13"> <?= $acstat; ?> </span></p>
                      </div>
                    </div>

                    <div class="activity">
                      <div class="activity-icon bg-primary text-white">
                        <i class="fas fa-money-bill-alt"></i>
                      </div>
                      <div class="activity-detail">
                        <div class="mb-2">
                          <span class="text-job">
                            <h6>Result Verification Fee </h6>
                          </span>

                        </div>
                        <p><span class="font-13"> <?= $avstat; ?> </span></p>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
              <?php /*   <div class="row">
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
                      
                      
                      

                    </ul>
                  </div>
                </div>
              </div>
            </div>*/ ?>


      </div>
      <?php endforeach; ?>
      <?php endif; ?>

      </section>

      </div>