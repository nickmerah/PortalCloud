      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

          <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">

              <h4 class="page-title m-b-0">My UTME Results</h4>
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


                        <strong>ADD UTME RESULT DETAILS</strong>





                        <hr />
                      

                        <form name="add_jamb" action="add_jamb" method="post">


                          <div class="row">




                            <div class="mb-3 col-md-12">
                              <label class="form-label" for="inputCity"><strong> UTME No</strong></label>
                              <input name="jambno" type="text" class="form-control" id="jambno"
                                value="<?= isset($jambs[0]) ? htmlspecialchars($jambs[0]->jambno) : ''; ?>"
                                autocomplete="off" required placeholder="Enter UTME No">
                            </div>



                            <div class=" col-lg-12">




                              <div class="alert alert-light ">

                                UTME SUBJECTS & SCORE
                              </div>


                            </div>
                            <?php
                            for ($i = 1; $i <= 4; $i++) {
                              // Initialize savedSubject and savedScore with default empty values
                              $savedSubject = '';
                              $savedScore = '';

                              // Check if there's a corresponding $jambs entry for the current iteration
                              if (isset($jambs[$i - 1])) {
                                $savedSubject = $jambs[$i - 1]->subjectname;
                                $savedScore = $jambs[$i - 1]->jscore;
                              }
                            ?>



                              <div class="mb-1 col-md-6">




                                <select name="subject[<?= $i; ?>]" id="subject<?= $i; ?>" class="form-control">
                                  <option value="">Select Subject</option>
                                  <?php
                                  foreach ($subjects as $subject) {  // Assuming $allSubjects contains the list of all available subjects
                                    $selected = ($subject->subjectname === $savedSubject) ? 'selected' : '';
                                    echo "<option value=\"{$subject->subjectname}\" $selected>{$subject->subjectname}</option>";
                                  }
                                  ?>
                                </select>


                              </div>


                              <div class="mb-1 col-md-6">

                                <input type="number" class="form-control" name="score[<?= $i; ?>]" autocomplete="off" value="<?= htmlspecialchars($savedScore); ?>" required placeholder="Enter Score" min="1" max="100">




                              </div>
                              <br /><br />
                            <?php  }


                            ?>

                          </div>
                          <button class="btn btn-success"><i class="fas fa-check"></i> Save UTME Results</button>
                        </form>

                      </div>

                    </div>
                    <?php
                    if ($jambs) {

                      echo   '<a href =  "' . base_url('applicant/declares') . '" class="btn btn-info"><i class="fas fa-info"></i> Click here to Save and Continue </a>';
                    } ?>

                  </div>



                </div>
              </div>

            </div>