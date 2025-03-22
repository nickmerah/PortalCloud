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

              <?php

                               if ( $pstat  == 1){
                                 $fstat = "<b style='color:green'>PAID</b>";
                                 $paybutton = "<button type='button' class='btn btn-danger btn-icon icon-left'><i class='fas fa-credit-card'></i> PAYMENT ALREADY MADE</button>";

                               }else{
                                 $fstat = "<b style='color:red'>NOT PAID</b>";
                                 $paybutton = "<button  type='submit' class='btn btn-success btn-icon icon-left'><i class='fas fa-credit-card'></i> PAY NOW</button>";



                               }


                               ?>
               <?php if(isset($stddetails)): ?>
                  <?php foreach($stddetails as $stddetail): ?>

              <div class="invoice">
                   <div class="invoice-print">
                     <div class="row">
                       <div class="col-lg-12">
                         <div class="invoice-title">
                           <h2>e-Invoice - <?= $fstat; ?></h2>

                         </div>
                         <hr>
                         <div class="row">
                           <div class="col-md-6">
                             <address>
                               <strong>Billed To:</strong><br>
                               <strong>  <?= $stddetail->surname; ?></strong>, <?= $stddetail->firstname; ?> <?= $stddetail->othernames; ?><br>
                               <?= $stddetail->jambno; ?> <br>
                                <?= $stddetail->aprogramme_name; ?> <?= $stddetail->programme_option; ?><br>
                               <?= $cs_session; ?> / <?= $cs_session+1; ?> Session
                             </address>
                           </div>
                           <div class="col-md-6 text-md-right">
                             <address>
                               <strong>From:</strong><br>
                               Delta State Polytechnic, Ogwashi-Uku<br>
                               
                               Delta State<br>

                             </address>
                           </div>
                         </div>
                         <div class="row">
                           <div class="col-md-6">
                             <address>
                               <strong>Order Date:</strong><br>
                              <?= date ('d M Y h:i:s'); ?>
                             </address>
                           </div>

                         </div>
                       </div>
                     </div>
                     <div class="row mt-4">
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
                               <td>Application Form Fee</td>
                               <td class="text-center">&#8358; <?=  number_format($appfees) ;?></td>

                               <td class="text-right">&#8358; <?=  number_format($appfees) ;?></td>
                             </tr>


                           </table>
                         </div>
                         <div class="row mt-4">
                           <div class="col-lg-8">
                             <div class="section-title">Payment Method</div>
                             <p class="section-lead">The payment method that we provide is to make it easier for you to pay
                               e-invoices.</p>
                              
                           </div>


                             <hr class="mt-2 mb-2">
                             <div class="invoice-detail-item">
                               <div class="invoice-detail-name">Total</div>
                               <div class="invoice-detail-value invoice-detail-value-lg">&#8358; <?=  number_format($appfees) ;?></div>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
                   <hr>
                   <form  id="pay_now" name="pay_now"
    action="<?= base_url('applicant/paynow');?>" method="post">
											<?= csrf_field() ?>

                   <div class="text-md-right">
                     <div class="float-lg-left mb-lg-0 mb-3">
                       <?= $paybutton; ?>

                     </div>

                   </div>
                   </form>
                 </div>
               <?php endforeach; ?>
                                                 <?php endif; ?>

               </div>
