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
  .one_row{
    border-bottom: 1px solid black;
    margin-bottom: 7px;
  }
  .permission_div{
    background: cornflowerblue;
    color: white;
    margin-top:20px;
    padding: 0px 20px;
    width: 125%;
  }
  .description_div{
    padding: 0px 25px;

  }
  .icon_top{
    background: white;
    border-radius: 50%;
    color: black;
    padding: 5px;
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
<div class="c-body bg_color">
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
         
            </div>
          <!-- /.col-->
          <?php foreach ($users_downline as $row) {?>
          <div class="col-sm-12 col-lg-3">
            <div class="card text-white c-shadow" style="border-radius: 20px;">
              <div class="c-QR row text-dark" style="width:90%">
                <div class="row">
                    <div class="col-12 description_div">
                        <div class="one_row row">
                          
                            <div class="col-6">
                                <p><?= $row['username'] ?></p>
                            </div>
                            <div class="col-6">
                            <div class="btn btn-<?= $row['is_verified'] == 1 ? 'success' : 'danger' ?> w-100">
                              
                                <?= $row['is_verified'] == 1 ? 'Verified' : 'Not Verified' ?>
                             </div>
                             <div id="<?= $row['users_id'] ?>" class="btn btn_paid btn-<?= $row['is_paid'] == 1 ? 'success' : 'danger' ?> w-100">
                              
                              <?= $row['is_paid'] == 1  ? 'Paid' : 'Not Paid (Click to make paidment for your member)' ?>
                           </div>
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


      <script>
        $(document).on("click", ".btn_paid", function(e) {
            var downline_id = $(this).attr('id');



            var postParam = {
                downline_id: downline_id
            };
            
            var delete_record = confirm("Are you sure you want to make payment for this user?");
            var path = $(this).attr("href");

            if (delete_record === true) {
                $.post("<?= base_url('Users/make_payment') ?>", postParam, function(data) {
    
                    data = JSON.parse(data);
                    if(data.status){
                        alert("Payment success")
                    }else{
                        alert(data.message);
                    }
                });
            }
            
        });

      </script>