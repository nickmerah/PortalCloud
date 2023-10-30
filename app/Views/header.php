<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo isset($title)?$title:"TOPS"?> </title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url('assets/css/app.min.css');?>">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css');?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css');?>">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css');?>">

<style>

.example5 {


 font-size:18px;
 font-weight:bold;

}



</style>
</head>

<body>

  <div id="app">
    <div class="main-wrapper">


      <!-- Main Content -->

            <div class="main">
              <section class="section">


                 <div class="row">
                    <div class="col-12">

                      <div class="card">
                        <div class="card-header">
      <div align = "center">
                          <h1><img src="<?= base_url('assets/img/logo.jpg');?>" alt="School Logo" width="100" height="100" class="responsive-img valign profile-image-login"> The Oke-Ogun Polytechnic, Saki</h1> </div>
                        </div>
                        <div class="card-body">
                          <nav class="navbar navbar-expand-lg bg-success">
                            <a class="navbar-brand" href="<?= base_url();?>">APPLICATION PORTAL</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                              <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                              <ul class="navbar-nav">
                                <li class="nav-item active">
                                  <a class="nav-link" href="<?= base_url();?>">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <?php /*
                                <li class="nav-item">
                                  <a class="nav-link" href="<?= base_url('home/startup');?>">Fulltime Application</a>
                                </li>
                                
                                 <li class="nav-item">
                                  <a class="nav-link" href="<?php // base_url('home/startpart');?>">Parttime Application</a>
                                </li>*/ ?>
                                <li class="nav-item">
                                  <a class="nav-link" href="<?= base_url('home/admreq');?>">Admission Requirement</a>
                                </li>
                                 

                                <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('home/contactus');?>">Contact Us</a>
                              </li>
                              </ul>
                            </div>
                          </nav>
                        </div>
                      </div>
                    </div>
                    </div>
