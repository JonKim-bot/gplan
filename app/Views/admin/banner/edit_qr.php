<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Tng Qr Code</li>
        <!-- <li class="breadcrumb-item active"><a href="<?= base_url() ?>/banner/edit/<?= $banner['banner_id']?>">Edit Banner Details</a></li> -->
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
                Edit Qr Code
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url()?>/banner/qrcode/<?=$banner["banner_id"]?>">
                    <div>
                        <img src="<?= base_url() .  $banner['banner'] ?>" alt="">
                    </div>
                    <div class="form-group">
                        <label for="banner">Image</label>
                        <input type="file" class="form-control" name="banner" placeholder="Banner" >
                    </div>
                    <input type="hidden" name="asd" value='1'>

                    <div class="form-group">
                        <button class="btn btn-primary float-right" type="submit"> Submit</button>
                    </div>
                    
                   
                </form>
            </div>
            
        </div>