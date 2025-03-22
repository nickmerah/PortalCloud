<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $title; ?></title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url('assets/css/app.min.css'); ?>">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css'); ?>">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
  <style>
    .marquee-container {
      background-color: darkgreen; 
      color: white;
      padding: 10px;
      font-size: 18px;
      overflow: hidden;
      white-space: nowrap;
      position: relative;
    }

    .marquee {
      display: inline-block;
      animation: marquee 20s linear infinite;
    }

    @keyframes marquee {
      from {
        transform: translateX(100%);
      }

      to {
        transform: translateX(-100%);
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

            <h3> <?= $schoolname; ?></h3>

          </ul>
        </div>
        <ul class="navbar-nav navbar-right">


          <li class="dropdown"> <strong> <?= $appno; ?></strong> </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?= base_url('applicant'); ?>"> <img alt="image" src="<?= base_url('assets/img/logo.png'); ?>" class="header-logo" /> <span class="logo-name">DSPG </span>
            </a>
          </div>
          <div class="sidebar-user">

            <div class="sidebar-user-details">
              <div class="user-name">ADMISSION PORTAL </div>

            </div>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">MENU</li>
            <li><a class="nav-link" href="<?= base_url('applicant/'); ?>"><i data-feather="monitor"></i><span>Home</span></a></li>
            <li><a class="nav-link" href="<?= base_url('applicant/my_application'); ?>"><i data-feather="monitor"></i><span>My Application</span></a></li>
            <li><a class="nav-link" href="<?= base_url('applicant/application_forms'); ?>"><i data-feather="download"></i><span>Application Forms</span></a></li>
         

            <?php if ($admstatus) { ?>

              <li><a class="nav-link" href="<?= base_url('applicant/afee'); ?>"><i data-feather="dollar-sign"></i><span>Pay Acceptance Fee</span></a></li>
                <li><a class="nav-link" href="<?= base_url('applicant/cfee'); ?>"><i data-feather="dollar-sign"></i><span>Pay Change of Course</span></a></li>
              
               <?php 
                
               if($acceptfeestatus) { ?>
             <li><a class="nav-link" href="<?= base_url('applicant/vfee'); ?>"><i data-feather="dollar-sign"></i><span> Pay Result Verification</span></a></li>
            <?php } ?>
            
             <?php 
                
               if($resultverifyfeestatus) { ?>
             <li><a class="nav-link" href="<?= base_url('applicant/resultupload'); ?>"><i data-feather="upload"></i><span> Upload Results</span></a></li>
            <?php } ?>
            
            
            <?php } ?>
            
            
           

         
            <li><a class="nav-link" href="<?= base_url('applicant/checkpayment'); ?>"><i data-feather="check"></i><span>Check Payment</span></a></li>
             <li><a class="nav-link" href="<?= base_url('applicant/phistory'); ?>"><i data-feather="dollar-sign"></i><span>Payment History</span></a></li>
            <li><a class="nav-link" href="<?= base_url('applicant/logout'); ?>"><i data-feather="log-out"></i><span>Logout</span></a></li>


          </ul>
        </aside>
      </div>
      <!-- Main Content -->