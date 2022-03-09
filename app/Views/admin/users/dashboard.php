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
</style>
<!-- <div class="c-subheader px-3">
  <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item"><a href="#">Admin</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
</div> -->

</header>
<div class="c-body">
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-sm-12 col-lg-3">
            <div class="card text-white bg-gradient-primary" style="border-radius: 20px; background:linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;">
              <div class="card-status card-body card-body pb-0">
                <div>
                  <div>Your Balance</div>
                  <div class="">
                    <h1>
                      MYR 5151.00
                    </h1>
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="c-withButton d-flex justify-content-center align-items-center py-1 px-3 br-3">
                    <div class="icon mr-2">
                      <i class="fa fa-money-bill fa-2x"></i>
                    </div>
                    <p class="m-0">
                      Withdraw
                    </p>
                  </div>
                  <div class="py-1 px-3 br-3">
                    <p class="m-0">
                      Transaction History >
                    </p>
                  </div>
                </div>
              </div>
              <!-- <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"> -->
              <!-- <canvas class="chart" id="card-chart1" height="70"></canvas> -->
              <!-- </div> -->
            </div>
          </div>
          <!-- /.col-->
          <div class="col-sm-12 col-lg-3">
            <div class="row no-gutters mb-3">
              <div class="col-3 d-flex justify-content-center">
                <div class="c-Circle text-white rounded-circle d-flex flex-column justify-content-center align-items-center " style="background:linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;">
                  <div class="icon mb-2">
                    <i class="fa fa-compass fa-lg"></i>
                  </div>
                  <p class="m-0" style="font-size: 12px; line-height:1; padding:0 5px">
                    Status
                  </p>
                </div>
              </div>
              <div class="col-3 d-flex justify-content-center">
                <div class="c-Circle text-white rounded-circle d-flex flex-column justify-content-center align-items-center " style="background:linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;">
                  <div class="icon mb-2">
                    <i class="fa fa-diagram-project fa-lg"></i>
                  </div>
                  <p class="m-0" style="font-size: 12px; line-height:1; padding:0 5px">
                    Family Tree
                  </p>
                </div>
              </div>
              <div class="col-3 d-flex justify-content-center">
                <div class="c-Circle text-white rounded-circle d-flex flex-column justify-content-center align-items-center " style="background:linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;">
                  <div class="icon mb-2">
                    <i class="fa fa-user fa-lg"></i>
                  </div>
                  <p class="m-0" style="font-size: 12px; line-height:1; padding:0 5px">
                    Referral
                  </p>
                </div>
              </div>
              <div class="col-3 d-flex justify-content-center">
                <div class="c-Circle text-white rounded-circle d-flex flex-column justify-content-center align-items-center " style="background:linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;">
                  <div class="icon mb-2">
                    <i class="fa fa-user-group fa-lg"></i>
                  </div>
                  <p class="m-0" style="font-size: 12px; line-height:1; padding:0 5px">
                    Total Downline
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-->
          <div class="col-sm-12 col-lg-3">
            <div class="card text-white c-shadow" style="border-radius: 20px;">
              <div class="c-QR">
                <img src="<?= base_url() ?>/assets/img/qr.png" alt="">
              </div>
              <div class="text-white" style="padding:50px; border-bottom-left-radius: 20px;border-bottom-right-radius: 20px; background:linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;">
                <div class="row">
                  <div class="col-6">
                    <p style="font-size: 16px; line-height:1; margin:0;">
                      Invite friends and earn
                    </p>
                  </div>
                  <div class="col-6">
                    <h1 style="margin: 0;">
                      RM10
                    </h1>
                  </div>
                  <div class="col-12 mt-3">
                    <p style="margin: 0; font-size:8px; line-height:1;">
                      NOTE: IF EACH LEVEL THEN SYSTEM WILL PROVIDE RM 30
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-->
        </div>
        <!-- /.row-->
      </div>