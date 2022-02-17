<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url(
                                                    'BestOffer'
                                                ) ?>">BestOffer</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/BestOffer/detail/<?= $best_offer['best_offer_id'] ?>">BestOffer Details</a></li>
    </ol>

</div>

<main class="c-main">

    <div class="container-fluid">

        <div class="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            BestOffer Info
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                                <a class="card-header-action" href="<?php echo site_url(
                                                                        'BestOffer/edit'
                                                                    ) .
                                                                        '/' .
                                                                        $best_offer['best_offer_id']; ?>">
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
                                                    <tbody>
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Read / Unread</th>
                                                            <td><?= $best_offer["is_read"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Name</th>
                                                            <td><?= $best_offer["name"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Contact</th>
                                                            <td><?= $best_offer["contact"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Email</th>
                                                            <td><?= $best_offer["email"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Brand</th>
                                                            <td><?= $best_offer["brand"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Model</th>
                                                            <td><?= $best_offer["model"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Year</th>
                                                            <td><?= $best_offer["year"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Submitted Date</th>
                                                            <td><?= $best_offer["created_date"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Modified Date</th>
                                                            <td><?= $best_offer["modified_date"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Remark</th>
                                                            <td><?= $best_offer["remarks"] ?></td>
                                                        </tr>
                                                    </tbody>

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
                <div class="col-md-6">
                    <div class="card">

                    </div>
                </div>
            </div>