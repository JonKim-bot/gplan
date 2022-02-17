<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>product">Product</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>product/add">Create New Product</a></li>
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
                        Create New Product
                        <div class="card-header-actions">
                            <a class="card-header-action">
                                <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form role="form" method="POST" enctype="multipart/form-data" action="<?=base_url('/product/add');?>">
                            <div class="form-group">
                                <label for="">Product Picture</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="thumbnail" multiple>
                                    <label class="custom-file-label" for="" aria-describedby="">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Product</label>
                                <input type="text" class="form-control" name="product" placeholder="Product" required>
                            </div>
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="number" class="form-control" name="price" placeholder="Price" required>
                            </div>
                            <div class="form-group">
                                <label for="">Discount Price</label>
                                <input type="number" class="form-control" name="discount_price" placeholder="discount_price" required>
                            </div>
                            <div class="form-group">
                                <label for="">Category</label>
                                <select class="form-control" name="category_id">
                                    <?php foreach($category as $row){ ?>
                                        <option value="<?= $row['category_id']?>">
                                            <?= $row['category']?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                        
                            
                            <div class="form-group">
                                <button class="btn btn-primary float-right" type="submit"> Submit</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>