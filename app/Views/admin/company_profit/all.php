
<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
		<li class="breadcrumb-item active"><a href="<?= base_url() ?>/company_profit">Transaction</a></li>
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
            Transaction Details
                <div class="card-header-actions">
                    <?php if(isset($_GET['filter_id'])){ ?>

                    <a  href="<?= base_url() ?>/CompanyProfit/export_csv?filter_id=<?= isset($_GET['filter_id']) ? $_GET['filter_id'] : '0' ?>&dateFrom=<?= $_GET['dateFrom'] ?>&dateTo=<?= $_GET['dateTo'] ?>" class="btn btn-primary pull-left export">
                        Export To Csv
                    </a>
                    <?php } ?>
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
                <form method="GET" id="filter_form">
                        <div class="row">

                            <div class="form-group col-sm-12 col-md-3">
                                <label for="" class="c-label">Filter</label>
                                <select class="form-control filter" name="filter_id">
                                    <option value="0" <?= isset($_GET['filter_id']) && $_GET['filter_id'] == 0 ? 'selected' : '' ?>>All</option>
                                    <option value="1" <?= isset($_GET['filter_id']) && $_GET['filter_id'] == 1 ? 'selected' : '' ?>>Debit</option>
                                    <option value="2" <?= isset($_GET['filter_id']) && $_GET['filter_id'] == 2 ? 'selected' : '' ?>>Credit</option>

                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-3">
                                <label for="" class="c-label">Date From</label>
                                <br>
                                <input type="date" class="form-control filter" name="dateFrom" 
                                value="<?=  ($_GET and
                            isset($_GET['dateFrom']))
                                ? $_GET['dateFrom']

                                : date('Y-m-d') ?>"
                                >
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label for="" class="c-label">Date To</label>
                                <br>
                                <input type="date" class="form-control filter" name="dateTo" value="<?= $dateTo ?>">
                            </div>

                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered no-footer datatable" id="company_profit_list_table" data-method="get" data-url="<?= base_url("company_profit") ?>" style="border-collapse: collapse !important">
                                    <thead>
                                        <tr role="row">
                                            <th>No.</th>
                                            <th data-sort="name" data-filter="name">Name</th>
                                <th data-sort="contact" data-filter="contact">Contact</th>
                                <th data-sort="" data-filter="">Credit</th>
                                <th data-sort="" data-filter="">Debit</th>

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
                                    <!-- <td><?= $row['transaction'] ?></td> -->
                                    <td><?= $row['company_profit_in'] ?></td>
                                    <td><?= ltrim($row['company_profit_out'], '-'); ?></td>

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


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

        <script>
            
$(document).on("change", ".filter", function (e) {

$('#filter_form').submit();
});

        </script>