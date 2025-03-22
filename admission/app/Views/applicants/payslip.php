      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

          <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">

              <h4 class="page-title m-b-0">e-Invoice</h4>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('applicant'); ?>">
                <i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ul>


          <?php if (isset($transdetails)) : 
          
           $transdetail = $transdetails[0];
          ?>
         

              <div class="invoice">
                <div class="invoice-print">

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="invoice-title">
                        <h2>e-Invoice - <?= $transdetail->trans_custom1; ?></h2>

                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-6">
                          <address>
                            <strong>Billed To:</strong><br>
                            <strong> <?= $transdetail->fullnames; ?></strong><br>
                            <?= $transdetail->appno; ?> <br>
                            RRR: <b> <?= $transdetail->rrr; ?> </b><br>
                            <?= $transdetail->trans_year; ?> / <?= $transdetail->trans_year + 1; ?> Session
                          </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                          <address>
                            <strong>From:</strong><br>
                            <?= $schoolname; ?><br>
                          </address>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <address>
                            <strong>Generated Date:</strong><br>
                            <?= date('d-M-Y H:i:s', strtotime($transdetail->trans_date)); ?>
                          </address>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="section-title">Payment Details</div>

                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tr>
                        
                          <th>Fee Item</th>
                          <th class="text-center">Amount</th>

                          <th class="text-right">Total</th>
                        </tr>
                        
                        <?php $total = 0; 
                        
                        foreach ($transdetails as $tdetails) {
                        $total += $tdetails->fee_amount;
                        
                        ?>
                        <tr>
                         
                          <td><?= $tdetails->fee_name; ?></td>
                          <td class="text-center">&#8358; <?= number_format($tdetails->fee_amount); ?> </td>

                          <td class="text-right">&#8358; <?= number_format($tdetails->fee_amount); ?> </td>
                        </tr>

 <?php } ?>
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title"></div>
                        <p class="section-lead">

                          <img src="<?= base_url('assets/img/cards/remita.png'); ?>" alt="remita" class="center" />

                          <a href="<?= base_url('applicant/makepayment/' . $transdetail->rrr); ?>" class="btn btn-success btn-icon icon-left">
                            PAY NOW with your ATM Card </a>

                        </p>

                      </div>


                      <hr class="mt-2 mb-2">
                      <div class="invoice-detail-item">
                        <div class="invoice-detail-name">Total</div>
                        <div class="invoice-detail-value invoice-detail-value-lg">&#8358; <?= number_format($total); ?> </div>
                      </div>
                      <hr class="mt-2 mb-2">
                      <?php /*<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Notice:</strong> We noticed that the Remita platform is currently experiencing some issues. You should be able to make payments once the issue is resolved.

                      </div> */ ?>
                    </div>
                  </div>
                </div>
              </div>

              <hr>

      </div>
  
      <?php endif; ?>

      </div>