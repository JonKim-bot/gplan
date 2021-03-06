<div class="c-subheader justify-content-between px-3">

    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/users">User</a></li>
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
            <div class="card">
                <div class="card-header">
                    User Details
                    <div class="card-header-actions">
                        <a class="card-header-action">
                            <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                        </a>
                        <a class="card-header-action" href="<?= base_url() ?>/users/add">
                            <i class="cil-plus c-icon"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                    <form method="GET" id="filter_form">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-3">
                                <label for="" class="c-label">Date From</label>
                                <br>
                                <input type="date" class="form-control filter" name="dateFrom" 
                                value="<?=  ($_GET and
                            isset($_GET['dateFrom']))
                                ? $_GET['dateFrom']

                                : date('Y-m-d') ?>"
                                >
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label for="" class="c-label">Date To</label>
                                <br>
                                <input type="date" class="form-control filter" name="dateTo" value="<?= $dateTo ?>">
                            </div>

                        </div>
                    </form>
                        <div class="row">
                            <div class="col-sm-12">
                                <p>Total Users : <?= $users_count ?></p>

                                <p>Total Collection : RM <?= $total ?></p>


                                <p>Total PaidOut : RM <?= $users_wallet ?></p>


                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered no-footer datatable" id="users_list_table" data-method="get" data-url="<?= base_url("users") ?>" style="border-collapse: collapse !important">
                                        <thead>
                                            <tr role="row">
                                                <th>No.</th>
                                                <!-- <th data-filter="usersname">User ID</th> -->
                                                <th data-filter="usersname">User Name</th>
                                                <th data-filter="usersname">Contact</th>
                                                <th data-filter="email">Email</th>
                                                <!-- <th data-filter="email">Family Name</th>
                                                <th data-filter="email">Teacher Name</th> -->

                                                <th data-filter="email">Family Tree</th>
                                                <th data-filter="email">Direct Tree</th>
                                                
                                                
                                                <th>Verify Status</th>
                                                <th>Paid Status</th>
                                                <th data-filter="email">Created Date </th>
                                                <th data-filter="email">Paid Date</th>

                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($users as $row) {
                                            ?>
                                                <tr>

                                                    <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $i ?></a></td>
                                                    <!-- <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['users_id'] ?></a></td> -->

                                                    <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['name'] ?></a></td>

                                                    <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['contact'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['email'] ?></a></td>
                                                    <!-- <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['family_name'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['upline_name'] ?></a></td> -->

                                                    <td>
                                                    <?php if($row['is_verified'] == 0){ ?>
                                                        <a>Don Have Family Yet</a>

                                                        <?php }else{ ?>
                                                            <a class="btn btn-primary" target="_blank" href="<?= base_url() ?>/users/tree/<?= $row['users_id'] ?>">View Tree</a>

                                                    <?php } ?>
                                                    </td>

                                                    <td>
                                                    <?php if($row['is_verified'] == 0){ ?>
                                                        <a>Don Have Tree Yet</a>

                                                        <?php }else{ ?>
                                                            <a class="btn btn-primary" target="_blank" href="<?= base_url() ?>/users/direct_tree/<?= $row['users_id'] ?>">View Direct Sponsor Tree</a>

                                                    <?php } ?>
                                                    </td>


                                                    <?php if($row['is_verified'] == 0){ ?>
                                                    <td><a href="<?= base_url() ?>/Users/verify_user/<?= $row['users_id'] ?>" class="btn btn-<?= $row['is_verified'] == 1 ? "success" : "danger" ?>"><?= $row['is_verified'] == 1 ? "Verified" : "Mark as verify" ?></a></td>
                                                    <?php }else{ ?>
                                                        <td>Verified</td>
                                                    <?php } ?>
                                                    
                                                    <?php if($row['is_paid'] == 0){ ?>
                                                    <td><a href="<?= base_url() ?>/Users/set_paid/<?= $row['users_id'] ?>" class="btn btn-<?= $row['is_paid'] == 1 ? "success" : "danger" ?>"><?= $row['is_paid'] == 1 ? "Paid" : "Mark as paid" ?></a></td>
                                                    <?php }else{ ?>
                                                        <td>Paid</td>
                                                    <?php } ?>
                                          
                                                    <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['created_date'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['paid_date'] ?></a></td>

                                                    <td><a href="<?= base_url() ?>/users/delete/<?= $row['users_id'] ?>" class="btn btn-danger delete-button"><i class="fa fa-trash"></i> Delete</a></td>
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


       
            
        <script>
            
            $(document).on("change", ".filter", function (e) {
            
            $('#filter_form').submit();
            });
            
                    </script>
                    