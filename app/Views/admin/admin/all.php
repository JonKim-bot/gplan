

<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
		<li class="breadcrumb-item active"><a href="<?= base_url() ?>/admin">Admin</a></li>
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
                Admin Details
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                    <a class="card-header-action" href="<?= base_url() ?>/admin/add">
                        <i class="cil-plus c-icon"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered no-footer datatable" id="admin_list_table" data-method="get" data-url="<?= base_url("admin") ?>" style="border-collapse: collapse !important">
                                    <thead>
                                        <tr role="row">
                                            <th>No.</th>
                                            <th data-filter="name">Name</th>
                                            <th data-filter="contact">Contact</th>
                                            <th data-filter="email">Email</th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            foreach($admin as $row){
                                         ?>
                                            <tr>
                                                
                                                <td><a href="<?= base_url() ?>/admin/detail/<?= $row['admin_id']?>"><?= $i ?></a></td>
                                                <td><a href="<?= base_url() ?>/admin/detail/<?= $row['admin_id']?>"><?= $row['name'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/admin/detail/<?= $row['admin_id']?>"><?= $row['contact'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/admin/detail/<?= $row['admin_id']?>"><?= $row['email'] ?></a></td>

                                                <td><a href="<?= base_url() ?>/admin/delete/<?= $row['admin_id']?>" class="btn btn-danger delete-button" ><i class="fa fa-trash"></i> Delete</a></td>
                                            </tr>
                                        <?php
                                        $i++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="custom_pagination" id="admin_list_page" data-table="admin_list_table" data-method="get" data-url="<?= base_url("admin") ?>">
                                    <?= $page ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>