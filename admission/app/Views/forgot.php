<div class="card card-primary">
  <div class="card-header">
    <h4>Forgot Password</h4>
  </div>
  <div class="card-body">
    <p class="text-muted">We will send a link to reset your password</p>
    <?php if (session()->getFlashdata('error')) : ?>
      <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>
    <form id="app_login" name="app_login" action="<?= base_url('account/forgetpass'); ?>" method="post">
      <div class="form-group">
        <label for="email">Application Number</label>
        <input id="email" type="text" class="form-control" name="regno" tabindex="1" required autofocus autocomplete="off">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
          Reset Password
        </button>
      </div>
    </form>
    <div class="float-right">
      <a href="<?= base_url(); ?>"> <strong> &lt;&lt; Back to Home</strong> </a>


    </div>
  </div>
</div>

<div class="simple-footer">
  Copyright &copy; DSPG
</div>