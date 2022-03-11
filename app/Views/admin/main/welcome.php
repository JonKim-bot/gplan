<!DOCTYPE html>



<html lang="en">

<head>
    <!-- <base href="./"> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=Gplanice-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gplan Admin Panel</title>
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@1.0.0/css/all.min.css">
    <!-- Main styles for this application-->
    <link href="<?= base_url(
                    'assets/css/core/style.css'
                ) ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/core/custom.css') ?>" rel="stylesheet">
    <link href="<?= base_url(
                    'assets/plugins/chartjs/css/chartjs.css'
                ) ?>" rel="stylesheet">
    <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable/css/dataTables.bootstrap4.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://kit.fontawesome.com/3d15aa1b08.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url(
                                        'assets/plugins/select2/select2.css'
                                    ) ?>">

</head>
<style>
    hr{
        background:white;
    }
    body{
        background: rgb(43,38,128);
        display: flex!important;
    flex-direction: column!important;
    justify-content:center!important;
    background: linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;    }
    .register_div{
        text-align:center;
    color: white;
    }
    .gift_div{
        display: flex;
    justify-content: center;
    }
    .gift_div > img{
        width:80%;
    }
    .register_btn{
        border: none;
    color: blue;
    border-radius: 35px;
    font-size: 5;
    font-size: 16px;
    padding: 15px 40px;
    margin-bottom: 20px;
    background: black;
    color: white;
    margin-bottom: 20px;
    font-weight: 500;
    }
    .login_text{
        color: white;
    text-decoration: underline;
    }
    .main_div{
        display: flex;
        height:90vh;
    flex-direction: column;
    justify-content: space-evenly;
    }

</style>
<body class="c-app ">
            <div class="col-md-12 main_div" >
                <div class="register_div">
                    <h1>Gplan</h1> 
                    <hr>
                    <h3>Register & Get Your<br> Welcome Gift Set</h3>
                </div>
                <div class='gift_div'>
                    <img  src="<?= base_url() ?>/assets/img/gifticon.png" alt="">
                </div>
                <div class="col-md-12 justify-content-center text-center">
                    <a class="register_btn" href="<?= base_url() ?>/main/add/<?= $family_id ?>/<?= $uid ?>">Register Now</a>
                    <p class="text-white" style="margin-top:20px">Already A Member? <a class="login_text" href="<?= base_url() ?>/access/login"> Login Here</a></p>
                </div>


            <!-- <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url() . "/main/add/" . $family_id; ?>">

                    <div class="card-group">
                        
                        <div class="card p-4">
                            
                     <?php if (isset($error)) { ?>
                                     <div class="alert-message" role="alert">
                                         <?= $error; ?>
                                     </div>
                                 <?php } ?>


                            <div class="card-body">
                                <h1>Register</h1>
                                <p class="text-muted">Register Your Account Here</p>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <i class="cil-user c-icon"></i>
                                        </span></div>
                                    <input class="form-control" type="text" required name="username" placeholder="Username">
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <i class="cil-lock-locked c-icon"></i>
                                        </span></div>
                                    <input class="form-control" type="password" required name="password" placeholder="Password">
                                </div>

                                <div class="input-group mb-4">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <i class="cil-lock-locked c-icon"></i>
                                        </span></div>
                                    <input class="form-control" type="password" required name="password2" placeholder="Confirm Password">
                                </div>


                            </div>
                        </div>
                        <div class="card p-4">


                            <div class="card-body">
                                <h1>Personal Detail</h1>
                                <p class="text-muted">Enter your personal detail here</p>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <i class="cil-user c-icon"></i>
                                        </span></div>
                                    <input class="form-control" type="text" required name="name" placeholder="Name">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <i class="cil-user c-icon"></i>
                                        </span></div>
                                    <input class="form-control" type="text"  required name="contact" placeholder="Contact number">
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <i class="cil-lock-locked c-icon"></i>
                                        </span></div>
                                    <input class="form-control" type="email" name="email" required placeholder="Email">
                                </div>



                            </div>
                        </div>

                    </div>


                    <div class="card-group" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-body">
                                <h1>Bank Detail</h1>
                                <p class="text-muted">Please Submit your receipt to bank below</p>


                                <div>
                                    <p style="margin-bottom: 0px;">Bank Name: asd</p>
                                    <p style="margin-bottom: 0px;">Bank Holder Name: asd</p>
                                    <p>Bank Account Number: 01664854654</p>
                                </div>

                                <div class="input-group mb-4">
                                    <div class="form-group" style="width: 100%;">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputGroupFile02" required name="receipt">
                                            <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Submit Receipt</label>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <div style="width:100%; display: flex; justify-content: end;">
                            <button style="width: 100%;" class="btn btn-primary px-4" type="submit">Submit</button>
                        </div>
                    </div>
            </div>
            </form> -->
        </div>
        </div>
        </div>

        <!-- CoreUI and necessary plugins-->
        <!--<![endif]-->