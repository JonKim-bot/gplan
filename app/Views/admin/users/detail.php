<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url('users') ?>">User</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/users/detail/<?= $users['users_id'] ?>">User Details</a></li>
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            Status
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>

                            </div>
                        </div>
                        <div class="c-card-body">
                            <div class="view-info">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-12">
                                                    <a href="<?= base_url() ?>/Users/verify_user/<?= $users['users_id'] ?>" class="btn btn-<?= $users['is_verified'] == 1 ? "success" : "danger" ?>"><?= $users['is_verified'] == 1 ? "Verified" : "Not verified" ?></a>
                                                    <!-- <img src="" width="200" class="img-fluid d-block m-auto" alt=""> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            User Details
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                                <a class="card-header-action" href="<?php echo site_url('users/edit') . '/' . $users['users_id'] ?>">
                                    <i class="cil-pencil c-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="c-card-body">
                            <div class="view-info">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-12">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">
                                                            <tbody>
                                                            <tr>
                                                        <th>Last Edited By</th>
                                                        <th><?= $modified_by ?></th>

                                                    </tr>

                                                                <tr>
                                                                    <th scope="row">Name</th>
                                                                    <td><?= $users["name"] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">email</th>
                                                                    <td><?= $users["email"] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Contact</th>
                                                                    <td><?= $users["contact"] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">NRIC</th>
                                                                    <td><?= $users["nric"] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">NRIC Name</th>
                                                                    <td><?= $users["nric_name"] ?></td>
                                                                </tr>
                                                             
                                                                <tr>
                                                                    <th scope="row">Nric frontend</th>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-xl-12">
                                                                                <a target="_blank" href="<?= base_url() . $users['nric_front'] ?>">
                                                                                    <img src="<?= base_url(). $users['nric_front'] ?>" width="200" class="img-fluid d-block m-auto" alt="">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                               
                                                                <tr>
                                                                    <th scope="row">Nric back</th>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-xl-12">
                                                                            <a target="_blank" href="<?= base_url() . $users['nric_back'] ?>">

                                                                                <img src="<?= base_url(). $users['nric_back'] ?>" width="200" class="img-fluid d-block m-auto" alt="">
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                               
                                                              

                                                                <tr>
                                                                    <th scope="row">Remarks</th>
                                                                    <td>

                                                                        <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url('/users/add_remarks/' . "/" . $users['users_id']); ?>">
                                                                            <textarea name="remarks" id="" cols="30" rows="10" class="form-control"><?= $users['remarks'] ?></textarea>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-primary float-right" type="submit"> Save</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>

                                                               
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="container-fluid">
	
	<div class="fade-in">
        <div class="card">
            <div class="card-header">
                Wallet Details 
                <h1>Balance : <?= $balance ?></h1>
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                    <!-- <a class="card-header-action" href="<?= base_url() ?>/wallet/add">
                        <i class="cil-plus c-icon"></i>
                    </a> -->
                </div>
            </div>
            <div class="card-body">
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered no-footer datatable" id="wallet_list_table" data-method="get" data-url="<?= base_url("wallet") ?>" style="border-collapse: collapse !important">
                                    <thead>
                                        <tr role="row">
                                            <th>No.</th>
                                            <th data-sort="name" data-filter="name">Name</th>
                                <th data-sort="contact" data-filter="contact">Contact</th>
                                <th data-sort="" data-filter="">Transaction</th>
                                <th data-sort="remarks" data-filter="remarks">Remarks</th>
                                <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            foreach($wallet as $row){
                                         ?>
                                            <tr>
                                            <td><?= $i ?></td>

                                            <td><?= $row['name'] ?></td>
                                    <td><?= $row['contact'] ?></td>
                                    <td><?= $row['transaction'] ?></td>
                                    <td><?= $row['remarks'] ?></td>
                                    <td><?= $row['created_date'] ?></td>
                                            </tr>
                                        <?php
                                        $i++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                              
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            </div>
