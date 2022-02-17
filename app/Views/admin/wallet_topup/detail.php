<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url(
                                                    'Topup'
                                                ) ?>">WalletTopup</a></li>

    </ol>

</div>

<main class="c-main">

    <div class="container-fluid">

        <div class="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            WalletTopup Info
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
                                        <div class="general-info mb-5">

                                            <div class="table-responsive">
                                                <table class="table">
                                                <tr>
                                                        <th scope="row">Last Edited By</th>
                                                        <td><?= $modified_by ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>User Id</td>
                                                        <td><?= $wallet_topup['users_id'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>User Name</td>
                                                        <td><?= $wallet_topup['users'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Amount</td>
                                                        <td><?= $wallet_topup['amount'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>User Submit Date</td>
                                                        <td><?= $wallet_topup['created_date'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>
                                                            <?php if ($wallet_topup['is_approved'] == 1) { ?>
                                                                Approved
                                                            <?php } ?>

                                                            <?php if ($wallet_topup['is_rejected'] == 1) { ?>
                                                                Rejected
                                                            <?php } ?>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Modified Date</td>
                                                        <td><?= $wallet_topup['modified_date'] ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Receipt</td>
                                                        <td>
                                                            <a target="_blank" href="<?= $wallet_topup['receipt'] ?>">

                                                                <img src="<?= $wallet_topup['receipt'] ?>" witdh="200px" alt="">
                                                            </a>
                                                        </td>
                                                    </tr>


                                                    <!-- <?= $detail ?> -->

                                                    <!-- <a target="_blank" href="<?= $wallet_topup['receipt'] ?>"> -->


                                                    </a>
                                                </table>
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

                    </div>
                </div>
            </div>