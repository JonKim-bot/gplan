
<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
		<li class="breadcrumb-item active"><a href="<?= base_url() ?>/company_profit">CompanyProfit</a></li>
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
                CompanyProfit Details
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                    <!-- <a class="card-header-action" href="<?= base_url() ?>/company_profit/add">
                        <i class="cil-plus c-icon"></i>
                    </a> -->
                </div>
            </div>
            <div class="card-body">
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered no-footer dataTable" id="company_profit_list_table" data-method="get" data-url="<?= base_url("company_profit") ?>" style="border-collapse: collapse !important">
                                    <thead>
                                        <tr role="row">
                                            <th>No.</th>
                                            <th data-sort="name" data-filter="name">Name</th>
                                <th data-sort="contact" data-filter="contact">Contact</th>
                                <th data-sort="" data-filter="">Transaction</th>
                                <th data-sort="remarks" data-filter="remarks">Remarks</th>
                                <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            foreach($company_profit as $row){
                                         ?>
                                            <tr>
                                            <td><?= $i ?></td>

                                            <td><?= $row['name'] ?></td>
                                    <td><?= $row['contact'] ?></td>
                                    <td><?= $row['transaction'] ?></td>
                                    <td><?= $row['remarks'] ?></td>
                                    <td><?= $row['created_date'] ?></td>
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