      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

          <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">

              <h4 class="page-title m-b-0">My Olevel Results</h4>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('applicant'); ?>">
                <i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ul>

          <div class="container-fluid p-0">

            <div class="row">


              <div class="col-md-9 col-xl-12">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="application" role="tabpanel">

                    <div class="card">

                      <div class="card-body">
                        <h5 class="card-title mb-0"><strong>O'LEVEL RESULTS</strong></h5>
                        <hr>
                        <form id="update_profile" name="update_profile" action="<?= base_url('applicant/add_olevel') ?>" method="post">
                          <?= csrf_field()  ?>
                          <?php if (empty($olevels)) { ?>


                            <div class="row">
                              <div class="col-12 col-md-6 col-lg-6">
                                <div class="card">
                                  <div class="card-header">
                                    <h4>First Sitting</h4>
                                  </div>
                                  <div class="card-body">
                                    <div class="table-responsive">
                                      <table cellpadding="0" cellspacing="0" class="table">

                                        <tr>
                                          <td colspan="3">
                                            <label class="form-label" for="inputCity"><strong> Examination Type</strong></label>
                                            <select name="examtype" id="examtype" class="form-control" required>
                                              <option value="">Select Exam Type</option>
                                              <?php $etype = array('NECO', 'WAEC/WASCE', 'NABTEB');
                                              foreach ($etype as $etypes) {
                                                echo "<option>" . $etypes . "</option>";
                                              }
                                              ?>
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <label class="form-label" for="inputCity"><strong> Center No</strong></label>
                                            <input name="centerno" type="text" class="form-control" id="centerno" autocomplete="off" required>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">&nbsp;
                                            <label class="form-label" for="inputCity"><strong> Examination No</strong></label>
                                            <input name="examno" type="text" class="form-control" id="examno" autocomplete="off" required>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <label class="form-label" for="inputCity"><strong>Month</strong></label>
                                            <select name="frommth" id="frommth" class="form-control" required>
                                              <option value="">Select Month</option>
                                              <option value='Jan'>Jan</option>
                                              <option value='Feb'>Feb</option>
                                              <option value='March'>March</option>
                                              <option value='Apr'>Apr</option>
                                              <option value='May'>May</option>
                                              <option value='Jun'>Jun</option>
                                              <option value='Jul'>Jul</option>
                                              <option value='Aug'>Aug</option>
                                              <option value='Sept'>Sept</option>
                                              <option value='Oct'>Oct</option>
                                              <option value='Nov'>Nov</option>
                                              <option value='Dec'>Dec</option>
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <label class="form-label" for="inputCity"><strong> Year</strong></label>
                                            <select name="toyear" id="toyear" class="form-control" required>
                                              <option value="">Select Year</option> <?php
                                                                                    $tyear = 1970;
                                                                                    for ($syear = date('Y'); $syear >= $tyear; $syear--) {
                                                                                    ?>
                                                <option value="<?php echo $syear ?>"><?php echo $syear ?></option>
                                              <?php
                                                                                    }
                                              ?>
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <br>


                                            <div>
                                              <h6> Subject & Grades</strong></h6>
                                            </div>
                                            <div class="row">
                                              <?php  //add multiple fields

                                              $nos = 8;

                                              for ($i = 1; $i <= $nos; $i++) {
                                              ?>



                                                <div class="mb-1 col-md-8">

                                                  <select name="subject[<?= $i; ?>]" id="subject" class="form-control">
                                                    <option value="">Select Subject</option>
                                                    <?php
                                                    foreach ($subjects as $subject) {
                                                      echo "<option>" . $subject->subjectname . "</option>";
                                                    }
                                                    ?>
                                                  </select>
                                                </div>


                                                <div class="mb-1 col-md-4">

                                                  <select name="grade[<?= $i; ?>]" id="grade" class="form-control">
                                                    <option value=""> Grade</option>
                                                    <?php
                                                    foreach ($grades as $grade) {
                                                      echo "<option>" . $grade->gradecode . "</option>";
                                                    }
                                                    ?>
                                                  </select>
                                                </div>

                                              <?php  }  ?>
                                            </div>
                                          </td>
                                        </tr>
                                      </table>
                                    </div>

                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-lg-6">
                                <div class="card">
                                  <div class="card-header">
                                    <h4>Second Sitting</h4>
                                  </div>
                                  <div class="card-body">
                                    <div class="table-responsive">
                                      <table cellpadding="0" cellspacing="0" class="table">

                                        <tr>
                                          <td colspan="3">
                                            <label class="form-label" for="inputCity"><strong> Examination Type</strong></label>
                                            <select name="examtypes" id="examtypes" class="form-control">
                                              <option value="">Select Exam Type</option>
                                              <?php $etype = array('NECO', 'WAEC/WASCE', 'NABTEB');
                                              foreach ($etype as $etypes) {
                                                echo "<option>" . $etypes . "</option>";
                                              }
                                              ?>
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <label class="form-label" for="inputCity"><strong> Center No</strong></label>
                                            <input name="centernos" type="text" class="form-control" id="centernos" autocomplete="off">
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">&nbsp;
                                            <label class="form-label" for="inputCity"><strong> Examination No</strong></label>
                                            <input name="examnos" type="text" class="form-control" id="examnos" autocomplete="off">
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <label class="form-label" for="inputCity"><strong>Month</strong></label>
                                            <select name="frommths" id="frommths" class="form-control">
                                              <option value="">Select Month</option>
                                              <option value='Jan'>Jan</option>
                                              <option value='Feb'>Feb</option>
                                              <option value='March'>March</option>
                                              <option value='Apr'>Apr</option>
                                              <option value='May'>May</option>
                                              <option value='Jun'>Jun</option>
                                              <option value='Jul'>Jul</option>
                                              <option value='Aug'>Aug</option>
                                              <option value='Sept'>Sept</option>
                                              <option value='Oct'>Oct</option>
                                              <option value='Nov'>Nov</option>
                                              <option value='Dec'>Dec</option>
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <label class="form-label" for="inputCity"><strong> Year</strong></label>
                                            <select name="toyears" id="toyears" class="form-control">
                                              <option value="">Select Year</option> <?php
                                                                                    $tyear = 1970;
                                                                                    for ($syear = date('Y'); $syear >= $tyear; $syear--) {
                                                                                    ?>
                                                <option value="<?php echo $syear ?>"><?php echo $syear ?></option>
                                              <?php
                                                                                    }
                                              ?>
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <br>


                                            <div>
                                              <h6> Subject & Grades</strong></h6>
                                            </div>
                                            <div class="row">
                                              <?php  //add multiple fields

                                              $nos = 8;

                                              for ($i = 1; $i <= $nos; $i++) {
                                              ?>



                                                <div class="mb-1 col-md-8">

                                                  <select name="subjects[<?= $i; ?>]" id="subjects" class="form-control">
                                                    <option value="">Select Subject</option>
                                                    <?php
                                                    foreach ($subjects as $subject) {
                                                      echo "<option>" . $subject->subjectname . "</option>";
                                                    }
                                                    ?>
                                                  </select>
                                                </div>


                                                <div class="mb-1 col-md-4">

                                                  <select name="grades[<?= $i; ?>]" id="grades" class="form-control">
                                                    <option value=""> Grade</option>
                                                    <?php
                                                    foreach ($grades as $grade) {
                                                      echo "<option>" . $grade->gradecode . "</option>";
                                                    }
                                                    ?>
                                                  </select>
                                                </div>

                                              <?php  }  ?>
                                            </div>
                                          </td>
                                        </tr>
                                      </table>
                                    </div>
                                  </div>

                                </div>
                              </div>






                              <button class="btn btn-success"><i class="fas fa-check"></i> Save O'Level Results</button>
                              <input name="noos" type="hidden" value="1" />
                            </div>


                          <?php  } else { ?>

                            <table class="table table-hover my-0" width="100%" style="font-size:12px">
                              <thead>
                                <tr>
                                  <th>Exam Type</th>
                                  <th>Subject Name</th>
                                  <th>Grade</th>
                                  <th>Date Obtained</th>
                                  <th>CenterNo</th>
                                  <th>ExamNo</th>
                                  <th>Sitting</th>

                              </thead>
                              <tbody>







                                <?php


                                foreach ($olevels as $olevel) { ?>
                                  <tr>
                                    <td><?= $olevel->certname; ?></td>
                                    <td><?= $olevel->subname; ?> </td>
                                    <td><?= $olevel->grade; ?> </td>
                                    <td> <?= $olevel->emonth; ?>, <?= $olevel->eyear; ?> </td>
                                    <td><?= $olevel->centerno; ?></td>
                                    <td><?= $olevel->examno; ?></td>
                                    <td><?= $olevel->sitting; ?></td>

                                  </tr>

                                <?php  } ?>

                              </tbody>
                            </table> <br /> <br />


                            <?= '<a href =  "' . base_url('applicant/rem_allolevel') . '" class="btn btn-danger"><i class="fas fa-check"></i> ReUpload OLevel Results </a>'; ?> 
                            | <?php
                                                                                                                                                                                  
                              $url = ($stddetails[0]->stdprogramme_id == 1) ? base_url('applicant/jamb') : base_url('applicant/school');
                                                                                                                                                                                  
                                                                                                                                                                                  ?>
                            <a href="<?= $url; ?>" class="btn btn-info"><i class="fas fa-info"></i> Click here to Save and Continue </a>
                          <?php } ?>

                      </div>

                    </div>

                  </div>

                  </form>

                </div>
              </div>

            </div>