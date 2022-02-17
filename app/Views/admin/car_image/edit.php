<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>/Car/detail/<?= $car_image['car_id']?>">Car</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/CarImage/edit/<?= $car_image['car_image_id']?>">Edit CarImage Details</a></li>
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
                Edit CarImage Details
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url()?>/CarImage/edit/<?=$car_image["car_image_id"]?>">
                    <!-- <div class="form-group">
                        <label for="">Profile Picture</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail">
                            <label class="custom-file-label" for="" aria-describedby="">Choose file</label>
                        </div>
                    </div> -->
                    <?= $form['is_thumbnail'] ?>

                    <?= $form['image'] ?>

                    <div class="form-group">
                        <label for="">Type</label>
                        <select name="type_id" id="" class="form-control">
                            <option value="0" <?= $car_image['type_id'] == "0" ? 'selected' : '' ?>>Exteriod</option>
                            <option value="1" <?= $car_image['type_id'] == "1" ? 'selected' : '' ?>>Interiod</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary float-right" type="submit"> Submit</button>
                    </div>


                </form>
            </div>

        </div>