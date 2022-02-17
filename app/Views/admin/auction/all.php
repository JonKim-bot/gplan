
<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
		<li class="breadcrumb-item active"><a href="<?= base_url() ?>/Auction">Auction</a></li>
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
                Auctions
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                    <a class="card-header-action" href="<?= base_url() ?>/Auction/add">
                        <i class="cil-plus c-icon"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                <form method="GET" id="filter_form">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-3">
                                <label for="" class="c-label">Auction Status</label>
                                <select class="form-control filter" name="auction_status_id">
                                    <option value="0">All</option>
                                    <?php foreach($auction_status as $row){ ?>
                                        <?php if(isset($_GET['auction_status_id']) && $_GET['auction_status_id'] == $row['auction_status_id']){ ?>
                                            <option value="<?= $row['auction_status_id'] ?>" selected><?= $row['name'] ?></option>

                                        <?php }else{ ?>

                                            <option value="<?= $row['auction_status_id'] ?>"><?= $row['name'] ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>


                            <div class="form-group col-sm-12 col-md-3">
                                <label for="" class="c-label">Seller Status (Accept / Reject / Rebid / Withdraw)</label>

                                <select class="form-control filter" name="seller_status_id">
                                    <option value="0" <?= isset($_GET['seller_status_id']) && $_GET['seller_status_id'] == 0 ? 'selected' : '' ?>>All</option>
                                    <option value="1" <?= isset($_GET['seller_status_id']) && $_GET['seller_status_id'] == 1 ? 'selected' : '' ?>>Accept</option>
                                    <option value="2" <?= isset($_GET['seller_status_id']) && $_GET['seller_status_id'] == 2 ? 'selected' : '' ?>>Reject</option>
                                    <option value="3" <?= isset($_GET['seller_status_id']) && $_GET['seller_status_id'] == 3 ? 'selected' : '' ?>>Rebid</option>
                                    <option value="4" <?= isset($_GET['seller_status_id']) && $_GET['seller_status_id'] == 4 ? 'selected' : '' ?>>Withdraw</option>
                                </select>
                            </div>

                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped datatable table-bordered no-footer " id="auction_list_table" data-method="get" data-url="<?= base_url("Auction") ?>" style="border-collapse: collapse !important">
                                    <!-- <?= $table ?> -->

                                    <thead>
                                         <tr role="row">
                                             
                                            <th>No</th>
                                            <th data-filter="auctionname">Auction Date</th>
                                            <th data-filter="contact">Auction Status</th>
                                            <th data-filter="contact">Success Bid Price</th>

                                            <th data-filter="email">Auction time</th>

                                            <th data-filter="email">Seller Status</th>
                                            <th data-filter="email">Car ID</th>
                                            <th data-filter="email">Brand</th>
                                            <th data-filter="email">Model</th>
                                            <th data-filter="email">Plate No</th>
                                            <th data-filter="email">Starting Price</th>
                                            <th data-filter="email">Expected Price</th>
                                            <th data-filter="email">Seller Name</th>
                                            <th data-filter="email">Remarks</th>

                                            <th data-filter="email">Created Date</th>
                                            <th data-filter="email">Modified Date</th>
                                            <th data-filter="email">Copy</th>

                                            <th data-filter="email">Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            foreach($auction as $row){
                                         ?>
                                        <tr>
                                        <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $i ?></a></td>

                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['date'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['auction_status'] ?> 
                                     
                                            
                                            </a></td>

                                            <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['success_bid_price'] ?> 
                                     </a></td>


                                            <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>">
                                            <?php if($row['time_diff']['years'] < 0){ ?>

ENDED <?= $row['time_diff']['days'] ?> days  <?= $row['time_diff']['hours'] ?> Hour ago
<?php }else{ ?>
STARTED IN <?= $row['time_diff']['days'] ?> days  <?= $row['time_diff']['hours'] ?> Hour 

<?php } ?>

                                        
                                        </a></td>


                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['seller_status'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['car_id'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['brand'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['model'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['plate_no'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['starting_price'] ?></a></td>

                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['expected_price'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['username'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['remarks'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['created_date'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/auction/detail/<?= $row['auction_id']?>"><?= $row['modified_date'] ?></a></td>

                                                <td><a href="<?= base_url() ?>/auction/copy/<?= $row['auction_id']?>" class="btn btn-success">Copy</a></td>
                                                <td><a href="<?= base_url() ?>/auction/delete/<?= $row['auction_id']?>" class="btn btn-danger delete-button">Delete</a></td>

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

        <script>
            
$(document).on("change", ".filter", function (e) {

$('#filter_form').submit();
});

        </script>