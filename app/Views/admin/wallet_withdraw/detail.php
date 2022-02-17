<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url(
                                                    'WalletWithdraw'
                                                ) ?>">WalletWithdraw</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/WalletWithdraw/detail/<?= $wallet_withdraw['wallet_withdraw_id'] ?>">WalletWithdraw Details</a></li>
    </ol>

</div>

<main class="c-main">

    <div class="container-fluid">

        <div class="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            WalletWithdraw Info
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                                <a class="card-header-action" href="<?php echo site_url(
                                                                        'WalletWithdraw/edit'
                                                                    ) .
                                                                        '/' .
                                                                        $wallet_withdraw['wallet_withdraw_id']; ?>">
                                    <button class="btn btn-warning"><i class="cil-pencil c-icon"></i>Edit</button></i>
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
                                                        <th>Last Edited By</th>
                                                        <th><?= $modified_by ?></th>
                                                    </tr>

                                                    <?= $detail ?>
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