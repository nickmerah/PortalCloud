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
            <h4>Course of Study</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-md">
                <tr>
                  <th>#</th>
                  <th>Programme</th>
                  <th>Course of Study</th>

                </tr>
                <?php


  										 if ($jambdetails) { ?>  <tr>
                  <td>1</td>
                  <td> <?= $jambdetails[0]->programme_name; ?></td>
                  <td><?= $jambdetails[0]->course; ?></td>

                </tr>
  <?php } ?>


              </table>
            </div> <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">
                  <a href="<?= base_url('applicant/my_application');?>" class="btn btn-primary btn-icon icon-left"><i class="fas fa-angle-double-left"></i>My Application</a>

                    <a href="<?= base_url('applicant/olevel');?>" class="btn btn-success btn-icon icon-left"><i class="fas fa-angle-double-right"></i>Next</a>

                </div>

              </div>
          </div>

        </div>
      </div>
              </div>
            </div>
