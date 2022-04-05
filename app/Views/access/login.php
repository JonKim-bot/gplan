    <div class="col-md-12 ">

        <!-- <img src="https://carlink.my/static/media/Logo%203D%20Png.8b5ebdda.png" style="margin-bottom:20px" width="100%" alt=""> -->

        <div class="loginHeader_div">
            <h1>Nsjrw</h1>
            <hr>
        </div>
        <form method="POST" action="<?= base_url() ?>/access/login">
            <?php if (isset($error)) { ?>
                <div class="alert-message text-center" role="alert">
                    <?= $error ?>
                </div>
            <?php } ?>
            <div class="loginForm_div">
                <p class="formLabel">Username</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="cil-user c-icon"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" name="username" placeholder="Username">
                </div>

                <p class="formLabel">Password</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="cil-lock-locked c-icon"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                </div>
                <!-- <div class="theForgot">
                    <p>Forget Password ?</p>
                </div> -->
            </div>

            <div class="login_divbtn">
                <button class="login_btn" type="submit">Sign In</button>
                <!-- <p class="text-white">Not a member? <a class="login_text" href="<?= base_url() ?>/access/login"> Register Here</a></p> -->
            </div>
        </form>
        <!-- <div class="card-group">

            <div class="card p-4">
                <div class="card-body">

                    <div class="" style="display:flex;">
                        <h5 class="text-muted">Nsjrw Admin Panel</h5>
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
                            <div class="alert-message" role="alert">
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

    </div> -->
    </div>