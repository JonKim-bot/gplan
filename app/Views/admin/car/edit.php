<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>/Car">Car</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/Car/edit/<?= $car['car_id']?>">Edit Car Details</a></li>
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
                Edit Car Details
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url()?>/Car/edit/<?=$car["car_id"]?>">
                    <!-- <div class="form-group">
                        <label for="">Profile Picture</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail">
                            <label class="custom-file-label" for="" aria-describedby="">Choose file</label>
                        </div>
                    </div> -->
                    <!-- <div class="form-group">
                        <label for="car">Sticker</label>
                        <input type="file" class="form-control" name="sticker" placeholder="Car" >
                    </div> -->
                    <?= $form['users_id'] ?>
                    <?= $form['state_id'] ?>
                    <?= $form['area_id'] ?>

                    <div class="form-group">
                    <label for="">Brand</label>
                    <select id="brand_id" name="brand_id_copy" class="form-control select2">
                        <option value="0">--SELECT A BRAND--</option>
                        <?php foreach($brand as $row){ ?>
                            <option value="<?= $row['brand_id'] ?>" <?= $car['brand_id_copy'] == $row['brand_id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="">Model</label>
                    <select id="model_id" name="model_id" class="form-control select2">
                    </select>
                </div>

                
                <div class="form-group">
                    <label for="">Variant</label>
                    <select id="variant_id" name="variant_id" class="form-control select2">
                    </select>
                </div>

                    <?= $form['transmission_id'] ?>
                    <?= $form['engine_no'] ?>
                    <?= $form['engine_capacity'] ?>
                    <?= $form['lisence_plate_no'] ?>
                    <?= $form['chassis_no'] ?>
                    <?= $form['color_id'] ?>
                    <!-- <?= $form['fuel_type'] ?> -->
                    <div class="form-group">
                        <label for="">Fuel Type</label>
                        <select name="fuel_type" id="" class="form-control">
                            <option value="Petrol" <?= $car['fuel_type'] == "Petrol" ? 'selected' : '' ?>>Petrol</option>
                            <option value="Diesel" <?= $car['fuel_type'] == "Diesel" ? 'selected' : '' ?>>Diesel</option>
                            <option value="Hybrid" <?= $car['fuel_type'] == "Hybrid" ? 'selected' : '' ?>>Hybrid</option>
                            <option value="Electric" <?= $car['fuel_type'] == "Electric" ? 'selected' : '' ?>>Electric</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="">Existing Loan</label>
                        <select name="existing_loan" id="" class="form-control">
                            <option value="YES" <?= $car['existing_loan'] == "YES" ? 'selected' : '' ?>>YES</option>
                            <option value="NO" <?= $car['existing_loan'] == "NO" ? 'selected' : '' ?>>NO</option>
                        </select>
                    </div>


                    <?= $form['no_of_seat'] ?>
                    <?= $form['no_of_previos_owner'] ?>

                    <div class="form-group">
                        <label for="">Manufactured Year</label>
                        <input type="date" value="<?= $car['manufactured_year'] ?>" class="form-control" name="manufactured_year" placeholder="e.g. 2001" required>
                    </div>
                    <?= $form['mileage'] ?>

                    <!-- <?= $form['registration_type'] ?> -->
                    <div class="form-group">
                        <label for="">Registration Date</label>
                        <input type="date" class="form-control" value="<?= $car['registration_date'] ?>" name="registration_date" placeholder="e.g. 2001" required>
                    </div>
                    <div class="form-group">
                        <label for="">Registration Type</label>
                        <select name="registration_type" id="" class="form-control">
                            <option value="Personal" <?= $car['registration_type'] == "Personal" ? 'selected' : '' ?>>Personal</option>
                            <option value="Business" <?= $car['registration_type'] == "Business" ? 'selected' : '' ?>>Business</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Plate No</label>
                        <select name="plate_no" id="" class="form-control">
                            <option value="Sell With"  <?= $car['plate_no'] == "Sell With" ? 'selected' : '' ?>>Sell With</option>
                            <option value="Sell Without"  <?= $car['plate_no'] == "Sell Without" ? 'selected' : '' ?>>Sell Without</option>
                        </select>
                    </div>
                    <!-- <?= $form['registation_card'] ?> -->

                    <div class="form-group">
                        <button class="btn btn-primary float-right" type="submit"> Submit</button>
                    </div>


                </form>
            </div>

        </div>



        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>

            <script>
            $(document).ready(function(){
                $("#brand_id").change(function(){
                    var brand_id = $(this).val();
                    get_brand(brand_id);
                });

                $("#model_id").change(function(){
                    var model_id = $(this).val();
                    get_variant(model_id);
                });

                $("#form_state_id").change(function(){
                    var state_id = $(this).val();
                    get_area(state_id);
                });


                function get_brand(brand_id){
                    var postParam = {
                        brand_id: brand_id,
                        selected_model : <?= $car['model_id'] ?>,
                    };
                    $.post("<?=base_url()?>/car/search_matching_model", postParam, function(html){
                        $("#model_id").html(html);
                        get_variant($('#model_id').val());
                        // $("#user_select2").html(html);
                    });
                }

                function get_area(state_id){
                    var postParam = {
                        state_id: state_id,
                        selected_area : <?= $car['area_id'] ?>,

                    };
                    $.post("<?=base_url()?>/car/search_matching_area", postParam, function(html){

                        $("#form_area_id").html(html);
                        // $("#user_select2").html(html);
                    });
                }

                function get_variant(model_id){
                    var postParam = {
                        model_id: model_id,
                        selected_variant : <?= $car['variant_id'] == "" ? 0 : $car['variant_id'] ?>,
                    };

                    $.post("<?=base_url()?>/car/search_matching_variant", postParam, function(html){
                        $("#variant_id").html('');

                        $("#variant_id").html(html);
                        // $("#user_select2").html(html);
                    });
                }

                get_area(<?= $car['state_id'] ?>);
                get_brand(<?= $car['brand_id_copy'] ?>);
                get_variant(<?= $car['model_id'] ?>);
        
            });

</script>