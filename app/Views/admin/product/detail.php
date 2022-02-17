<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url('product') ?>">Product</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/product/detail/<?= $product['product_id']?>">Product Details</a></li>
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
            <div class="col-md-6">
                <div class="card">
                    <div class="c-card-header">
                        Thumbnail
                        <div class="card-header-actions">
                            <a class="card-header-action">
                                <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="c-card-body">
                        <div class="view-info">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12">
                                                <img src="<?= base_url('/assets/img/product/'.$product['thumbnail']) ?>" width="200" class="img-fluid d-block m-auto" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="c-card-header">
                        Product Details
                        <div class="card-header-actions">
                            <a class="card-header-action">
                                <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                            </a>
                            <a class="card-header-action" href="<?php echo site_url('product/edit') . '/' . $product['product_id'] ?>">
                                <i class="cil-pencil c-icon"></i>
                            </a>
                        </div>
                    </div>
                    <div class="c-card-body">
                        <div class="view-info">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12">
                                                <div class="table-responsive">
                                                    <table class="table m-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Product</th>
                                                                <td><?= $product["product"]?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Price</th>
                                                                <td><?= $product["price"]?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Category</th>
                                                                <td><?= $product["category"]?></td>
                                                            </tr>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       