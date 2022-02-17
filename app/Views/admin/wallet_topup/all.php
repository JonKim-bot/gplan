
<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
		<li class="breadcrumb-item active"><a href="<?= base_url() ?>/WalletTopup">WalletTopup</a></li>
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
                WalletTopups
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                    <a class="card-header-action" href="<?= base_url() ?>/Topup/add">
                        <i class="cil-plus c-icon"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped datatable table-bordered no-footer " id="wallet_topup_list_table" data-method="get" data-url="<?= base_url("WalletTopup") ?>" style="border-collapse: collapse !important">
                                <thead>
                                        <tr role="row">
                                            <th>No.</th>
                                            <th data-sort="name" data-filter="name">User Id</th>

                                            <th data-sort="name" data-filter="name">User Name</th>
                                            <th data-sort="name" data-filter="name">Amount</th>
                                            <th data-sort="name" data-filter="name">Create Date</th>
                                            <th data-sort="name" data-filter="name">Remarks</th>
                                            <th data-sort="name" data-filter="name">Status</th>
                                            <th data-sort="name" data-filter="name">Permission Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            foreach($wallet_topup as $row){
                                         ?>
                                            <tr>
                                                
                                                <td><a href="<?= base_url() ?>/topup/detail/<?= $row['users']?>"><?= $i ?></a></td>
                                             
                                                
                                                <td><a href="<?= base_url() ?>/topup/detail/<?= $row['wallet_topup_id']?>"><?= $row['users_id'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/topup/detail/<?= $row['wallet_topup_id']?>"><?= $row['users'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/topup/detail/<?= $row['wallet_topup_id']?>"><?= $row['amount'] ?></a></td>

                                                <td><a href="<?= base_url() ?>/topup/detail/<?= $row['wallet_topup_id']?>"><?= $row['created_date'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/topup/detail/<?= $row['wallet_topup_id']?>"><?= $row['remarks'] ?></a></td>

                                                <!-- <td><a href="<?= base_url() ?>/topup/detail/<?= $row['wallet_topup_id']?>">
                                                <img src="<?= $row['receipt']; ?>" width="200" class="img-fluid d-block m-auto" alt="">
                                                </a></td>
                                                <td><a href="<?= base_url() ?>/topup/detail/<?= $row['wallet_topup_id']?>"><?= $row['amount'] ?></a></td> -->
                                                <!-- <td><?= $row['remarks'] ?></td> -->
                                               
                                                <td>
                                            <?php if($row['is_approved'] == 0 && $row['is_rejected'] == 0){ ?>
                                                <a class="btn btn-success" href="<?= base_url("Topup/approve/") . "/" . $row['wallet_topup_id'] ?>">Approve</a>
                                                <a class="btn btn-danger" href="<?= base_url("Topup/reject/") . "/" . $row['wallet_topup_id'] ?>">Reject</a>
                                            <?php }else{ ?>
                                                <?php if($row['is_approved'] == 1) { ?>
                                                    Approved
                                                <?php } ?>

                                                <?php if($row['is_rejected'] == 1) { ?>
                                                    Rejected
                                                <?php } ?>

                                            <?php } ?>
                                            <td><a href="<?= base_url() ?>/topup/detail/<?= $row['wallet_topup_id']?>"><?= $row['modified_date'] ?></a></td>

                                        
                                            </td>
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