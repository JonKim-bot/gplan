
<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
		<li class="breadcrumb-item active"><a href="<?= base_url() ?>/Car">Car</a></li>
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
                Cars
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                    <a class="card-header-action" href="<?= base_url() ?>/Car/add">
                        <i class="cil-plus c-icon"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped datatable table-bordered no-footer " id="car_list_table" data-method="get" data-url="<?= base_url("Car") ?>" style="border-collapse: collapse !important">
                                    <!-- <?= $table ?> -->
                                    <thead>
                                         <tr role="row">
                                             
                                            <th>No</th>
                                            <th data-filter="auctionname">Car Id</th>
                                            <th data-filter="contact">Plate No</th>
                                            <th data-filter="email">Brand</th>
                                            <th data-filter="email">Model</th>
                                            <th data-filter="email">Variant</th>
                                            <th data-filter="email">Year</th>
                                            <th data-filter="email">Color</th>

                                            <th data-filter="email">State</th>
                                            <th data-filter="email">Area</th>
                                            <th data-filter="email">Chasis No</th>
                                            <th data-filter="email">Created Date</th>
                                            <th data-filter="email">Modified Date</th>
                                            <th data-filter="email">Copy</th>

                                            <th data-filter="email">Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            foreach($car as $row){
                                         ?>
                                        <tr>
                                        <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $i ?></a></td>

                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['car_id'] ?></a></td>
                                                
                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['lisence_plate_no'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['brand'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['model'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['variant'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['manufactured_year'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['color'] ?></a></td>

                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['state'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['area'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['chassis_no'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['created_date'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/car/detail/<?= $row['car_id']?>"><?= $row['modified_date'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/car/copy/<?= $row['car_id']?>" class="btn btn-success">Copy</a></td>
                                                <td><a href="<?= base_url() ?>/car/delete/<?= $row['car_id']?>" class="btn btn-danger delete-button">Delete</a></td>

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