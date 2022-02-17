<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/BestOffer">BestOffer</a></li>
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
                    BestOffers
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
                                    <table class="table table-striped datatable table-bordered no-footer " id="best_offer_list_table" data-method="get" data-url="<?= base_url("BestOffer") ?>" style="border-collapse: collapse !important">
                                        <thead>
                                            <tr role="row">
                                                <th>No.</th>
                                                <th data-sort="" data-filter="">Read / Unread</th>
                                                <th data-sort="" data-filter="">Name</th>
                                                <th data-sort="" data-filter="">Contact</th>
                                                <th data-sort="" data-filter="">Email</th>
                                                <th data-sort="" data-filter="">Brand</th>
                                                <th data-sort="" data-filter="">Model</th>
                                                <th data-sort="" data-filter="">Year</th>
                                                <th data-sort="" data-filter="">Submitted Date</th>
                                                <th data-sort="" data-filter="">Modified Date</th>
                                                <th data-sort="" data-filter="">Remark</th>

                        
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($best_offer as $row) {
                                            ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><a href="<?= base_url() ?>/BestOffer/detail/<?= $row['best_offer_id'] ?>"><?= $row['is_read'] == 1 ? 'READED' : 'NOT READED' ?></a></td>
                                                    <td><a href="<?= base_url() ?>/BestOffer/detail/<?= $row['best_offer_id'] ?>"><?= $row['name'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/BestOffer/detail/<?= $row['best_offer_id'] ?>"><?= $row['contact'] ?></td>
                                                    <td><a href="<?= base_url() ?>/BestOffer/detail/<?= $row['best_offer_id'] ?>"><?= $row['email'] ?></td>
                                                    <td><a href="<?= base_url() ?>/BestOffer/detail/<?= $row['best_offer_id'] ?>"><?= $row['brand'] ?></td>
                                                    <td><a href="<?= base_url() ?>/BestOffer/detail/<?= $row['best_offer_id'] ?>"><?= $row['model'] ?></td>
                                                    <td><a href="<?= base_url() ?>/BestOffer/detail/<?= $row['best_offer_id'] ?>"><?= $row['year'] ?></td>
                                                    <td><a href="<?= base_url() ?>/BestOffer/detail/<?= $row['best_offer_id'] ?>"><?= $row['created_date'] ?></td>
                                                    <td><a href="<?= base_url() ?>/BestOffer/detail/<?= $row['best_offer_id'] ?>"><?= $row['modified_date'] ?></td>
                                                    <td><a href="<?= base_url() ?>/BestOffer/detail/<?= $row['best_offer_id'] ?>"><?= $row['remarks'] ?></td>
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