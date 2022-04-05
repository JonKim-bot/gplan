<!DOCTYPE html>



<html lang="en">
    <head>
        <!-- <base href="./"> -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=Gplanice-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Nsjrw Admin Panel</title>
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
    <body class="c-app">
        <div class="c-wrapper c-fixed-components">
        <div class="c-body">
			


<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <!-- <li class="breadcrumb-item"><a href="<?= base_url() ?>/users">User</a></li> -->
        <!-- <li class="breadcrumb-item active"><a href="<?= base_url() ?>users/add">Create New User</a></li> -->
    </ol>
    <!-- <div class="c-subheader-nav d-md-down-none mfe-2">
		<a class="c-subheader-nav-link" href="#">
			<i class="cil-settings c-icon"></i>
			&nbsp;Settings
		</a>
	</div> -->
</div>
<main class="c-main">

    <div class="container-fluid">

        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Register Here
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url() .
                                '/main/add/' .
                                $family_id ?>">
                                
                                <?php if (isset($error)) { ?>
                                    <div class="alert-message" role="alert">
                                        <?= $error ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" required>
                                </div>

                                <div class="form-group">
                                    <label for="">User Name</label>
                                    <input type="text" class="form-control" name="username" placeholder="User Name" required>
                                </div>


                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    
                                    <label for="">Confirm Password</label>
                                    <input type="password" class="form-control" name="password2" placeholder="Confirm Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control" name="contact" placeholder="Contact Number" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>

                                <div class="form-group">
                                <label for="">Receipt</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile02" name="receipt">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                </div>
                            </div>

                                <!-- <div class="form-group">
                                    <label for="">Nric</label>
                                    <input type="text" name="nric" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="">Nric Name</label>
                                    <input type="text" name="nric_name" class="form-control" >
                                </div>
 
                                <div class="form-group">
                                    <label for="">Nric Front</label>
                                    <input type="file" name="nric_front" class="form-control" accept="image/png, image/jpeg" >
                                </div>
                                <div class="form-group">
                                    <label for="">Nric Back</label>
                                    <input type="file" name="nric_back" class="form-control" accept="image/png, image/jpeg" >
                                </div> -->
                             
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="submit"> Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
