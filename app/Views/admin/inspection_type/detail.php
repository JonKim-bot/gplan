<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url(
            'Car/detail/' . $car_id
        ) ?>">Car Detail</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/InspectionType/detail/<?= $inspection_type[
    'inspection_type_id'
] ?>">InspectionType Details</a></li>
    </ol>

</div>


<main class="c-main">

    <div class="container-fluid">

        <div class="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            InspectionType Info
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                                <!-- <a class="card-header-action" >
                                    <button class="btn btn-warning"><i class="cil-pencil c-icon"></i>Edit</button></i>
                                </a> -->
                            </div>
                        </div>
                        <div class="c-card-body">
                            <div class="view-info">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info mb-5">

                                            <div class="table-responsive">
                                                <table class="table">

                                                <div class="accordion" id="accordionExample">
                                                    <?php foreach($car_inspection_part as $key=> $row){ ?>
                                                    <div class="card">
                                                        <div class="card-header" id="headingOne">
                                                        <h2 class="mb-0 carinspect">
                                                            <button class="btn btn-link text-left colation" key="<?= $key ?>" type="button" 
                                                            id="btn_<?= $row['inspection_part_id']  ?>"
                                                            data-toggle="collapse" data-target="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapse<?= $key ?>">
                                                             <?= $row['inspection_part'] ?>
                                                             
                                                             (<?= $row['total_pass']  ?>/<?= $row['total_detail'] ?>)
                                                            </button>
                                                            <a class="card-header-action icon_add" id="<?= $row['inspection_part_id'] ?>" class="btn btn-primary">
                                                                <i class="cil-plus c-icon"></i>
                                                            </a>
                                                        </h2>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" id="bar_<?= $row['inspection_part_id'] ?>" style="width: <?= $row['percentage'] ?>%" aria-valuenow="<?= (int)$row['percentage'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>

                                                    </div>


                                                        <div id="collapse<?= $key ?>" key="<?= $key ?>" class="collapse <?= isset($_GET['key']) &&  $_GET['key'] == $key ? 'show' : '' ?>" aria-labelledby="heading<?= $key ?>" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                        <div class="list-group"  id="ins<?= $row['inspection_part_id'] ?>">
                                                            <?php foreach($row['car_inspection_detail'] as $row_detail){
                                                                ?>

                                                                <div class="list-group-item list-group-item-action bg-black row justify-content-between d-flex align-items-center"
                                                               
                                                                >

                                                                    <span  aria-current="true">
                                                                        <?= $row_detail['inspection_detail'] ?> <b>(<?= $row_detail['status'] ?>)</b>
                                                                    </span>
                                                                    <span aria-current="true">
                                                                    <a class="btn btn-primary icon_add_image text-white" id="<?= $row_detail['car_inspection_id'] ?>"><i class="fas fa-image"></i> + (<?= $row_detail['total_image'] ?>)</a>
                                                                    <a target="_blank" href="<?= base_url() ?>/CarInspectionImage/image/<?= $row_detail['car_inspection_id'] ?>" class="btn btn-success"><i class="fa fa-eye"></i> <i class="fas fa-image"></i></a>
                                                                   
         
                                                                    <?php if($row_detail['status_id'] != 1){ ?>
                                                                        <a class="btn btn-success text-white change_status" inspection_part_id = '<?= $row['inspection_part_id'] ?>' car_inspection_id = "<?= $row_detail['car_inspection_id'] ?>" status_id = '1'>Pass</a>
                                                                    <?php } ?>
                                                                    <?php if($row_detail['status_id'] != 2 && $row_detail['status_id'] != 1){ ?>
                                                                        <a class="btn btn-danger text-white change_status" inspection_part_id = '<?= $row['inspection_part_id'] ?>' car_inspection_id = "<?= $row_detail['car_inspection_id'] ?>" status_id = '2'>Fail</a>
                                                                    <?php } ?>
                                                                    <?php if($row_detail['status_id'] != 3){ ?>
                                                                        <a class="btn btn-primary text-white change_status" inspection_part_id = '<?= $row['inspection_part_id'] ?>' car_inspection_id = "<?= $row_detail['car_inspection_id'] ?>" status_id = '3'>NA</a>
                                                                    <?php } ?>

                                                                    <a class="btn btn-danger text-white delete_btn" inspection_detail_id = '<?= $row_detail['inspection_detail_id'] ?>' inspection_part_id = '<?= $row['inspection_part_id'] ?>' car_inspection_id = "<?= $row_detail['car_inspection_id'] ?>">Delete</a>

                                                                </span>
                                                                </div>
                                                            <?php } ?>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    
                                                    </div>
                                                </table>
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

                    </div>
                </div>
            </div>

            
            <input type="hidden">
            <div class="modal fade" id="car_inspection_image_modal" tabindex="-1" role="dialog" aria-labelledby="car_inspection_image_modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Add Car Inspection Image </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data"  method="POST" action="<?=base_url("CarInspection/add_image");?>">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Image
                                </label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <input type="hidden" name="key" id="key" value="<?= isset($_GET['key']) ? $_GET['key'] : '' ?>">
                            <input type="hidden" class="car_inspection_id" name="car_inspection_id">
                            <input type="hidden" class="" name="car_id" value="<?= $car_id ?>">

                            <input type="hidden" class="" name="inspection_type_id" value="<?= $inspection_type_id ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="car_detail_modal" tabindex="-1" role="dialog" aria-labelledby="car_inspection_image_modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Add Car Inspection </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data"  method="POST" action="<?=base_url("InspectionDetail/add");?>">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <input type="hidden" class="inspection_partw_id" name="inspection_part_id">
                            <input type="hidden" class="car_id" name="car_id" value="<?= $car_id ?>">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>

            <script>
            $(document).ready(function() {

                $(".icon_add").on("click", function(e) {
                    var inspection_part_id = $(this).attr('id');
                    $('.inspection_partw_id').val(inspection_part_id);
                    $('#car_detail_modal').modal('show');
                });
                $(".colation").on("click", function(e) {
                    var key = $(this).attr('key');
                    $('#key').val(key);
                });


                

                $(".icon_add_image").on("click", function(e) {
                    var car_inspection_id = $(this).attr('id');
                    $('.car_inspection_id').val(car_inspection_id);
                    $('#car_inspection_image_modal').modal('show');
                });
                
                function get_inspection_detail(inspection_part_id,car_inspection_id,inspection_detail_id = 0){
                    let postParam = {
                        car_inspection_id : car_inspection_id,
                        car_id : '<?= $car_id ?>',
                        inspection_part_id : inspection_part_id,
                        inspection_detail_id : inspection_detail_id,
                    }
                    $.post("<?= base_url(
                        'InspectionType/get_inspection_part'
                    ) ?>", postParam, function(html) {
                        $('#ins' + inspection_part_id).html(html);
                    });
                }

                

                $(".delete_btn").on("click", function(e) {

                    var car_inspection_id = $(this).attr('car_inspection_id');
                    // var car_id = $(this).attr('id').split(',')[0];
                    var inspection_part_id = $(this).attr('inspection_part_id');

                    var inspection_detail_id = $(this).attr('inspection_detail_id');

                    let postParam = {
                        car_inspection_id : car_inspection_id,

                    }
                    $.post("<?= base_url('CarInspection/delete_') ?>" , postParam, function(data) {
                        data = JSON.parse(data);cmd
                        // alert("updated");
                        get_inspection_detail(inspection_part_id,car_inspection_id,inspection_detail_id);
                        get_percentage_and_pass_fail(inspection_part_id)
                    });
                });

                $(".change_status").on("click", function(e) {
                    var car_inspection_id = $(this).attr('car_inspection_id');
                    var status_id = $(this).attr('status_id');
                    var inspection_part_id = $(this).attr('inspection_part_id');

                    // var car_id = $(this).attr('id').split(',')[0];
                    let postParam = {
                        car_inspection_id : car_inspection_id,
                        status_id : status_id,

                    }
                    $.post("<?= base_url(
                        'CarInspection/mark_pass_fail_status'
                    ) ?>", postParam, function(data) {
                        data = JSON.parse(data);
                        // alert("updated");
                        get_inspection_detail(inspection_part_id,car_inspection_id);
                        get_percentage_and_pass_fail(inspection_part_id);

                    });

                });


                function get_percentage_and_pass_fail(inspection_part_id){
                    let postParam = {
                        car_id : '<?= $car_id ?>',
                        inspection_part_id : inspection_part_id,
                    }
                    $.post("<?= base_url(
                        'InspectionType/get_percentage'
                    ) ?>", postParam, function(data) {
                        data = JSON.parse(data);
                        // console.log(data);
                        data = data.data;
                        var total_detail = data.total_detail;
                        var total_pass = data.total_pass;
                        var percentage = data.percentage;
                        var inspection_part = data.inspection_part;
                        // alert(total_detail);
                        $('#bar_' + inspection_part_id).css({'width' : percentage + "%"})
                        var text = inspection_part + "\n" + "(" + total_pass +  " / " + total_detail + ")";
                        $('#btn_' + inspection_part_id).text(text)

                        // $('#' + inspection_part_id).html(html);
                    });
                }
    });


            </script>