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
  .c-body{
    position: relative;
    max-width: 500px;
    min-height: 787px;
    margin: 0 auto;
    background-color: #fff;
    justify-content: center;
    overflow: hidden;
  }
  .card-top{
    display: flex;
    height: 170px;
    justify-content: center;
    align-items: center;
  }
  
  .icon_top {
    border-radius: 50%;
    color: white !important;
    padding: 5px;
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
<div class="c-body">
        <div class="row">
       
          <div class="col-sm-12 col-lg-12">
            <div class="card text-white bg_color" style="">
            <div class="col-sm-12 d-flex" style="justify-content: space-between;margin-top:20px;">
            <!-- <a href="">+</a> -->
            <div class="icon_top">
              <a href="<?= base_url() ?>/users/dashboard/1">
                <i class="fa fa-arrow-left fa-2x text-white" aria-hidden="true"></i>
              </a>
            </div>
       
          </div>
              <div class="card-stats card-top pb-0">
                <div>
                  <div class="text-center">
                    <img src="<?= base_url() ?>/assets/img/Group 170.png" width="80px" alt="">
                    <p><?= $users['name'] ?></p>
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  
                </div>
              </div>
              <!-- <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"> -->
              <!-- <canvas class="chart" id="card-chart1" height="70"></canvas> -->
              <!-- </div> -->
            </div>
          </div>
          <!-- /.col-->
          
          <!-- /.col-->
          <div class="col-sm-12 col-lg-12">
              <div class="c-QR row text-dark" style="width:80%">
              <div class="col-6">
                    <p>Name</p>
                </div>
                <div class="col-6">
                    <p class="bold"><?= $users['name'] ?></p>
                </div>
                <div class="col-12">
                <hr>
                </div>
                <div class="col-6">
                    <p>Email</p>
                </div>
                <div class="col-6">
                    <p class="bold"><?= $users['email'] ?></p>
                </div>
                <div class="col-12">
                <hr>
                </div>
                <div class="col-6">
                    <p>Contact</p>
                </div>
                <div class="col-6">
                    <p class="bold"><?= $users['contact'] ?></p>
                </div>

                <div class="col-12">
                <hr>
                </div>
                <div class="col-6">
                  <p>Proof of receipt</p>
                </div>
                <div class="col-6">
                </div>
                <div class="col-12">
                <div class="col-12">
                  <img src="<?= base_url()  . $users['receipt']?>" witdh="100%" alt="">
                </div>
                
              </div>
              <div class="col-12 text-center">
                  <a data-toggle="modal" class="btn btn-primary text-white mt-5" data-target="#status_modal">Edit</a>
              </div>
              </div>
              
          </div>
          <!-- /.col-->
        <!-- /.row-->


        
      <div class="modal fade" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="modalAddLabel">Edit</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url()?>/users/edit/<?=$users["users_id"]?>">
              <div class="modal-body">
 

                  <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" value="<?=  $users['name'] ?>" name="name" placeholder="Name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Contact Number</label>
                        <input type="text" class="form-control" name="contact" value="<?=  $users['contact'] ?>" placeholder="Contact Number" required>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="email" value="<?=  $users['email'] ?>" placeholder="Email" required>
                    </div>
                  </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?= $lang['save'] ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
