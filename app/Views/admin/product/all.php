
<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
		<li class="breadcrumb-item active"><a href="#">Product</a></li>
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
                Product Details
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                    <a class="card-header-action" href="<?= base_url() ?>/product/add">
                        <i class="cil-plus c-icon"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered datatable dataTable no-footer" style="border-collapse: collapse !important">
                                    <thead>
                                        <tr role="row">
                                            <th class="" >No.</th>
                                            <th class="" >Product Picture</th>
                                            <th class="">Product</th>
                                            <th class="">Category</th>
                                            <th class="">Price</th>
                                            <th class=""></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            foreach($product as $row){
                                         ?>
                                            <tr>
                                                
                                                <td><a href="<?= base_url() ?>/product/detail/<?= $row['product_id']?>"><?= $i ?></a></td>
                                                <td>
                                                    <a href="<?= base_url() ?>/product/detail/<?= $row['product_id']?>">
                                                        <img src="<?= base_url('/assets/img/product/'.$row['thumbnail']) ?>" class="img-fluid d-block m-auto" alt="" style="width:auto;height:50px;">
                                                    </a>
                                                </td>
                                                <td><a href="<?= base_url() ?>/product/detail/<?= $row['product_id']?>"><?= $row['product'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/product/detail/<?= $row['product_id']?>"><?= $row['category'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/product/detail/<?= $row['product_id']?>"><?= $row['price'] ?></a></td>
                                                <td><a href="<?= base_url() ?>/product/delete/<?= $row['product_id']?>" class="btn btn-danger delete-button" ><i class="fa fa-trash"></i> Delete</a></td>
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