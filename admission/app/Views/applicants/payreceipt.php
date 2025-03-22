      <!-- Main Content -->
      <div class="main-content">
      	<section class="section">

      		<ul class="breadcrumb breadcrumb-style">
      			<li class="breadcrumb-item">

      				<h4 class="page-title m-b-0">Payment Receipt</h4>
      			</li>
      			<li class="breadcrumb-item">
      				<a href="<?= base_url('applicant'); ?>">
      					<i class="fas fa-home"></i></a>
      			</li>
      			<li class="breadcrumb-item active">Dashboard</li>
      		</ul>

      		<div class="col-md-9 col-xl-12">
      			<div class="tab-content">
      				<div class="tab-pane fade show active" id="payslip" role="tabpanel">

      					

      						<?php if (isset($paydetails)) : ?>
      							<?php foreach ($paydetails as $paydetail) : ?>

      								<div class="card"><br />

      									<div align="center">
      										<img src="<?= base_url('assets/img/logo.png'); ?>" alt="dspg" width="120" height="131">
      										<br>
      										</h3>
      										<br>

      										<strong style="font-size:18px"> <u><?= $paydetail->fee_name; ?> - Payment Receipt</u> </strong>
      									</div>

      									<div class="card-body">
      										<h5 class="card-title mb-0"><strong>APPLICANT'S PAYMENT INFORMATION</strong></h5>
      										<hr>

      										<table class="table table-bordered">

      											<tbody>
      												<tr>
      													<td><strong>Application No:</strong></td>
      													<td><span class="mb-3">
      															<?= $paydetail->appno; ?>
      														</span></td>
      													<td rowspan="3">

      														<img alt="Photo" src="<?= $path; ?>" class="rounded-circle img-responsive mt-3" width="135" height="131" />

      													</td>
      												</tr>
      												<tr>
      													<td><strong>Fullnames:</strong></td>
      													<td><strong>
      															<?= $paydetail->fullnames; ?>
      														</strong></td>
      												</tr>
      												<tr>
      													<td><strong>Fee Name:</strong></td>
      													<td><span class="mb-3">
      															<?= $paydetail->fee_name; ?>
      														</span></td>
      												</tr>
      												<tr>
      													<td><span class="mb-3">
      															<label class="form-label" for="inputUsername7"><strong>Transaction ID:</strong></label>
      														</span></td>
      													<td colspan="2"><span class="mb-3">
      															<?= $paydetail->trans_no; ?>
      														</span></td>
      												</tr>
      												<tr>
      													<td><span class="mb-3">
      															<label class="form-label" for="inputUsername2"><strong>Session:</strong></label>
      														</span></td>
      													<td colspan="2"><span class="mb-3">
      															<label class="form-label" for="inputUsername9"><strong></strong></label>
      															<?= $paydetail->trans_year; ?> / <?= $paydetail->trans_year + 1; ?>
      														</span></td>
      												</tr>
      												<tr>
      													<td><span class="mb-3">
      															<label class="form-label" for="inputUsername3"><strong>Amount:</strong></label>
      														</span></td>
      													<td colspan="2"><span class="mb-3">&#8358;
      															<?= number_format($paydetail->fee_amount); ?>
      														</span></td>
      												</tr>


      												<tr>
      													<td><span class="mb-3">
      															<label class="form-label" for="inputUsername6"><strong>Date:</strong></label>
      														</span></td>
      													<td colspan="2"><span class="mb-3">
      															<?= $pt_date  = date("d-M-Y", strtotime($paydetail->t_date)); ?>
      														</span></td>
      												</tr>
      												<tr>
      													<td><span class="mb-3">
      															<label class="form-label" for="inputUsername8"><strong>STATUS:</strong></label>
      														</span></td>
      													<td colspan="2"><span class="mb-3">
      															<strong>
      																<?= strtoupper($paydetail->trans_custom1); ?>
      															</strong> </span></td>
      												</tr>
      											</tbody>
      										</table>

	<a href="<?= base_url('applicant/print_receipt/'.$paydetail->trans_no) ?>" class="btn btn-primary" target ='_blank'>Print Payment Receipt</a>


      									</div>
      								</div>
      								<p style="page-break-after: always;">&nbsp;</p>
      							<?php endforeach; ?>
      						<?php endif; ?>
      					</div>
      			


      				



      			</div>
      		</div>
      	