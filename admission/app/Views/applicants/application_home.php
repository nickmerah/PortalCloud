      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

          <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">

              <h4 class="page-title m-b-0">My Application</h4>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('applicant'); ?>">
                <i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ul>

          <?php foreach ($stddetails as $appdetail) : ?>

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4> Application Status</h4>

                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">

                      <table class="table table-striped" id="sortable-table">
                        <thead>
                          <tr>
                            <th class="text-center">
                              <i class="fas fa-th"></i>
                            </th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <div class="sort-handler">
                                <i class="fas fa-th"></i>
                              </div>
                            </td>
                            <td>Application Fee</td>

                            <td>
                              <div class="badge badge-<?= $pstat == 0 ? 'danger' : 'success' ?>"><?= $pstat == 0 ? 'Not Paid' : 'Paid' ?></div>
                            </td>


                            <td>
                              <?= $pstat == 0 ?

                                "<form  id='pay_now' name='pay_now'
         action= '" . base_url('applicant/paynow') . "' method='post'>
            <?= csrf_field() ?>
            <button  type='submit' class='btn btn-danger btn-icon icon-left'><i class='fas fa-credit-card'></i> PAY NOW</button>
   </form>
            " :   "<a href='' class='btn btn-success'>PAID</a> "   ?>




                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="sort-handler">
                                <i class="fas fa-th"></i>
                              </div>
                            </td>
                            <td>Biodata</td>

                            <td>
                              <div class="badge badge-<?= $appdetail->biodata == 0 ? 'danger' : 'success' ?>"><?= $appdetail->biodata == 0 ? 'Not Completed' : 'Completed' ?></div>
                            </td>
                            <td>

                              <?= $appdetail->biodata == 0 ? "<a href='" . base_url('applicant/biodata') . "' class='btn btn-warning'>
                                      Start </a>" :   "<a href='" . base_url('applicant/biodata') . "' class='btn btn-success'>
                                      Completed </a>"  ?>




                            </td>
                          </tr>

                          <tr>
                            <td>
                              <div class="sort-handler">
                                <i class="fas fa-th"></i>
                              </div>
                            </td>
                            <td>O'Level</td>

                            <td>
                              <div class="badge badge-<?= $appdetail->std_custome6 == 0 ? 'danger' : 'success' ?>"><?= $appdetail->std_custome6 == 0 ? 'Not Completed' : 'Completed' ?></div>
                            </td>
                            <td><?= $appdetail->std_custome6 == 0 ? "<a href='" . base_url('applicant/olevel') . "' class='btn btn-warning'>
         Start </a>" :   "<a href='" . base_url('applicant/olevel') . "' class='btn btn-success'>
         Completed </a>"   ?></td>
                          </tr>
                          
                          
<?php if ($appdetail->stdprogramme_id == 1 and  $appdetail->std_programmetype == 1 ) { 
    
  $havejamb = !empty($jambs) ? 1 : 0;
   $jambcompleted =   ($appdetail->std_custome7 == 0 || $havejamb == 0) ? 0 : 1;


?> 
                              <tr>
                                <td>
                                  <div class="sort-handler">
                                    <i class="fas fa-th"></i>
                                  </div>
                                </td>
                                <td>JAMB/UTME Result </td>

                                <td>
                                  <div class="badge badge-<?= !$jambcompleted ? 'danger':'success' ?>"><?= $jambcompleted ? 'Not Completed':'Completed' ?></div>
                                </td>
                                <td><?= !$jambcompleted ? "<a href='".base_url('applicant/jamb')."' class='btn btn-warning'>
         Start </a>" :   "<a href='".base_url('applicant/jamb')."' class='btn btn-success'>
         Completed </a>"   ?></td>
       </tr> <?php } ?>

                          <?php if ($appdetail->stdprogramme_id == 2) { ?>
                            <tr>
                              <td>
                                <div class="sort-handler">
                                  <i class="fas fa-th"></i>
                                </div>
                              </td>
                              <td>Schools Attended (HND Applicants)</td>

                              <td>
                                <div class="badge badge-<?= $appdetail->std_custome5 == 0 ? 'danger' : 'success' ?>"><?= $appdetail->std_custome5 == 0 ? 'Not Completed' : 'Completed' ?></div>
                              </td>
                              <td><?= $appdetail->std_custome5 == 0 ? "<a href='" . base_url('applicant/school') . "' class='btn btn-warning'>
         Start </a>" :   "<a href='" . base_url('applicant/school') . "' class='btn btn-success'>
         Completed </a>"   ?></td>
                            </tr>

                          <?php } ?>

                          <tr>
                            <td>
                              <div class="sort-handler">
                                <i class="fas fa-th"></i>
                              </div>
                            </td>
                            <td>Declaration</td>

                            <td>
                              <div class="badge badge-<?= $appdetail->std_custome8 == 0 ? 'danger' : 'success' ?>"><?= $appdetail->std_custome8 == 0 ? 'Not Completed' : 'Completed' ?></div>
                            </td>
                            <td><?= $appdetail->std_custome8 == 0 ? "<a href='" . base_url('applicant/declares') . "' class='btn btn-warning'>
         Start </a>" :   "<a href='" . base_url('applicant/declares') . "' class='btn btn-success'>
         Completed </a>"   ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <?php
                  if ($appdetail->std_custome9) {

                    echo  '<a href =  "' . base_url('applicant/application_forms') . '" class="btn btn-success"><i class="fas fa-check"></i> Proceed to Print Your Application Forms </a>';
                  } elseif ($appdetail->biodata and $appdetail->stdcourse and $appdetail->std_custome5 and $appdetail->std_custome6 and $appdetail->std_custome8 and $appdetail->stdprogramme_id == 2) {

                    echo  '<a href =  "' . base_url('applicant/application_preview') . '" class="btn btn-warning"><i class="fas fa-check"></i> Preview & Submit Application</a>';
                  } elseif ($appdetail->biodata and $appdetail->stdcourse   and $appdetail->std_custome6 and $appdetail->std_custome7 and $appdetail->std_custome8 and $appdetail->stdprogramme_id == 1) {

                    echo  '<a href =  "' . base_url('applicant/application_preview') . '" class="btn btn-warning"><i class="fas fa-check"></i> Preview & Submit Application</a>';
                  } else {
                  }

                  ?>

                <?php endforeach; ?>
                </div>
              </div>
            </div>