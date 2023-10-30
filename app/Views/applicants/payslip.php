      <!-- Main Content -->
      <div class="main-content">
            <section class="section">

              <ul class="breadcrumb breadcrumb-style ">
                <li class="breadcrumb-item">

                  <h4 class="page-title m-b-0">e-Invoice</h4>
                </li>
                <li class="breadcrumb-item">
                <a href="<?= base_url('applicant');?>">
                    <i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ul>


               <?php if(isset($transdetails)): ?>
                  <?php foreach($transdetails as $transdetail): ?>

              <div class="invoice">
                   <div class="invoice-print">
                     <div class="row">
                       <div class="col-lg-12">
                         <div class="invoice-title">
                           <div align = "center"><img alt="image" src="<?= base_url('assets/img/logo.jpg');?>" class="header-logo" width = "120" height = "120" />
                             <h2> The Oke-Ogun Polytechnic, Saki</h2>
<br>   <h3>e-Invoice - <?= $transdetail->trans_custom1; ?></h3>
                           </div>
                           <hr>


                         </div>





                    <div class="card-body">
                      <div class="py-4">
                        <p class="clearfix">
                          <span class="float-left">
                            <b>Application No</b>
                          </span>
                          <span class="float-right text-muted">
                          <?= $transdetail->appno; ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            <b>Fullnames</b>
                          </span>
                          <span class="float-right text-muted">
                            <?= $transdetail->fullnames; ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            <b>Transaction ID</b>
                          </span>
                          <span class="float-right text-muted">
                            <?= $transdetail->trans_no; ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            <b>RRR</b>
                          </span>
                          <span class="float-right text-muted">
                            <b> <?= $transdetail->rrr; ?> </b>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            <b>Session</b>
                          </span>
                          <span class="float-right text-muted">
                           <?= $transdetail->trans_year; ?> / <?= $transdetail->trans_year+1; ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            <b>Transaction Date</b>
                          </span>
                          <span class="float-right text-muted">
                             <?= date('d-M-Y h:i:s', strtotime($transdetail->trans_date)); ?>
                          </span>
                        </p>
                      </div>



                         </div>

                       </div>
                     </div>

                       <div class="col-md-12">
                         <div class="section-title">Payment Details</div>

                         <div class="table-responsive">
                           <table class="table table-striped table-hover table-md">
                             <tr>
                               <th data-width="40">#</th>
                               <th>Fee Item</th>
                               <th class="text-center">Amount</th>

                               <th class="text-right">Total</th>
                             </tr>
                             <tr>
                               <td>1</td>
                               <td><?= $transdetail->fee_name; ?></td>
                               <td class="text-center">&#8358; <?= number_format($transdetail->fee_amount); ?> </td>

                               <td class="text-right">&#8358; <?= number_format($transdetail->fee_amount); ?> </td>
                             </tr>


                           </table>
                         </div>
                         <div class="row mt-4">
                           <div class="col-lg-8">
                             <div class="section-title">Payment Method</div>
                             <p class="section-lead">You can make payment at  Any  Bank Branch Nationwide  or via www.remita.net with RRR: <b> <?= $transdetail->rrr; ?> </b></p>

                           </div>


                             <hr class="mt-2 mb-2">
                             <div class="invoice-detail-item">
                               <div class="invoice-detail-name">Total</div>
                               <div class="invoice-detail-value invoice-detail-value-lg">&#8358; <?= number_format($transdetail->fee_amount); ?> </div>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>

                   <hr>
                    <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
                 </div>
               <?php endforeach; ?>
                                                 <?php endif; ?>

               </div>
