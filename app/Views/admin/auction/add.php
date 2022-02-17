<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>/Auction">Auction</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>Auction/add">Create New Auction</a></li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Create New Auction
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url('/Auction/add'); ?>">
                                <!-- <div class="form-group">
                                <label for="">Profile Picture</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                </div>
                            </div> -->
                                <?php if (isset($error)) { ?>
                                    <div class="alert-message" role="alert">
                                        <?= $error; ?>
                                    </div>
                                <?php } ?>
                             
                                <div class="form-group">
                                    <label for="">Auction Time
                                        <br>
                                    <a href="<?= base_url() ?>/AuctionSection/add" target="_blank">Add new Time</a>
                                    </label>
                                    <select name="auction_section_id" class="select2 form-control" id=""  required>
                                        <?php foreach($auction_section as $row){ ?>
                                        <option value="<?= $row['auction_section_id'] ?>"> <?= $row['date'] ?> <?= $row['start_time'] ?> - <?= $row['end_time'] ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="">Car 
                                    </label>
                                    <select name="car_id" class="select2 form-control" id=""  required>
                                        <?php foreach($car as $row){ 
                                            ?>
                                            <?php if(isset($_GET['car_id']) && $_GET['car_id'] == $row['car_id']){ ?>
                                                <option value="<?= $row['car_id'] ?>" selected> <?= $row['brand'] ?> <?= $row['model'] ?> <?= $row['variant'] ?> (<?= $row['year'] ?>)  - <?= $row['lisence_plate_no'] ?></option>
                                            <?php }else{ ?>
                                                <option value="<?= $row['car_id'] ?>"> <?= $row['brand'] ?> <?= $row['model'] ?> <?= $row['variant'] ?> (<?= $row['year'] ?>)  - <?= $row['lisence_plate_no'] ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?= $form['starting_price'] ?>
                                
                          
                                <!-- <?= $form['auction_status_id'] ?> -->

                                <?= $form['expected_price'] ?>
                                <!-- <?= $form['deposit_amount'] ?> -->
                             
                                <!-- <?= $form['auction_section_id'] ?> -->

                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="submit"> Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>