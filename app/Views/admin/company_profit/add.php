<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>voucher_category">Voucher Category</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>voucher_category/add">Create New Voucher Category</a></li>
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
                        Create New CompanyProfit Record
                        <div class="card-header-actions">
                            <a class="card-header-action">
                                <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form role="form" method="POST" enctype="multipart/form-data" action="<?=base_url('/CompanyProfit/add');?>">
                            <?php if (isset($error)) { ?>
                                <div class="alert-message"  role="alert">
                                    <?= $error; ?>						
                                </div>
                            <?php }?>
                            <div class="form-group">
                                <label for="">User </label>
                                <select name="user_id" class="form-control" id="category_type_select">
                                    <?php
                                foreach($user as $row){
                                    ?>
                                    <option value="<?= $row['user_id'] ?>"><?= $row['username'] . " - " . $row['contact'] ?> </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="">Top Up Amount</label>
                                <input type="text" class="form-control" name="amount" placeholder="Amount" required>
                            </div>

                            <div class="form-group">
                                <label for="">Remark</label>
                                <input type="text" class="form-control" name="remarks" placeholder="Remark" required>
                            </div>


                            <div class="form-group">
                                <button class="btn btn-primary float-right" type="submit"> Submit</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $("#voucher_category_type_select").change();
            });
            
            $("#voucher_category_type_select").change(function(){
                var val = $(this).val();
                var postParam = {
                    voucher_category_type_id: val,
                    self: 0,
                }

                $.post("<?= base_url() ?>/ajax/loadParentVoucher Category", postParam, function(html){
                    $("#parent_select").html(html);
                });
            });
        </script>
