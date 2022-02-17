<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url(
                                                    'Auction'
                                                ) ?>">Auction</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/Auction/detail/<?= $auction['auction_id'] ?>">Auction Details</a></li>
    </ol>

</div>
<style>
    .coolBeans {
        border: 2px solid currentColor;
        border-radius: 1rem;
        color: blue;
        font-family: roboto;
        font-size: 1rem;
        font-weight: 100;
        overflow: hidden;
        padding: 7px;
        position: relative;
        text-decoration: none;
        transition: 0.2s transform ease-in-out;
        will-change: transform;
        margin: 6px;
        z-index: 0;
    }

    .coolBeans::after {
        background-color: lightblue;
        border-radius: 3rem;
        content: '';
        display: block;
        height: 100%;
        width: 100%;
        position: absolute;
        left: 0;
        top: 0;
        transform: translate(-100%, 0) rotate(10deg);
        transform-origin: top left;
        transition: 0.2s transform ease-out;
        will-change: transform;
        z-index: -1;
    }

    .coolBeans:hover::after {
        transform: translate(0, 0);
    }

    .coolBeans:hover {
        border: 2px solid transparent;
        color: white;
        transform: scale(1.05);
        will-change: transform;
    }
</style>
<style>
    * {
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    .a {
        margin: 10px auto;
        width: 100%;
        height: 50px;
        border-radius: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .a::before {
        content: attr(content);
        position: absolute;
        width: 345px;
        height: 45px;
        z-index: 1;
        background-color: #eee;
        border-radius: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        -ms-border-radius: 50px;
        -o-border-radius: 50px;
    }

    .a::after {
        content: "";
        width: 400px;
        height: 400px;
        position: absolute;
        border-radius: 50px;
        background: conic-gradient(#3a7cec 0%12.5%,
                #2ca24c 12.5%25%,
                #f1b500 25%37.5%,
                #e33e2b 37.5%50%,
                #3a7cec 50%62.5%,
                #2ca24c 62.5%75%,
                #f1b500 75%87.5%,
                #e33e2b 87.5%100%);
        animation: border-animation 5s linear infinite;
        -webkit-animation: border-animation 5s linear infinite;
    }

    @keyframes border-animation {
        to {
            transform: rotate(360deg);
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
        }
    }
</style>
<main class="c-main">

    <div class="container-fluid">

        <div class="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            Auction Info
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                                <!-- <a class="card-header-action" target="_blank" href="<?php echo base_url(
                                                                                        'Auction/edit'
                                                                                    ) .
                                                                                        '/' .
                                                                                        $auction['auction_id']; ?>">
                                    <button class="btn btn-warning"><i class="cil-pencil c-icon"></i>Edit</button></i>
                                </a> -->
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
                                                                    <th scope="row">Time Info</th>
                                                                    <td>
                                                                        <?php if($time_diff['years'] < 0){ ?>
                                                                            ENDED <?= $time_diff['days'] ?> days  <?= $time_diff['hours'] ?> Hour ago
                                                                        <?php }else{ ?>
                                                                            STARTED IN <?= $time_diff['days'] ?> days  <?= $time_diff['hours'] ?> Hour 

                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th>
                                                                        Auction Status For Seller
                                                                    </th>
                                                                    <td>

                                                                        <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url('/Auction/edit/' . "/" . $auction['auction_id']); ?>">

                                                                            <?= $form['auction_status_id'] ?>
                                                                            <input type="hidden" value="1" name="buyer_status">

                                                                            <input type="hidden" value="<?= $auction['auction_id'] ?>" name="auction_id">
                                                                            <div class="form-group">
                                                                                <button class="btn btn-primary float-right" type="submit"> Save</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Auction Status (For Buyer)</th>
                                                                    <td>

                                                                        <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url('/Auction/edit/' . "/" . $auction['auction_id']); ?>">
                                                                            <select name="status" class="form-control select2" id="">

                                                                                <option value="0" <?= $auction['status'] == 0 ? 'selected' : '' ?>>Pending</option>
                                                                                <option value="1" <?= $auction['status'] == 1 ? 'selected' : '' ?>>Submit Document</option>
                                                                                <option value="2" <?= $auction['status'] == 2 ? 'selected' : '' ?>>Ready To Collect</option>
                                                                                <option value="3" <?= $auction['status'] == 3 ? 'selected' : '' ?>>Completed</option>

                                                                            </select>
                                                                            <input type="hidden" value="1" name="buyer_status">

                                                                            <input type="hidden" value="<?= $auction['auction_id'] ?>" name="auction_id">
                                                                            <div class="form-group">
                                                                                <button class="btn btn-primary float-right" type="submit"> Save</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Upload Auction File</th>
                                                                    <td>

                                                                        <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url('/Auction/edit/' . "/" . $auction['auction_id']); ?>">
                                                                            <input type="file" class="form-control" name="collect_letter">
                                                                            <input type="hidden" value="<?= $auction['auction_id'] ?>" name="auction_id">
                                                                            <div class="form-group">
                                                                                <button class="btn btn-primary float-right" type="submit"> Save</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>



                                                                <tr>
                                                                    <th scope="row">Remarks</th>
                                                                    <td>

                                                                        <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url('/Auction/edit/' . "/" . $auction['auction_id']); ?>">
                                                                            <textarea name="remarks" id="" cols="30" rows="10" class="form-control"><?= $auction['remarks'] ?></textarea>
                                                                            <input type="hidden" value="<?= $auction['auction_id'] ?>" name="auction_id">
                                                                            <div class="form-group">
                                                                                <button class="btn btn-primary float-right" type="submit"> Save</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Success User</th>
                                                                    <td>
                                                                        <?php if ($auction['success_user_id'] > 0) { ?>

                                                                            <a class="a" content="<?= $auction["success_user"] ?>" target="_blank" href="<?= base_url() ?>/users/detail/<?= $auction['success_user_id'] ?>">
                                                                                <?= $auction["success_user"] ?>

                                                                            </a>
                                                                        <?php } else { ?>

                                                                            <a class="a" content="<?= $auction["success_user"] ?>">
                                                                                <?= $auction["success_user"] ?>

                                                                            </a>

                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Success Bid Price</th>
                                                                    <td>RM<?= $auction["success_bid_price"] ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Change Popular</th>
                                                                    <td>

                                                                        <a href="<?= base_url() ?>/Auction/change_popular/<?= $auction['auction_id'] ?>" class="btn btn-<?= $auction['is_popular'] == 1 ? 'success' : 'danger' ?>"><?= $auction['is_popular'] == 1 ? 'Popular' : 'Not popular' ?></a>
                                                                    </td>
                                                                </tr>



                                                                <tr>
                                                                    <th scope="row">Auction Status (For Seller)</th>
                                                                    <td>

                                                                        <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url('/Auction/edit_status/' . "/" . $auction['auction_id']); ?>">
                                                                            <select name="seller_status_id" class="form-control select2" id="">

                                                                                <option value="0" <?= $auction['seller_status_id'] == 0 ? 'selected' : '' ?>>Pending</option>
                                                                                <option value="1" <?= $auction['seller_status_id'] == 1 ? 'selected' : '' ?>>Accept</option>
                                                                                <option value="2" <?= $auction['seller_status_id'] == 2 ? 'selected' : '' ?>>Reject</option>
                                                                                <option value="3" <?= $auction['seller_status_id'] == 3 ? 'selected' : '' ?>>Rebid</option>
                                                                                <option value="4" <?= $auction['seller_status_id'] == 4 ? 'selected' : '' ?>>Withdraw</option>

                                                                            </select>

                                                                            <input type="hidden" value="<?= $auction['auction_id'] ?>" name="auction_id">
                                                                            <div class="form-group">
                                                                                <button class="btn btn-primary float-right" type="submit"> Save</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <th scope="row">Payment Method</th>
                                                                    <td>

                                                                        <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url('/Auction/edit_status/' . "/" . $auction['auction_id']); ?>">
                                                                            <select name="payment_method_id" class="form-control select2" id="">

                                                                                <option value="0" <?= $auction['payment_method_id'] == 0 ? 'selected' : '' ?>>Pending</option>
                                                                                <option value="1" <?= $auction['payment_method_id'] == 1 ? 'selected' : '' ?>>Cash</option>
                                                                                <option value="2" <?= $auction['payment_method_id'] == 2 ? 'selected' : '' ?>>Loan</option>

                                                                            </select>

                                                                            <input type="hidden" value="<?= $auction['auction_id'] ?>" name="auction_id">
                                                                            <div class="form-group">
                                                                                <button class="btn btn-primary float-right" type="submit"> Save</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>




<!-- 
                                                                <tr>

                                                                    <th scope="row">Seller Status</th>
                                                                    <td><?php
                                                                        if ($auction['seller_status_id'] == 0) {
                                                                            echo "Pending";
                                                                        } else if ($auction['seller_status_id'] == 1) {
                                                                            echo "Accept";
                                                                        } else {
                                                                            echo "Rejected";
                                                                        }
                                                                        ?></td>
                                                                </tr> -->

<!-- 
                                                                <tr>

                                                                    <th scope="row">Payment Method </th>
                                                                    <td><?php
                                                                        if ($auction['payment_method_id'] == 1) {
                                                                            echo "Cash";
                                                                        } else if ($auction['payment_method_id'] == 2) {
                                                                            echo "Loan";
                                                                        }

                                                                        ?></td>
                                                                </tr> -->

                                                                <tr>
                                                                    <th scope="row">Plate No (Click to go to view car)</th>
                                                                    <td>
                                                                        <a target="_blank" href="<?= base_url() ?>/car/detail/<?= $auction['car_id'] ?>">
                                                                            <?= $auction["lisence_plate_no"] ?>
                                                                        </a>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <th scope="row">Seller Info (Click to go to view seller)</th>
                                                                    <td>
                                                                        <a target="_blank" href="<?= base_url() ?>/users/detail/<?= $auction['seller_id'] ?>">
                                                                            <?= $auction["username"] ?>
                                                                        </a>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Model</th>
                                                                    <td><?= $auction["model"] ?></td>
                                                                </tr>
                                                                <!-- <tr>
                                                                <th scope="row">Payment Method </th>
                                                                <td><?= $auction["payment_method_id"] == 0 ? 'Cash' : 'Loan' ?></td>
                                                            </tr> -->
                                                                <tr>
                                                                    <th scope="row">Auction Status</th>
                                                                    <td><?= $auction["auction_status"] ?></td>
                                                                </tr>

                                                                <!-- <tr>
                                                                    <?php if ($auction['payment_method_id'] > 0) { ?>
                                                                    <th scope="row">Payment method </th>
                                                                    <td><?= $auction["payment_method_id"] == 1  ? "Pay by cash" : "Apply Loan" ?></td>
                                                                    <?php } ?>
                                                                </tr> -->


                                                                <?php if ($auction['collect_letter'] != '') { ?>

                                                                    <tr>
                                                                        <th>Download Collect Letter</th>
                                                                        <td>
                                                                            <a href="<?= $auction['collect_letter'] ?>" download class="btn btn-primary">Download</a>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>

                                                                <tr>
                                                                    <th scope="row">Start Date</th>
                                                                    <td><?= $auction["date"] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Start TIME</th>
                                                                    <td><?= $auction["start_time"] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Expected Price</th>
                                                                    <td><?= $auction["expected_price"] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">End Time</th>
                                                                    <td><?= $auction["end_time"] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Start Price</th>
                                                                    <td><?= $auction["starting_price"] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Deposit Amount (RM)</th>
                                                                    <td><?= $auction['deposit_amount'] ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Last Edited By</th>
                                                                    <td><?= $modified_by ?></td>
                                                                </tr>
                                                                <?php if ($auction['success_user_id'] == 0) { ?>

                                                                    <tr>
                                                                        <th>Repeat</th>
                                                                        <td>


                                                                    <a class="btn btn-primary" href="<?= base_url() ?>/Auction/add?car_id=<?= $auction['car_id'] ?>">Rebid Auction</a>
                                                                    </td>
                                                                    </tr>
                                                                <?php } ?>

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
                        <div class="card-header">
                            Auction Increment Price
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                                <a class="card-header-action" class="btn btn-primary" data-toggle="modal" data-target="#modal_auction">
                                    <i class="cil-plus c-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered no-footer datatable5" id="auction_list_table" data-method="get" data-url="<?= base_url("auction") ?>" style="border-collapse: collapse !important">
                                                <?= $table_increment ?>
                                            </table>

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
                            Auction Bid List
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>

                            </div>
                        </div>
                        <div class="card-body">
                            <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered no-footer datatable" id="auction_list_table" data-method="get" data-url="<?= base_url("auction") ?>" style="border-collapse: collapse !important">
                                                <?= $table_bid ?>
                                            </table>

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
                            Auction Wishlist User
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
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
                                                        <th data-filter="auctionname">Contact</th>
                                                        <th data-filter="contact">User name</th>
                                                        <th data-filter="email">Created Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    //                                             No
                                                    // ID
                                                    // Plate No
                                                    // Brand
                                                    // Model 
                                                    // Variant
                                                    // Year
                                                    // State
                                                    // Area
                                                    // Chassis No
                                                    // Created Date
                                                    // Modified Date
                                                    foreach ($auction_wishlist as $row) {
                                                    ?>
                                                        <tr>

                                                            <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['contact'] ?></a></td>

                                                            <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['username'] ?></a></td>
                                                            <td><a href="<?= base_url() ?>/users/detail/<?= $row['users_id'] ?>"><?= $row['created_date'] ?></a></td>
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
                <?= $modal_auction_increment ?>