<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/transaction">Transaction</a></li>
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
                        <a class="card-header-action">
                            <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                        </a>
                        <a class="card-header-action" href="<?= base_url() ?>/Topup/add">
                            <i class="cil-plus c-icon"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    
                    <div class="row">
                        <div class="col-sm-12">
                                <table class="table table-striped table-bordered no-footer datatable" id="wallet_list_table" data-method="get" data-url="<?= base_url("wallet") ?>" style="border-collapse: collapse !important">
                            <div class="table-responsive">
                                    <thead>
                                        <tr role="row">
                                            <th>No.</th> ata-filter="name">Name</th>
                                <th data-sort="contact" data-filter="contact">Contact</th>
                                <th data-sort="" data-filter="">Top up amount</th>
                                <th data-sort="" data-filter="">Is Paid</th>

                                <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            foreach($wallet as $row){
                                         ?>
                                            <tr>
                                            <td><?= $i ?></td>

                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['contact'] ?></td>

                                            <td><?= $row['amount'] ?></td>
                                            <td><?= $row['is_paid'] == 1 ? "YES" : "NO" ?></td>

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
            <!-- Modal -->
            <!-- <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Approve Transaction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="approve_form" method="POST" action="">
                            <div class="modal-body">
                                <label>Top Up Amount</label>
                                <input type="text" min="1" id="value_form" required name="amount" placeholder="TOP UP AMOUNT" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="approve_submit">Approve</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                $(document).on('click', ".approve-button", function () {
                    var transaction_id = $(this).data('id');
                    var amount = $(this).data('amount');
                    $("#value_form").val(amount);
                    $("#approve_form").attr("action", "<?= base_url('transaction/approve') ?>/" + transaction_id);
                    $("#approveModal").modal("show");
                });

                $(document).on('click', ".reject-button", function () {
                    var transaction_id = $(this).data('id');
                    if (confirm("Are you sure you want to reject this transaction?")) {
                        window.location.replace("<?= base_url('transaction/reject')?>/" + transaction_id);
                    }
                });

                $(document).on("submit", "#approve_form", function(e){
                    $("#approve_submit").prop("disabled", true);
                }); 
            </script> -->