<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/GetInTouch">GetInTouch</a></li>
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
                    GetInTouchs
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
                                    <table class="table table-striped datatable table-bordered no-footer " id="get_in_touch_list_table" data-method="get" data-url="<?= base_url("GetInTouch") ?>" style="border-collapse: collapse !important">

                                        <thead>
                                            <tr role="row">
                                                <th>No.</th>
                                                <th data-sort="" data-filter="">Name</th>
                                                <th data-sort="" data-filter="">Contact</th>
                                                <th data-sort="" data-filter="">Email</th>
                                                <th data-sort="" data-filter="">Message</th>
                                                <th data-sort="" data-filter="">Modified Date</th>
                                                <th data-sort="" data-filter="">Submitted Date</th>
                                                <th data-sort="" data-filter="">Read / Unread</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($get_in_touch as $row) {
                                            ?>
                                                <tr>
                                                    <td><a href="<?= base_url() ?>/GetInTouch/detail/<?= $row['get_in_touch_id'] ?>"><?= $i ?></a></td>
                                                    <td><a href="<?= base_url() ?>/GetInTouch/detail/<?= $row['get_in_touch_id'] ?>"><?= $row['name'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/GetInTouch/detail/<?= $row['get_in_touch_id'] ?>"><?= $row['contact'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/GetInTouch/detail/<?= $row['get_in_touch_id'] ?>"><?= $row['email'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/GetInTouch/detail/<?= $row['get_in_touch_id'] ?>"><?= $row['message'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/GetInTouch/detail/<?= $row['get_in_touch_id'] ?>"><?= $row['modified_date'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/GetInTouch/detail/<?= $row['get_in_touch_id'] ?>"><?= $row['created_date'] ?></a></td>
                                                    <td><a href="<?= base_url() ?>/GetInTouch/detail/<?= $row['get_in_touch_id'] ?>"><?= $row['is_read'] == 1 ? 'READ' : 'NOT READED    ' ?></a></td>

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