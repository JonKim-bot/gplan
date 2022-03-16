<style>
  .text-value-lg {
    font-size: 2.3rem;
  }

  .card-status {
    height: auto
  }

  .c-withButton {
    background-color: #000;
    border-radius: 5px;
    width: 127px;
    height: 37px;
  }

  .c-shadow {
    -webkit-box-shadow: 0px 3px 18px #0000004D !important;
    box-shadow: 0px 3px 18px #0000004D !important;
  }

  .c-QR {
    width: 60%;
    margin: 0 auto;
    padding: 20px 0;
  }

  .c-QR img {
    width: 100%;
  }

  .c-body {
    position: relative;
    max-width: 100%;
    /* min-height: 787px; */
    margin: 0 auto;
    background-color: #fff;
    justify-content: center;
    overflow: hidden;
  }

  .c-carousel {
    position: relative;
    width: 100%;
    margin: 0 auto;
  }

  .c-carousel .c-carouselimg {
    position: relative;
    width: 100%;
  }

  @media screen and (min-width: 768px) {
    .c-carousel .c-carouselimg {
      width: 100%;
    }
  }

  .c-carousel .c-carouselimg img {
    width: 100%;
    object-fit: cover;
  }
</style>
<!-- <div class="c-subheader px-3">
  <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item"><a href="#">Admin</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
</div> -->

</header>

<div class="">
  <main class="c-main c-dashboard">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="theHeader">
          <div style="width: 10%;">
            <a href="<?= base_url() ?>/access/logout">
              <i class="fa fa-arrow-left fa-2x text-dark" aria-hidden="true"></i>
            </a>
          </div>
          <div class="theHeaderName">
            <h3>
              Hello <?= $users['username'] ?>
            </h3>
            <div class="theIcon">
              <img src="<?= base_url() ?>/assets/img/Octicons.png">
            </div>
          </div>
          <div class="theHeaderDrop">
            <a href="<?= base_url() ?>/users/user_detail/1">
              <div class="theIcon">
                <img src="<?= base_url() ?>/assets/img/Group 170.png">
              </div>
            </a>

            <!-- <div class="theHeaderDrop-content">
              <a href="<?= base_url() ?>/access/logout">Logout</a>
            </div> -->
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-lg-12">
            <div class="card text-white theGradient">
              <div class="card-status card-body card-body">
                <div>
                  <div class="thLabel"> <?= $lang['your_point'] ?></div>
                  <div class="thBalance">
                    <h1>
                      MYR <?= $balance ?>
                    </h1>
                  </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">

                  <div class="py-1 ">
                    <a href="<?= base_url() ?>/Wallet/transaction" style="color:white">

                      <p class="m-0 thLabel">
                        <?= $lang['total_earn_amount'] ?> : <?= $total_earn ?>
                      </p>
                    </a>
                  </div>
                  <div class="py-1">
                    <a href="<?= base_url() ?>/Wallet/transaction" style="color:white">

                      <p class="m-0 thLabel">
                        <?= $lang['withdraw_amount'] ?> : <?= $total_withdraw ?>
                      </p>
                    </a>
                  </div>


                </div>
                <?php if ($users['is_verified'] == 1) { ?>

                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="c-withButton d-flex justify-content-center align-items-center py-1 px-3 br-3">
                      <div class="theBIcon mr-2">
                        <img src="<?= base_url() ?>/assets/img/Layer 25.png">
                      </div>
                      <a href="<?= base_url() ?>/Withdraw/withdraw" style="color:white">

                        <p class="m-0 theBLabel">
                          <?= $lang['withdraw'] ?>
                        </p>
                      </a>
                    </div>
                    <div class="py-1 px-3 br-3 ">
                      <a href="<?= base_url() ?>/Wallet/transaction" style="color:white">

                        <p class="m-0 thLabel">
                          <?= $lang['transaction_history'] ?> >
                        </p>
                      </a>
                    </div>

                  </div>
                <?php } ?>

                <?php if ($users['is_verified'] == 1) { ?>

                  <div class="d-flex justify-content-between align-items-center">
                    <div class="c-withButton d-flex justify-content-center align-items-center py-1 px-3 br-3">
                      <div class="theBIcon mr-2">
                        <img src="<?= base_url() ?>/assets/img/Path 26.png">
                      </div>
                      <a href="<?= base_url() ?>/Users/my_group" style="color:white">

                        <p class="m-0 theBLabel">
                          <?= $lang['my_group'] ?>
                        </p>
                      </a>
                    </div>



                  </div>

                <?php } ?>

              </div>
              <!-- <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"> -->
              <!-- <canvas class="chart" id="card-chart1" height="70"></canvas> -->
              <!-- </div> -->
            </div>
          </div>
          <!-- /.col-->
          <div class="col-sm-12 col-lg-12 mb-4 ">
            <div class="theCFlex">
              <a class="c-Circle card-header-action" class="btn btn-primary" data-toggle="modal" data-target="#status_modal">
                <div class="theBIcon">
                  <img src="<?= base_url() ?>/assets/img/Artboard.png">
                </div>
                <p class="m-0">
                  <?= $lang['status'] ?>
                </p>
              </a>
              <?php if ($users['is_verified'] == 0) { ?>
                <a class="c-Circle card-header-action" class="btn btn-primary" data-toggle="modal" data-target="#family_tree">
                <?php  } else { ?>
                  <a class="c-Circle card-header-action" class="btn btn-primary" href="<?= base_url() ?>/users/family_tree/1">
                  <?php } ?>
                  <div class="theBIcon">
                    <img src="<?= base_url() ?>/assets/img/Layer_1.png">
                  </div>
                  <p class="m-0">
                    <?= $lang['reward'] ?>
                  </p>
                  </a>
                  <a class="c-Circle card-header-action" class="btn btn-primary" data-toggle="modal" data-target="#referal_modal">
                    <div class="theBIcon">
                      <img src="<?= base_url() ?>/assets/img/Group 130.png">
                    </div>
                    <p class="m-0">
                      <?= $lang['your_teacher'] ?>
                    </p>
                  </a>
                  <a class="c-Circle card-header-action" class="btn btn-primary" data-toggle="modal" data-target="#level_modal">
                    <div class="theBIcon">
                      <img src="<?= base_url() ?>/assets/img/Path 26.png">
                    </div>
                    <p class="m-0">
                      <?= $lang['achievement'] ?>
                    </p>
                  </a>
            </div>
          </div>
          <!-- /.col-->
          <?php if ($users['is_verified'] == 1) { ?>

            <div class="col-sm-12 col-lg-12">
              <div class="card text-white c-shadow" style="border-radius: 20px;">
                <div class="c-QR">
                  <img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=<?= base_url() ?>/main/welcome/<?= $family_id ?>/<?= $users_id ?>&choe=UTF-8" style="margin: auto; display: block; margin-left: auto; margin-right: auto;">
                </div>
                <div class="text-white" style="padding:50px; border-bottom-left-radius: 20px;border-bottom-right-radius: 20px; background:linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;">
                  <div class="row">
                    <div class="col-12">
                      <p style="font-size: 16px; line-height:1; margin:0;">
                        <?= $lang['invite_more'] ?>
                      </p>
                    </div>
                    <!-- <div class="col-6">
                      <h1 style="margin: 0;">
                        RM10
                      </h1>
                    </div>
                    <div class="col-12 mt-3">
                      <p style="margin: 0; font-size:8px; line-height:1;">
                        NOTE: IF EACH LEVEL THEN SYSTEM WILL PROVIDE RM 30
                      </p>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>


          <div class="col-sm-12 col-lg-12">

            <div class="slick-slider-promo">
              <?php foreach ($banner as $row) { ?>
                <div class="c-carousel">
                  <div class="c-carouselimg">
                    <img src="<?= base_url() . $row['banner'] ?>" alt="">
                  </div>
                </div>
              <?php } ?>
              <!-- <div class="c-carousel">
                <div class="c-carouselimg">
                  <img src="<?= base_url() ?>/assets/img/carplateBanner_.jpg" alt="">
                </div>
              </div>
              <div class="c-carousel">
                <div class="c-carouselimg">
                  <img src="<?= base_url() ?>/assets/img/carplateBanner_.jpg" alt="">
                </div>
              </div>
              <div class="c-carousel">
                <div class="c-carouselimg">
                  <img src="<?= base_url() ?>/assets/img/carplateBanner_.jpg" alt="">
                </div>
              </div> -->
            </div>
          </div>

          <!-- /.col-->
        </div>
        <!-- /.row-->
      </div>


      <div class="modal fade" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form enctype="multipart/form-data" method="POST" action="<?= base_url('Users/submit_receipt'); ?>">
              <div class="modal-body text-center">

                <div><?= $lang['status'] ?></div>
                <hr>
                <?php if ($users['is_verified'] == 1) { ?>
                  <div class="text-value-lg">
                    <?= $lang['verified'] ?>
                  </div>


                <?php } else { ?>
                  <div class="text-value-lg text-danger">
                    <?= $lang['not_verified'] ?>
                  </div>
                <?php } ?>
              </div>
              <?php if ($users['receipt'] == "") { ?>

                <div class="card-group text-center" style="margin-top: 20px;">
                  <div class="card">
                    <div class="card-body">
                      <h1>Bank Detail</h1>
                      <hr>

                      <p class="text-muted">Please Submit your receipt to bank below</p>
                      <div class="text-center">
                        <img src="<?= base_url() .  ($qrcode) ?>" alt="">
                      </div>
                      <br>

                      <div class="input-group mb-4">
                        <div class="form-group" style="width: 100%;">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile02" required name="receipt">
                            <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Submit Receipt</label>
                          </div>
                        </div>

                      </div>

                      <div class="form-group">
                        <button class="btn btn-primary float-right" type="submit"> Submit</button>
                      </div>
                    </div>
                  </div>
                </div>

              <?php } else { ?>
                <div class="card-group" style="margin-top: 20px;">
                  <div class="card">
                    <div class="card-body">
                      <h1>Receipt</h1>
                      <p class="text-muted">Your Receipt already submmited</p>
                      <div class="text-center">
                        <img style="width:100%" src="<?= base_url() .  $users['receipt'] ?>" alt="">
                      </div>
                      <br>

                    </div>
                  </div>
                </div>

              <?php } ?>


            </form>
          </div>
        </div>
      </div>



      <div class="modal fade" id="referal_modal" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="modalAddLabel"> <?= $lang['your_teacher'] ?></h5>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form enctype="multipart/form-data" method="POST" action="<?= base_url(); ?>">
              <div class="modal-body">

                <div class="card text-white bg-gradient-warning">
                  <div class="card-status card-body card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                      <i class="fa fa-compass fa-2x"></i>


                      <div><?= $lang['referral_name'] ?></div>
                      <div class="text-value-lg text-statis"><?= $users['upline_name'] != "" ? $users['upline_name'] : 'None' ?></div>

                    </div>
                    <div class="btn-group">
                      <!-- <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <svg class="c-icon">
                            <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-settings"></use>
                          </svg>
                        </button> -->
                      <!-- <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div> -->
                    </div>
                  </div>
                  <!-- <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"> -->
                  <!-- <canvas class="chart" id="card-chart1" height="70"></canvas> -->
                  <!-- </div> -->
                </div>
                <input type="hidden" name="asd" value="asd">

              </div>

            </form>
          </div>
        </div>
      </div>



      <div class="modal fade" id="family_tree" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="modalAddLabel"> <?= $lang['reward'] ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form enctype="multipart/form-data" method="POST" action="<?= base_url(); ?>">
              <div class="modal-body">

                <div class="card text-white bg-gradient-info">
                  <div class="card-status card-body card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                      <i class="fa fa-users fa-2x"></i>

                      <div> <?= $lang['reward'] ?></div>
                      <div class="text-value-lg">
                        <?php if (
                          $users['is_verified'] == 0
                        ) { ?>

                          <a class="btn btn-primary">
                            <?= $lang['dont_have_family'] ?>
                          </a>
                        <?php } else { ?>
                          <a class="btn btn-primary" href="<?= base_url() ?>/users/family_tree/1">
                            <?= $lang['view_reward'] ?>
                          </a>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="btn-group">
                      <!-- <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <svg class="c-icon">
                            <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-settings"></use>
                          </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div> -->
                    </div>
                  </div>
                  <!-- <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"> -->
                  <!-- <canvas class="chart" id="card-chart2" height="70"></canvas> -->
                  <!-- </div> -->
                </div>
                <input type="hidden" name="asd" value="asd">

              </div>

            </form>
          </div>
        </div>
      </div>


      <div class="modal fade" id="level_modal" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="modalAddLabel"><?= $lang['reward'] ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form enctype="multipart/form-data" method="POST" action="<?= base_url(); ?>">
              <div class="modal-body">

                <div class="card text-white bg-gradient-danger">
                  <div class="card-status card-body card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                      <i class="fa fa-users fa-2x"></i>

                      <div><?= $lang['total_level_achived'] ?></div>
                      <div class="text-value-lg"><?= get_level($users['level']) ?></div>
                    </div>
                    <!-- <div class="btn-group">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <svg class="c-icon">
                            <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-settings"></use>
                          </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                      </div> -->
                  </div>
                  <!-- <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                      <canvas class="chart" id="card-chart4" height="70"></canvas>
                    </div> -->
                </div>
                <input type="hidden" name="asd" value="asd">

              </div>

            </form>
          </div>
        </div>
      </div>







      <!--     

      <div class="modal fade" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalAddLabel">Add Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data"  method="POST" action="<?= base_url(); ?>">
                <div class="modal-body">
       
                <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>

                    <input type="hidden" name="asd" value="asd">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div> -->



      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
      <script src="<?= base_url() ?>/assets/js/bootstrap.min.js"></script>
      <script src="<?= base_url() ?>/assets/js/bjs.js"></script>


      <?php if ($users['receipt'] == "") { ?>
        <script>
          $('#status_modal').modal('show');
        </script>

      <?php } ?>