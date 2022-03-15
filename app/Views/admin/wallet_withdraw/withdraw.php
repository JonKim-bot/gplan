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
    background: white;
    border-radius: 50%;
    color: black;
    padding: 5px;
  }
  .c-body{
    position: relative;
    max-width: 500px;
    min-height: 787px;
    margin: 0 auto;
    background-color: #fff;
    justify-content: center;
    overflow: hidden;
  }
  .bold{
    font-weight:bold;
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
            <div class="icon_top">
              <a href="<?= base_url() ?>/users/dashboard/1">
                <i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i>
              </a>
            </div>
            <div>
              <h5 class="text-white font-weight-bold">Withdraw</h5>
            </div>
            <div class="icon_top" data-toggle="modal" data-target="#status_modal">
              <i class="fa fa-plus fa-2x" aria-hidden="true"></i>
            </div>
          </div>
          <!-- /.col-->
          <?php foreach ($wallet_withdraw as $row) { ?>
            <div class="col-sm-12 col-lg-12">
              <div class="card text-white c-shadow" style="border-radius: 20px;">
                <div class="c-QR row text-dark" style="width:90%">
                  <div class="row">
                    <div class="col-12 description_div">
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="bold">User Name</p>
                        </div>
                        <div class="col-6">
                          <p><?= $row['users'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p  class="bold">Amount Withdraw</p>
                        </div>
                        <div class="col-6">
                          <p>RM <?= $row['amount'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p  class="bold">Bank Account</p>
                        </div>
                        <div class="col-6">
                          <p ><?= $row['bank_acc'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p  class="bold">Bank Name</p>
                        </div>
                        <div class="col-6">
                          <p><?= $row['bank_name'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p  class="bold">Account Name</p>
                        </div>
                        <div class="col-6">
                          <p><?= $row['acc_name'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p  class="bold">Created Date</p>
                        </div>
                        <div class="col-6">
                          <p><?= $row['created_date'] ?></p>
                        </div>
                      </div>

                    </div>
                    <div class="col-12">


                       <?php if ($row['is_approved'] == 1) { ?>
                        <div class="btn btn-success w-100" >

                        <p style="margin-bottom:0px">  
                            Approved
                        </p>
                       </div>
                        <?php } ?>

                        <?php if ($row['is_rejected'] == 1) { ?>
                      
                        <div class="btn btn-danger text-white  w-100" >

<p style="margin-bottom:0px">  
Rejected
</p>
</div>
                        <?php } ?>

                        <?php if ($row['is_rejected'] == 0 && $row['is_approved'] == 0) { ?>
                     
                        <div class="btn btn-secondary text-white  w-100" >

                  <p style="margin-bottom:0px">  
                  Pending
                  </p>
                  </div>
                        <?php } ?>

                        <div class="btn btn-success w-100" style="margin-top:5px">
                          <p>Permission Date</p>
                          <?php if ($row['is_rejected'] == 1 || $row['is_approved'] == 1) { ?>
                              <p><?= $row['created_date'] ?></p>
                          <?php }else{ ?>
                              <p>Pending</p>
                          <?php } ?>
                        </div>
                      </div>

                    </div>

                  </div>


                </div>

            </div>
          <?php } ?>




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