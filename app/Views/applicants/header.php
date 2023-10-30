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
  <div class="loader"></div>
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
        <ul class="navbar-nav navbar-right">


        <li class="dropdown">  <strong><?= $fnames;?> - <?= $appno; ?></strong>  </li>
        </ul>
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
                <li><a class="nav-link" href="<?= base_url('applicant/my_application');?>"><i data-feather="monitor"></i><span>My Application</span></a></li>
                  <li><a class="nav-link" href="<?= base_url('applicant/application_forms');?>"><i data-feather="download"></i><span>Application Forms</span></a></li>
                  
                  <?php if($appstatus) { 
                    
                    // base_url('applicant/screening')
                    ?>
                  <li><a class="nav-link" href=<?=  base_url('applicant/screening');?>><i data-feather="user-check"></i><span>Screening</span></a></li>
                  
                  <?php } if($admstatus) { ?>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>Admission Panel</span></a>
              <ul class="dropdown-menu">
              <li><a class="nav-link" href="<?= base_url('applicant/admletter');?>"><i data-feather="file"></i><span>Admission Letter</span></a></li>
              <li><a class="nav-link" href="<?= base_url('applicant/afee');?>"><i data-feather="dollar-sign"></i><span>Pay Acceptance Fee</span></a></li>
               
                
              </ul>
            </li>

                  
                   
                    <?php } ?>
                    
                    <?php   if($convert) { ?>
                  
                   <li><a class="nav-link" href="<?= base_url('applicant/cfee');?>"><i data-feather="dollar-sign"></i><span>Pay Conversion Fee</span></a></li>
                    <?php } ?>
                    <li><a class="nav-link" href="<?= base_url('applicant/aphistory');?>">  <i data-feather="check"></i><span>Check Payment</span></a></li>
                    <li><a class="nav-link" href="<?= base_url('applicant/phistory');?>"><i data-feather="dollar-sign"></i><span>  Fee Payment</span></a></li>
                        <li><a class="nav-link" href="<?= base_url('applicant/logout');?>"><i data-feather="log-out"></i><span>Logout</span></a></li>


          </ul>
        </aside>
      </div>
      <!-- Main Content -->
