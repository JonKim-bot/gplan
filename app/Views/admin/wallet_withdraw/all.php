<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/WalletWithdraw">WalletWithdraw</a></li>
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
                    WalletWithdraws
                    <div class="card-header-actions">
                        <a class="card-header-action">
                            <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                        </a>
                        <a class="card-header-action" href="<?= base_url() ?>/Withdraw/add">
                        <i class="cil-plus c-icon"></i>
                    </a>

                    </div>
                </div>
                <div class="card-body">
                    <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-striped datatable table-bordered no-footer " id="wallet_withdraw_list_table" data-method="get" data-url="<?= base_url("WalletWithdraw") ?>" style="border-collapse: collapse !important">
                                        <thead>
                                            <tr role="row">
                                                <th>No.</th>
                                                <th data-filter="name">User ID</th>

                                                <th data-filter="name">User Name</th>
                                                <th data-sort="" data-filter="">Amount Withdraw</th>
                                                <th data-sort="" data-filter="">Bank Acc</th>
                                                <th data-sort="" data-filter="">Bank Name</th>
                                                <th data-sort="" data-filter="">Bank Holder Name</th>
                                                <th>Submitted Date</th>
                                                <!-- <th data-sort="contact" data-filter="contact">Contact</th> -->
                                                <!-- <th data-sort="" data-filter="">Is Approve</th>
                                                <th data-sort="" data-filter="">Is Rejeceted</th> -->
                                                <th>Status</th>
                                                <th data-sort="name" data-filter="name">Permission Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($wallet_withdraw as $row) {
                                            ?>
                                                <tr>
                                                    <td><a href="<?= base_url() ?>/Withdraw/detail/<?= $row['wallet_withdraw_id'] ?>"><?= $i ?></a></td>
                                                    <td><a href="<?= base_url() ?>/Withdraw/detail/<?= $row['wallet_withdraw_id'] ?>"><?= $row['users_id'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/Withdraw/detail/<?= $row['wallet_withdraw_id'] ?>"><?= $row['users'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/Withdraw/detail/<?= $row['wallet_withdraw_id'] ?>"><?= $row['amount'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/Withdraw/detail/<?= $row['wallet_withdraw_id'] ?>"><?= $row['bank_acc'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/Withdraw/detail/<?= $row['wallet_withdraw_id'] ?>"><?= $row['bank_name'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/Withdraw/detail/<?= $row['wallet_withdraw_id'] ?>"><?= $row['acc_name'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/Withdraw/detail/<?= $row['wallet_withdraw_id'] ?>"><?= $row['created_date'] ?></a></td>

                                                    <!-- <td><?= $row['contact'] ?></td> -->


                                                    <!-- <td><?= $row['is_approved'] == 1 ? "YES" : "NO" ?></td>
                                                    <td><?= $row['is_rejected'] == 1 ? "YES" : "NO" ?></td> -->

                                                    <td>
                                                        <?php if ($row['is_approved'] == 0 && $row['is_rejected'] == 0) { ?>
                                                            <a class="btn btn-success" href="<?= base_url("Withdraw/approve/") . "/" . $row['wallet_withdraw_id'] ?>">Approve</a>
                                                            <a class="btn btn-danger" href="<?= base_url("Withdraw/reject/") . "/" . $row['wallet_withdraw_id'] ?>">Reject</a>
                                                        <?php } else { ?>
                                                            <?php if ($row['is_approved'] == 1) { ?>
                                                                Approved
                                                            <?php } ?>

                                                            <?php if ($row['is_rejected'] == 1) { ?>
                                                                Rejected
                                                            <?php } ?>

                                                        <?php } ?>
                                                    </td>

                                                    <td><a href="<?= base_url() ?>/Withdraw/detail/<?= $row['wallet_withdraw_id'] ?>"><?= $row['modified_date'] ?></a></td>
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

            </script>