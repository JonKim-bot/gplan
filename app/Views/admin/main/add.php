    
<style>
</style>
<div class="col-md-6 " style="margin:70px 0px 70px 0px">
    <!-- <img src="https://carlink.my/static/media/Logo%203D%20Png.8b5ebdda.png" style="margin-bottom:20px" width="100%" alt=""> -->
<!-- <div class="card-group"> -->
        <div class='text-center text-white'>
            <h1>Gplan</h1>
        </div>

        <div class="text-center text-white">
            <h3>Register</h3>
            <p>Register Your account here</p>
        </div>

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
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cil-lock-locked c-icon"></i>
                    </span>
                </div>
                <input class="form-control" type="password" name="password" placeholder="Password">
            </div>
            <div class="text-center text-white">
                <h3>Personal Detail</h3>
                <p>Enter your personal detail here</p>
            </div>
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
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cil-lock-locked c-icon"></i>
                    </span>
                </div>
                <input class="form-control" type="password" name="password" placeholder="Password">
            </div>

            <div class="text-center text-white">
                <h3>Register</h3>
                <p>Register Your account here</p>
            </div>
            <div class="text-center bank-info text-white">
                <p style="margin-top:1rem">Register Your account here</p>
                <p>Register Your account here</p>

                <p>Register Your account here</p>
            </div>

            <div class="form-group">
                <label for="">Profile Picture</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile02">
                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                </div>
            </div>
                       
            
            
            
            
            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-dark btn_register text-white " type="submit">SIGN IN</button>
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

