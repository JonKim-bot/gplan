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

<body class="c-app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

            <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url() . "/main/add/" . $family_id; ?>">

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
            </form>
        </div>
        <!-- CoreUI and necessary plugins-->
        <!--<![endif]-->