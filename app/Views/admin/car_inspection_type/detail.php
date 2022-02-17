<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/Car/detail/<?= $car_inspection_type[
    'car_id'
] ?>">Car Detail</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/CarInspectionType/detail/<?= $car_inspection_type[
    'car_id'
] ?>">Car Inspection Details</a></li>
    </ol>

</div>
<style>
    .btn-link{
        display: flex;
    justify-content: space-between;
    }
    .icon_add{
        display: flex;
    align-items: center;
    }
    .carinspect{
        display: flex;
    justify-content: space-between;
    align-items: center;
    }
</style>
<main class="c-main">

    <div class="container-fluid">

        <div class="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            CarInspectionType Info
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                                <a class="card-header-action" class="btn btn-primary" data-toggle="modal" data-target="#CarInspectionPartModal">
                                    <i class="cil-plus c-icon"></i>
                                </a>
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
                                                            <button class="btn btn-link text-left" type="button" data-toggle="collapse" data-target="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapse<?= $key ?>">
                                                             <?= $row['inspection_part'] ?>
                                                             
                                                             (<?= $row['total_pass']  ?>/<?= $row['total_detail'] ?>)
                                                            </button>
                                                            <a class="card-header-action icon_add" id="<?= $row['car_inspection_part_id'] ?>" class="btn btn-primary">
                                                                <i class="cil-plus c-icon"></i>
                                                            </a>
                                                        </h2>
                                                        <div class="progress">
    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= $row['percentage'] ?>%" aria-valuenow="<?= (int)$row['percentage'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
                                                    </div>

                                                        <div id="collapse<?= $key ?>" class="collapse <?= isset($_GET['key']) &&  $_GET['key'] == $key ? 'show' : '' ?>" aria-labelledby="heading<?= $key ?>" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                        <div class="list-group">
                                                            <?php foreach($row['car_inspection_detail'] as $row_detail){ ?>
                                                                <div class="list-group-item list-group-item-action bg-black row justify-content-between d-flex align-items-center">

                                                                    <span  aria-current="true">
                                                                        <?= $row_detail['inspection_detail'] ?>
                                                            </span>
                                                            <span aria-current="true">

                                                                    <a href="<?= base_url() ?>/CarInspectionDetail/mark_pass_fail/<?= $row_detail['car_inspection_detail_id'] ?>?key=<?= $key ?>&car_inspection_type=<?= $car_inspection_type['car_inspection_type_id'] ?>" class="btn btn-<?= $row_detail['status_id'] == 1 ?'success' : 'danger' ?>"><?= $row_detail['status'] ?></a>
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


            <?= $modal_car_inspection ?>

            <div class="modal fade" id="car_detail_modal" tabindex="-1" role="dialog" aria-labelledby="car_detail_modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Add Car Inspection Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data"  method="POST" action="<?=base_url("CarInspectionDetail/add");?>">
                        <div class="modal-body">
                            <?= $form_inspection_type['inspection_detail_id'] ?>
                            <div class="form-group">
                                <label for="">Pass / Failed ? 
                                </label>
                                <select name="status_id" class="select2 form-control" id=""  required>
                                    <option value="1">Pass</option>
                                    <option value="2">Fail</option>

                                </select>
                            </div>
                            <input type="hidden" class="car_inspection_part_id" name="car_inspection_part_id">
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

                $(".icon_add").on("click", function(e) {
                    var car_inspection_part_id = $(this).attr('id');
                    $('.car_inspection_part_id').val(car_inspection_part_id);
                    $('#car_detail_modal').modal('show');
                });
            </script>