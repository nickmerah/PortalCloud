<div class="card card-primary">
  <div class="card-header">
    <h4>Login</h4>

  </div>
  <div class="card-body">
    <?php if (session()->getFlashdata('error')) : ?>
      <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
      <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>


    <div class="float-right">
      <a href="<?= base_url('home/startpart'); ?>"> <strong> New Registration? Begin Here</strong> </a>


    </div>

    <form method="POST" action="<?= base_url('account/login'); ?>" class="needs-validation" novalidate="" autocomplete="off">
      <?= csrf_field() ?>
      <div class="form-group">
        <label for="email"> Application Number</label>
        <input id="email" type="text" class="form-control" name="email" tabindex="1" required autofocus maxlength="15" minlength="4">
        <div class="invalid-feedback">
          Please fill in your corrent Application No
        </div>
      </div>
      <div class="form-group">
        <div class="d-block">
          <label for="password" class="control-label">Password</label>
          <div class="float-right">
            <a href="<?= base_url('home/fpass'); ?>"> <strong> Forgot Passport?</strong> </a>
          </div>
        </div>
        <input id="password" type="password" class="form-control" name="passkey" minlength="4" tabindex="2" required>
        <div class="invalid-feedback">
          please fill in your password of atleast 4 characters
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
          Login
        </button>
      </div>
      <div class="mt-1 text-muted text-center">
        <div align="center" class="example5">
          <marquee> <?= $marquee; ?> </marquee>
        </div>
        <div align="center">
          <p id="demo" style="text-align:center; font-weight:bold; font-size: 16px;color:red"> </p>
        </div>
      </div>
    </form>


  </div>
</div>

</div>
</div>
</div>