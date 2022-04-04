<div class="c-subheader justify-content-between px-3">

    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url(
            'users'
        ) ?>">User</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/users/detail/<?= $users[
    'users_id'
] ?>">User Details</a></li>
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
                            Qr Code
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
                                                    <div class="table-responsive">
                                                        <table class="table m-0">
                                                            <tbody>
                                                                <tr>
                                                                                <th>
                    
                                                                                <div class="c-cardbody">
                                    <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?= base_url() ?>/main/welcome/<?= $family_id ?>/<?= $users['users_id'] ?>&choe=UTF-8" 
                                    style="margin: auto; border: 3px solid green; padding: 10px;display: block; margin-left: auto; margin-right: auto;">
                                    </div>
                    
                                                                                </th>
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            User Details
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>

                                <!-- <?php if (
                                    session()->get('login_data')['type_id'] ==
                                    '0'
                                ) { ?> -->

<a class="card-header-action" href="<?php echo site_url('users/edit') .
    '/' .
    $users['users_id']; ?>">
    <i class="cil-pencil c-icon"></i>
</a>
<!-- <?php } ?> -->
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
                                                            <!-- <tr>
                                                        <th>Balance : </th>
                                                        <th><?= $balance ?></th>
                                                        </tr> -->


                                                        <tr>

                                                        <th>
                                                            Status
                                                        </th>



                                                        <td>

                                                            <?php if (
                                                                session()->get(
                                                                    'login_data'
                                                                )['type_id'] ==
                                                                '0'
                                                            ) { ?>
            
                                                                    <?php if (
                                                                        $users[
                                                                            'is_verified'
                                                                        ] == 0
                                                                    ) { ?>
            
                                                                        <a href="<?= base_url() ?>/Users/verify_user/<?= $users[
    'users_id'
] ?>" class="btn btn-danger'">Not Verified</a>
                                                                    <?php } else { ?>
                                                                        <a  class="btn btn-success text-white">Verified</a>
            
                                                                    <?php } ?>
                                                            <?php } ?>
                                                            <?php if (
                                                                session()->get(
                                                                    'login_data'
                                                                )['type_id'] ==
                                                                '1'
                                                            ) { ?>
    
                                                                <?php if (
                                                                    $users[
                                                                        'is_verified'
                                                                    ] == 0
                                                                    
                                                                ) { ?>
    
                                                                    <a  class="btn btn-danger text-white">Not Verified</a>
                                                                <?php } else { ?>
                                                                    <a  class="btn btn-primary text-white">Verified</a>
    
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </td>



                                                        </tr>




                                                        <tr>
                                                        <th>Current Type</th>
                                                        <th>Level <?= $users['type_id'] + 8 ?> User</th>
                                                        </tr>

                                                        <tr>
                                                                    <th scope="row">User Type</th>
                                                                    <td>

                                                                        <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url('/Users/edit_type/' . "/" . $users['users_id']); ?>">
                                                                            <select name="type_id" class="form-control select2" id="">

                                                                                <option value="0" <?= $users['type_id'] == 0 ? 'selected' : '' ?>>Level 7 User</option>
                                                                                <option value="1" <?= $users['type_id'] == 1 ? 'selected' : '' ?>>Level 8 User</option>
                                                                                <option value="2" <?= $users['type_id'] == 2 ? 'selected' : '' ?>>Level 9 User</option>
                                                                                <option value="3" <?= $users['type_id'] == 3 ? 'selected' : '' ?>>Level 10 User</option>
                                                                                <option value="4" <?= $users['type_id'] == 4 ? 'selected' : '' ?>>Level 11 User</option>
                                                                                <option value="5" <?= $users['type_id'] == 5 ? 'selected' : '' ?>>Level 12 User</option>
                                                                                <!-- <option value="6" <?= $users['type_id'] == 6 ? 'selected' : '' ?>>Level 14 User</option> -->
                                                                                <!-- <option value="7" <?= $users['type_id'] == 7 ? 'selected' : '' ?>>Level 15 User</option> -->

                                                                            </select>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-primary float-right" type="submit"> Save</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>




                                                                <tr>
                                                        <th>User Address</th>
                                                        <th><?= $users['delivery_address'] ?></th>
                                                        </tr>
                                                            <tr>
                                                        <th>Last Edited By</th>
                                                        <th><?= $modified_by ?></th>
                                                        </tr>

                                                     

                                                            <tr>
                                                        <th>Family Tree</th>

                                                        <?php if (
                                                            $users[
                                                                'is_verified'
                                                            ] == 0
                                                        ) { ?>
                                                        
                                                        <th><a>Don Have Family Yet</a></th>

                                                        <?php } else { ?>

                                                            <th><a class="btn btn-primary" target="_blank" href="<?= base_url() ?>/users/tree/<?= $users[
    'users_id'
] ?>">View Tree</a></th>
                                                    <?php } ?>
                                                    
                                                        </tr>


                                                    

                                                                <tr>
                                                                    <th scope="row">Name</th>
                                                                    <td><?= $users[
                                                                        'name'
                                                                    ] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">email</th>
                                                                    <td><?= $users[
                                                                        
                                                                        'email'
                                                                    ] ?></td>
                                                                </tr>

                                                                
                                                                <tr>
                                                                    <th scope="row">Family Upline Name</th>
                                                                    <td><?= $users[
                                                                        'family_name'
                                                                    ] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Referral Name</th>
                                                                    <td><?= $users[
                                                                        'upline_name'
                                                                    ] ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Register Date</th>
                                                                    <td><?= $users[
                                                                        'created_date'
                                                                    ] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Paid Date </th>
                                                                    <td><?= $users[
                                                                        'paid_date'
                                                                    ] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Contact</th>
                                                                    <td><?= $users[
                                                                        'contact'
                                                                    ] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Receipt</th>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-xl-12">
                                                                                <a target="_blank" href="<?= base_url() .
                                                                                    $users[
                                                                                        'receipt'
                                                                                    ] ?>">

                                                                                    <img src="<?= base_url() .
                                                                                        $users[
                                                                                            'receipt'
                                                                                        ] ?>" width="200" class="img-fluid d-block m-auto" alt="">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <!-- <tr>
                                                                    <th scope="row">NRIC</th>
                                                                    <td><?= $users[
                                                                        'nric'
                                                                    ] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">NRIC Name</th>
                                                                    <td><?= $users[
                                                                        'nric_name'
                                                                    ] ?></td>
                                                                </tr>
                                                             
                                                               
                                                                <tr>
                                                                    <th scope="row">Nric back</th>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-xl-12">
                                                                            <a target="_blank" href="<?= base_url() .
                                                                                $users[
                                                                                    'nric_back'
                                                                                ] ?>">

                                                                                <img src="<?= base_url() .
                                                                                    $users[
                                                                                        'nric_back'
                                                                                    ] ?>" width="200" class="img-fluid d-block m-auto" alt="">
                                                                                </a>


                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr> -->
<!--                                                                
                                                              

    
    
    -->
    <tr>
        <th scope="row">Remarks</th>
        <td>

            <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url(
                '/users/add_remarks/' .
                    '/' .
                    $users[
                        'users_id'
                    ]
            ) ?>">
                <textarea name="remarks" id="" cols="30" rows="10" class="form-control"><?= $users[
                    'remarks'
                ] ?></textarea>
                <div class="form-group">

                    <button class="btn btn-primary float-right" type="submit"> Save</button>
                </div>
            </form>
        </td>
    </tr>

    <tr>
                                                        <th>- PAID OUT -</th>
                                                        <th>- PAID OUT -</th>
                                                        </tr>
    <tr>
                                                        <th>Normal Paidout</th>
                                                        <th><?= $users['commission_normal'] ?></th>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <th>Level overriding</th>
                                                            <th><?= $users['extra_commission'] ?></th>
                                                        </tr>
                                                        <tr>
                                                        <th>Total Paid Out</th>
                                                        <th><?= $users['total_commision'] ?></th>
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
                                <table class="table table-striped table-bordered no-footer datatable" id="wallet_list_table" data-method="get" data-url="<?= base_url(
                                    'wallet'
                                ) ?>" style="border-collapse: collapse !important">
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
                                        foreach ($wallet as $row) { ?>
                                            <tr>
                                            <td><?= $i ?></td>

                                            <td><?= $row['name'] ?></td>
                                    <td><?= $row['contact'] ?></td>
                                    <td><?= $row['transaction'] ?></td>
                                    <td><?= $row['remarks'] ?></td>
                                    <td><?= $row['created_date'] ?></td>
                                            </tr>
                                        <?php $i++;}
                                        ?>
                                    </tbody>
                                </table>
                              
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            </div>
