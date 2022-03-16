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
    width:100vw;
    position: relative;
    max-width: 500px;
    min-height: 787px;
    margin: 0 auto;
    justify-content: center;
    overflow: hidden;
  }

  .bold {
    font-weight: bold;
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
              <h5 class="text-white OpenSansSemiBold" style="font-size: 15px;">Transaction</h5>
            </div>
            <div>
              
            </div>
      
          </div>
          <!-- /.col-->
          <?php foreach ($wallet as $row) { ?>
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
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $row['username'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;">Contact</p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $row['contact'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $lang['balance'] ?></p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $row['balance'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $lang['credit'] ?></p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $row['wallet_in'] ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $lang['debit'] ?></p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= ltrim($row['wallet_out'], '-'); ?></p>
                        </div>
                      </div>
                      <div class="one_row row">
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $lang['remarks'] ?></p>
                        </div>
                        <div class="col-6">
                          <p class="OpenSansRegular mb-1" style="font-size: 10px; color:#000;"><?= $row['remarks'] ?></p>
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
                  </div>

                </div>


              </div>

            </div>
          <?php } ?>




          <!-- /.col-->
        </div>



        <!-- /.row-->
      </div>

