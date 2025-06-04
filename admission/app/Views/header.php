<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo isset($title) ? $title : "DPSG" ?></title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url('assets/css/app.min.css'); ?>">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css'); ?>">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
  <style>
    .example5 {


      font-size: 15px;
      font-weight: bold;
      color: #00F
    }
  </style>
</head>

<body>

  <div id="app">
    <section class="section">
      <div class="container mt-0">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
            <div class="login-brand">



              <div align="center">
                <a href="<?= base_url(); ?>">
                  <picture>
                    <source media="(max-width: 799px)" srcset="<?= base_url('assets/img/delta.png'); ?>">
                    <source media="(min-width: 800px)" srcset="<?= base_url('assets/img/delta.png'); ?>">
                    <img src="<?= base_url('assets/img/delta.png'); ?>" alt="School Logo" class="responsive-img valign profile-image-login">
                  </picture>

                </a>
              </div>

            </div>