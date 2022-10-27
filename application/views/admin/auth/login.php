<form action="<?php echo $template['form']['action'];?>" method="post" id="frm_login" name="frm_login">
    <div class="form-group position-relative has-icon-left mb-4 mandatory <?php echo  form_error('username') ?'is-invalid' : '' ?>">
        <input type="text" class="form-control form-control-xl" placeholder="Username" name="username" id="username" value="<?php echo set_value('username');?>" required>
        <div class="form-control-icon">
            <i class="bi bi-person"></i>
        </div>
        <!-- <div class="parsley-error filled" id="parsley-id-15" aria-hidden="false"><span class="parsley-required">Email is required.</span></div> -->
    <?php 
        echo form_error('username');
    ?>
    </div>
  
    <div class="form-group position-relative has-icon-left mb-4 mandatory <?php echo  form_error('password') ?'is-invalid' : '' ?>">
        <input type="password" class="form-control form-control-xl" placeholder="Password" name="password" id="password" value="<?php echo set_value('password');?>" required>
        <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
    <?php 
        echo form_error('password');
    ?>
    </div>
    <!-- <div class="form-check form-check-lg d-flex align-items-end">
        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
        <label class="form-check-label text-gray-600" for="flexCheckDefault">
            Keep me logged in
        </label>
    </div> -->
    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
</form>
<div class="text-center mt-5 text-lg fs-4">
    <p class="text-gray-600">Don't have an account? <a href="auth-register.html" class="font-bold">Sign
            up</a>.</p>
    <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p>
</div>