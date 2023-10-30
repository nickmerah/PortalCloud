<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $title; ?></title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url('assets/css/app.min.css');?>">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css');?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css');?>">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css');?>">
  <style> 
 .moving-text:hover{
 animation-play-state: paused;
 }

 @keyframes marquee{
 0%{transform: translateX(100%);}
 100%{transform: translateX(-100%);}
 }
 
 @media (prefers-reduced-motion: no-preference) {
 .moving-text{
 animation: marquee 15s linear infinite;
 }
}
 </style>
</head>

<body style="background-color: white">
  
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>

                                  <h2> The Oke-Ogun Polytechnic, Saki</h2>

          </ul>
        </div>
     
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?= base_url();?>"> <img alt="image" src="<?= base_url('assets/img/logo.jpg');?>" class="header-logo" /> <span
                class="logo-name">TOPS  </span>
            </a>
          </div>
          <div class="sidebar-user">

            <div class="sidebar-user-details">
              <div class="user-name">APPLICATION PORTAL </div>

            </div>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">MENU</li>
              <li><a class="nav-link" href="<?= base_url('applicant/');?>"><i data-feather="monitor"></i><span>Home</span></a></li>
                
 
                   
          </ul>
        </aside>
      </div>
      <div class="main-content">
            <section class="section" >

            

              <div class="col-md-9 col-xl-12">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="payslip" role="tabpanel">
								    
		<div id="printableArea">						    
								    
								    <?php if(isset($paydetails)): ?>
                                                <?php foreach($paydetails as $paydetail): ?>

									<div class="card"><br />

                    <div align="center">
            <img src="<?= base_url('assets/img/logo.jpg');?>" alt="tops" width="102" height="103">
             <br> <strong style="font-size:20px"> The Oke-Ogun Polytechnic, Saki</strong> <br>
  </h3>
        <br>

        <strong style="font-size:18px"> <u><?= $paydetail->fee_name; ?> - Payment Receipt</u>  </strong>
</div>

									  <div class="card-body">
											 	
                                                 <strong style="font-size:14px"> APPLICANT'S PAYMENT  DETAILS  </strong>	 
                                              <table class="table table-bordered">

									<tbody>
									    <tr>
										      <td><strong>UTME No:</strong></td>
										      <td><span class="mb-3">
										        <?= $appno; ?>
										      </span></td>
									        <td rowspan="4">
										        
										        
										        <?php 

                                               
												$picurl = "http://student.tops.edu.ng:82/portal/supportadmin/jambphoto/"; 
											 	 $filename =   $picurl.$stdphoto; 
											  $chkimg = 	\App\Controllers\Applicant::getValidUrl($filename); 
												                     
                                                                            
                                                                            
                                                                            if ($chkimg != 0) { ?>
										        <img alt="Photo" src="<?=  $filename;?>"  width="135" height="131" />
										        <?php }else { ?>
										        <img alt="Photo" src="<?= base_url('public/uploads/avatar.jpg');?>" width="40" height="40" />
										        
										        <?php } ?>
										        
										        
										        
										        
								            </td>
								      </tr>
									    <tr>
											<td><strong>Application No:</strong></td>
											<td><span class="mb-3">
											  <?= $paydetail->appno; ?>
											</span></td>
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
										    <label class="form-label" for="inputUsername7"><strong>RRR:</strong></label>
										  </span></td>
										  <td colspan="2"><span class="mb-3">
										    <?= $paydetail->rrr; ?>
										  </span></td>
									  </tr>
                                      <tr>
										  <td><span class="mb-3">
										    <label class="form-label" for="inputUsername7"><strong>TransID:</strong></label>
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
                                              <?= $paydetail->trans_year; ?>
/
<?= $paydetail->trans_year+1; ?>
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
									      </strong>										  </span></td>
									  </tr>
										</tbody>
								</table>


                                          








									  </div>
									</div> 
  <?php endforeach; ?>
                                                     <?php endif; ?>   </div>
		 

								</div>



							</div>
						</div> 
