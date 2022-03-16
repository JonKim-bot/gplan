<style>
  .text-value-lg {
    font-size: 2.3rem;
  }

  .card-status {
    height: 150px
  }

  .c-withButton {
    background-color: #000;
    border-radius: 5px;
  }

  .c-Circle {
    width: 80px;
    height: 80px;
    /* padding: 10px; */
    text-align: center;
  }

  .c-shadow {
    -webkit-box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.6) !important;
    box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.6) !important;
  }

  .c-QR {
    width: 60%;
    margin: 0 auto;
    padding: 20px 0;
  }

  .c-QR img {
    width: 100%;
  }

  .one_row {
    border-bottom: 1px solid black;
    margin-bottom: 7px;
  }

  .permission_div {
    background: cornflowerblue;
    color: white;
    margin-top: 20px;
    padding: 0px 20px;
    width: 125%;
  }

  .description_div {
    padding: 0px 25px;

  }

  .icon_top {
    width: 25px;
    height: 25px;
  }

  .c-body {
    position: relative;
    max-width: 100%;
    /* min-height: 787px; */
    width: 100%;
    margin: 0 auto;
    justify-content: center;
    overflow: hidden;
  }

  .bold {
    font-weight: bold;
  }

  .bg_color {
    background: rgb(49, 27, 110) !important;

    background: linear-gradient(180deg, rgba(49, 27, 110, 1) 0%, rgba(46, 195, 201, 1) 100%) !important;
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
<div class="c-body bg_color h-100">
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">

          <!-- /.col-->
          <div class="col-sm-12 d-flex" style="justify-content: space-between;margin-bottom:20px;">
            <!-- <a href="">+</a> -->
            <a class="icon_top" href="<?= base_url() ?>/users/dashboard/1">
              <img src="<?= base_url() ?>/assets/img/XMLID_223_.png">
            </a>
            <div>
              <h5 class="text-white OpenSansSemiBold" style="font-size: 15px;">Withdraw</h5>
            </div>
            <div class="icon_top" data-toggle="modal" data-target="#status_modal">
              <img src="<?= base_url() ?>/assets/img/Path 17.png">
            </div>
          </div>
          <!-- /.col-->
          <?php foreach ($wallet_withdraw as $row) { ?>
            <div class="col-sm-12 col-lg-12">
              <div class="card text-white c-shadow" style="border-radius: 20px;">
                <div class="c-QR row text-dark" style="width:90%">
                  <div class="row">
                    <div class="col-7 description_div">
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;">User Name</p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $row['users'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;">Amount Withdraw</p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;">RM <?= $row['amount'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;">Bank Account</p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $row['bank_acc'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;">Bank Name</p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $row['bank_name'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;">Account Name</p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $row['acc_name'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;">Created Date</p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $row['created_date'] ?></p>
                        </div>
                      </div>

                    </div>
                    <div class="col-5 theWFlex">


                      <?php if ($row['is_approved'] == 1) { ?>
                        <div class="btn btn-success w-100">

                          <p class="OpenSansRegular" style="font-size: 9px; margin-bottom:0px">
                            Approved
                          </p>
                        </div>
                      <?php } ?>

                      <?php if ($row['is_rejected'] == 1) { ?>

                        <div class="btn btn-danger text-white  w-100">

                          <p class="OpenSansRegular" style="font-size: 9px; margin-bottom:0px">
                            Rejected
                          </p>
                        </div>
                      <?php } ?>

                      <?php if ($row['is_rejected'] == 0 && $row['is_approved'] == 0) { ?>

                        <div class="btn btn-secondary text-white  w-100">

                          <p class="OpenSansRegular" style="font-size: 9px; margin-bottom:0px">
                            Pending
                          </p>
                        </div>
                      <?php } ?>

                      <div class="btn btn-success w-100" style="margin-top:5px">
                        <p class="OpenSansRegular" style="font-size: 9px; margin-bottom:0px">Permission Date</p>
                        <?php if ($row['is_rejected'] == 1 || $row['is_approved'] == 1) { ?>
                          <p class="OpenSansRegular" style="font-size: 9px; margin-bottom:0px"><?= $row['created_date'] ?></p>
                        <?php } else { ?>
                          <p class="OpenSansRegular" style="font-size: 9px; margin-bottom:0px">Pending</p>
                        <?php } ?>
                      </div>
                    </div>

                  </div>

                </div>


              </div>

            </div>
          <?php } ?>


          <div class="theEmptyBox">
            <div class="theEmpty">
              <h3>
                <?= $lang['withdraw_now'] ?>
              </h3>
              <a href="">
                <div class="theIcon">
                  <img src="<?= base_url() ?>/assets/img/Group 156.png">
                </div>
              </a>
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
              <h5 class="modal-title" id="modalAddLabel"><?= $lang['wallet_withdraw'] ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form enctype="multipart/form-data" method="POST" action="<?= base_url('/Withdraw/add'); ?>">
              <div class="modal-body">
                <?= $final_form ?>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?= $lang['save'] ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>