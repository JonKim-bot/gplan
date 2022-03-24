<div class="col-md-12 ">
    <!-- <img src="https://carlink.my/static/media/Logo%203D%20Png.8b5ebdda.png" style="margin-bottom:20px" width="100%" alt=""> -->
    <!-- <div class="card-group"> -->
    <div class='text-center text-white register_title'>
        <h1>Gplan</h1>
        <h3>Register</h3>
        <p>Register Your account here</p>
    </div>

    <form method="POST" action="<?= base_url() . "/main/add/" . $family_id . '/' . $uid; ?>">
        <?php if (isset($error)) { ?>
            <div class="alert-message" role="alert">
                <?= $error ?>
            </div>
        <?php } ?>
        <div class="registerForm_div">
            <p class="formLabel">Name</p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cil-user c-icon"></i>
                    </span>
                </div>
                <input class="form-control" type="text" require name="name">
            </div>

            <p class="formLabel">Contact</p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cil-phone c-icon"></i>
                    </span>
                </div>
                <input class="form-control" type="number" require name="contact">
            </div>

            <p class="formLabel">Email</p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cib-gmail c-icon"></i>
                    </span>
                </div>
                <input class="form-control" type="email" require name="email">
            </div>
            <p class="formLabel">Delivery Address</p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cib-gmail c-icon"></i>
                    </span>
                </div>
                <input class="form-control" type="text" require name="delivery_address">
            </div>

            <div class="text-center text-white register_personal">
                <h3>Personal Login Detail</h3>
                <p>Enter your account detail here</p>
            </div>

            <p class="formLabel">Username</p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cil-user c-icon"></i>
                    </span>
                </div>
                <input class="form-control" type="text" require name="username">
            </div>

            <p class="formLabel">Password</p>
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cil-lock-locked c-icon"></i>
                    </span>
                </div>
                <input class="form-control" type="password" require name="password">
            </div>

            <p class="formLabel">Confirm Password</p>
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cil-lock-locked c-icon"></i>
                    </span>
                </div>
                <input class="form-control" require type="password" name="password2">
            </div>
        </div>



        <!-- <div class="text-center text-white">
                <h3>Register</h3>
                <p>Register Your account here</p>
            </div>
            <div class="text-center bank-info text-white">
                <p style="margin-top:1rem">Register Your account here</p>
                <p>Register Your account here</p>

                <p>Register Your account here</p>
            </div> -->

        <!-- <div class="form-group">
                <label for="">Profile Picture</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile02">
                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                </div>
            </div>
                       
             -->



        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-dark theBtn_register text-white " type="submit">SIGN UP</button>
            </div>
        </div>
    </form>
    <!-- <div class="card p-4">
            <div class="card-body">
                
                <div class="" style="display:flex;">
                    <h5 class="text-muted">Gplan Admin Panel</h5>
                    <ul class="c-header-nav mfs-auto rm-flex">
                        <li class="c-header-nav-item c-d-legacy-none">
                            <button class="c-class-toggler c-header-nav-btn" type="button" id="header-tooltip" data-target="body" data-class="c-dark-theme" data-toggle="c-tooltip" data-placement="bottom" title="" data-original-title="Toggle Light/Dark Mode" aria-describedby="tooltip615585">
                            <i class="cil-moon c-icon c-d-dark-none"></i>
                            <i class="cil-sun c-icon c-d-default-none"></i>
                            </button>
                        </li>
                    </ul>
                </div>
                <br>
                <form method="POST" action="<?= base_url() ?>/access/login">
                    <?php if (isset($error)) { ?>
                        <div class="alert-message"  role="alert">
                            <?= $error ?>						
                        </div>
                    <?php } ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="cil-user c-icon"></i>
                            </span>
                        </div>
                        <input class="form-control" type="text" name="username" placeholder="Username">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="cil-lock-locked c-icon"></i>
                            </span>
                        </div>
                        <input class="form-control" type="password" name="password" placeholder="Password">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary px-4 w-100" type="submit">SIGN IN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
         -->
    <!-- </div> -->
</div>