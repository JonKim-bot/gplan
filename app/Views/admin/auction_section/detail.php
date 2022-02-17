<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url(
                                                    'AuctionSection'
                                                ) ?>">AuctionSection</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/AuctionSection/detail/<?= $auction_section['auction_section_id'] ?>">AuctionSection Details</a></li>
    </ol>

</div>

<div class="modal fade" id="auctionSectionModel" role="dialog" aria-labelledby="car_detail_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalAddLabel">Add Auction Inside This Section ! </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="POST" action="<?= base_url("Auction/edit_auction_section"); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Auction On Car
                        </label>
                        <select name="auction_id" class="select2 form-control" id="" required>
                            <?php foreach ($auction as $row) { ?>
                                <option value="<?= $row['auction_id'] ?>"><?= $row['brand'] ?> <?= $row['model'] ?> <?= $row['variant'] ?> - <?= $row['lisence_plate_no'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" class="auction_section_id" name="auction_section_id" value="<?= $auction_section['auction_section_id'] ?>">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
<main class="c-main">

    <div class="container-fluid">

        <div class="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            AuctionSection Info
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>

                                <a class="card-header-action" href="<?php echo site_url(
                                                                        'AuctionSection/edit'
                                                                    ) .
                                                                        '/' .
                                                                        $auction_section['auction_section_id']; ?>">
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
                        <div class="card-header">
                            Auction Details
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                                <a class="card-header-action" class="btn btn-primary" data-toggle="modal" data-target="#auctionSectionModel">
                                    <i class="cil-plus c-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered no-footer datatable" id="auction_list_table" data-method="get" data-url="<?= base_url("auction") ?>" style="border-collapse: collapse !important">
                                                <thead>
                                                    <tr role="row">
                                                        <th>No.</th>
                                                        <th data-filter="auctionname">Model</th>
                                                        <th data-filter="contact">Auction Status</th>
                                                        <th data-filter="contact">Success User</th>

                                                        <th data-filter="contact">Plate No</th>

                                                        <th data-filter="email"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($auction_to_loop as $row) {
                                                    ?>
                                                        <tr>

                                                            <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id'] ?>"><?= $i ?></a></td>

                                                            <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id'] ?>"><?= $row['brand'] ?> <?= $row['model'] ?> <?= $row['variant'] ?></a></td>
                                                            <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id'] ?>"> <?= $row['auction_status'] ?></a></td>
                                                            <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id'] ?>"> <?= $row['success_user'] ?></a></td>

                                                            <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id'] ?>"><?= $row['lisence_plate_no'] ?></a></td>
                                                            <td><a href="<?= base_url() ?>/auction/delete_auction_section/<?= $row['auction_id'] ?>" class="btn btn-danger delete-button"><i class="fa fa-trash"></i> Unlink</a></td>
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
                </div>