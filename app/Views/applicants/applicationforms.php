      <!-- Main Content -->
      <div class="main-content">
            <section class="section">

              <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">

                  <h4 class="page-title m-b-0">My Profile</h4>
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
          <div class="card-header">
            <h4>COMPLETED APPLICATION</h4>
          </div>
          <div class="card-body">

              <div class="row">


                <?php    foreach($stddetails as $appdetail):

               							 if (!$appdetail->biodata) {


                               echo '   <div class="mb-3 col-md-12">
                        <div class="alert alert-warning alert-dismissible" role="alert">


                          <div class="alert-message">
                            <h4 class="alert-heading">Not Completed!</h4>
                            <p>Your application has not been completed.<br>You can only view your completed application after providing all the requirements. </p>
                            <hr>
                            <p class="mb-0">Click on the  "My Application" link to see the status of your application.</p>
                          </div>
                        </div>
                      </div>';


               							 }elseif ($appdetail->biodata and $appdetail->stdcourse and $appdetail->std_custome5 and $appdetail->std_custome6 and $appdetail->std_custome8 and $appdetail->std_custome9 and $appdetail->stdprogramme_id == 2) {


                               echo '   <div class="mb-3 col-md-12">
                       <div class="alert alert-success alert-dismissible" role="alert">


                         <div class="alert-message">
                           <h4 class="alert-heading">Congratulations!</h4>
                           <p>Your application been completed. </p>
                           <hr>
                           <p class="mb-0"><a href =  "'.base_url().'/applicant/application_form" target = "_blank"> Print Application Form</a></p><br>
                           <p class="mb-0"><a href =  "'.base_url().'/applicant/application_card" target = "_blank">Print Acknowledgement Card</a></p>
                         </div>
                       </div>
                     </div>';


                   }elseif ($appdetail->biodata and $appdetail->stdcourse and $appdetail->std_custome7 and $appdetail->std_custome6 and $appdetail->std_custome8 and $appdetail->std_custome9 and $appdetail->stdprogramme_id == 1) {


                              echo '   <div class="mb-3 col-md-12">
                      <div class="alert alert-success alert-dismissible" role="alert">


                        <div class="alert-message">
                          <h4 class="alert-heading">Congratulations!</h4>
                          <p>Your application been completed. </p>
                          <hr>
                          <p class="mb-0"><a href =  "'.base_url().'/applicant/application_form" target = "_blank"> Print Application Form</a></p><br>
                          <p class="mb-0"><a href =  "'.base_url().'/applicant/application_card" target = "_blank">Print Acknowledgement Card</a></p>
                        </div>
                      </div>
                    </div>';


                           }else{

                                echo '   <div class="mb-3 col-md-12">
                         <div class="alert alert-warning alert-dismissible" role="alert">


                           <div class="alert-message">
                             <h4 class="alert-heading">Not Completed!</h4>
                             <p>Your application has not been completed.<br>You can only view your completed application after providing all the requirements. </p>
                             <hr>
                             <p class="mb-0">Click on the  "My Application" link to see the status of your application.</p>
                           </div>
                         </div>
                       </div>';

               							 }

                            endforeach;   ?>




                       </div>
            </div>


        </div>
      </div>
              </div>
            </div>
