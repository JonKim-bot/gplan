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
  .bg_color{
  background: rgb(49, 27, 110) !important;

  background: linear-gradient(180deg, rgba(49, 27, 110, 1) 0%, rgba(46, 195, 201, 1) 100%)!important;
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
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-sm-12 d-flex" style="justify-content: space-between;margin-bottom:20px;">
            <!-- <a href="">+</a> -->
            <div class="icon_top">
              <a href="<?= base_url() ?>/users/dashboard/1">
                <i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i>
              </a>
            </div>
            <div>
              <h5 class="text-white font-weight-bold">Transaction</h5>
            </div>
        
            <div style="width:10px">

            </div>

          </div>

          <!-- /.col-->

          <!-- /.col-->
          <?php foreach ($wallet as $row) { ?>
            <div class="col-sm-12 col-lg-12">
              <div class="card text-white c-shadow" style="border-radius: 20px;">
                <div class="c-QR row text-dark" style="width:90%">
                  <div class="col-12 description_div">
                    <div class="one_row row">
                      <div class="col-6">
                        <p class="bold"><?= $lang['username'] ?></p>
                      </div>
                      <div class="col-6">
                        <p><?= $row['username'] ?></p>
                      </div>
                    </div>
                    <div class="one_row row">
                      <div class="col-6">
                        <p class="bold"><?= $lang['contact'] ?></p>
                      </div>
                      <div class="col-6">
                        <p><?= $row['username'] ?></p>
                      </div>
                    </div>
                    <div class="one_row row">
                      <div class="col-6">
                        <p class="bold"><?= $lang['balance'] ?></p>
                      </div>
                      <div class="col-6">
                        <p><?= $row['balance'] ?></p>
                      </div>
                    </div>
                    <div class="one_row row">
                      <div class="col-6">
                        <p class="bold"> <?= $lang['credit'] ?></p>
                      </div>
                      <div class="col-6">
                        <p><?= $row['wallet_in'] ?></p>
                      </div>
                    </div>
                    <div class="one_row row">
                      <div class="col-6">
                        <p class="bold"><?= $lang['debit'] ?></p>
                      </div>
                      <div class="col-6">
                        <p><?= ltrim($row['wallet_out'], '-'); ?></p>
                      </div>
                    </div>
                    <div class="one_row row">
                      <div class="col-6">
                        <p class="bold"><?= $lang['remarks'] ?></p>
                      </div>
                      <div class="col-6">
                        <p><?= ($row['remarks']); ?></p>
                      </div>
                    </div>
                    <div class="one_row row">
                      <div class="col-6">
                        <p class="bold"><?= $lang['created_date'] ?></p>
                      </div>
                      <div class="col-6">
                        <p><?= ($row['created_date']); ?></p>
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