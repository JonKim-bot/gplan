<div class="c-subheader justify-content-between px-3">

    
    
   <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item"><a href="<?= base_url(
         'Car'
         ) ?>">Car</a></li>
      <li class="breadcrumb-item active"><a href="<?= base_url() ?>/Car/detail/<?= $car[
         'car_id'
         ] ?>">Car Details</a></li>


</ol>
<style>
    
.coolBeans {
    border: 2px solid currentColor;
    border-radius: 1rem;
    color: blue;
    font-family: roboto;
    font-size: 1rem;
    font-weight: 100;
    overflow: hidden;
    padding: 7px;
    position: relative;
    text-decoration: none;
    transition: 0.2s transform ease-in-out;
    will-change: transform;
    margin: 6px;
    z-index: 0;
}
.coolBeans::after {
  background-color: lightblue;
  border-radius: 3rem;
  content: '';
  display: block;
  height: 100%;
  width: 100%;
  position: absolute;
  left: 0;
  top: 0;
  transform: translate(-100%, 0) rotate(10deg);
  transform-origin: top left;
  transition: 0.2s transform ease-out;
  will-change: transform;
  z-index: -1;
}
.coolBeans:hover::after {
  transform: translate(0, 0);
}
.coolBeans:hover {
  border: 2px solid transparent;
  color: white;
  transform: scale(1.05);
  will-change: transform;
}

</style>
<?php if($car['already_auction'] == 0){ ?>
    <a class="coolBeans" href="<?= base_url() ?>/Auction/add?car_id=<?= $car['car_id'] ?>">Create Quick Auction</a>
<?php } ?>
</div>
<main class="c-main">
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="c-card-header">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link " id="pills-carimage-tab" data-toggle="pill" href="#pills-carimage" role="tab" aria-controls="pills-carimage" aria-selected="true">Car Image</a>
                        </li>

                        <li class="nav-item">

                            <a class="nav-link" id="pills-inspectiontype-tab" data-toggle="pill" href="#pills-inspectiontype" role="tab" aria-controls="pills-inspectiontype" aria-selected="false">Inspection Type</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-inspectionsusmmary-tab" data-toggle="pill" href="#pills-inspectionsusmmary" role="tab" aria-controls="pills-inspectionsusmmary" aria-selected="false">Inspection Summary</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="pills-sticker-tab" data-toggle="pill" href="#pills-sticker" role="tab" aria-controls="pills-sticker" aria-selected="false">Car Sticker</a>
                        </li>

                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="c-card-header">
                           Car info
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                              
                                <a class="card-header-action" href="<?php echo site_url(
                                    'Car/edit'
                                ) .
                                    '/' .
                                    $car['car_id']; ?>">
                                    <button class="btn btn-warning"><i class="cil-pencil c-icon"></i>Edit</button></i>
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
                                                    <tr>
                                                        <th>Last Edited By</th>
                                                        <th><?= $modified_by ?></th>

                                                    </tr>

                                                    <?= $detail ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>


                        <div class="tab-pane fade" id="pills-carimage" role="tabpanel" aria-labelledby="pills-carimage-tab">

                        <div class="card">
                            <div class="card-header">
                                Cars Image
                                <div class="card-header-actions">
                                    <a class="card-header-action">

                                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                    </a>
                                    <a class="card-header-action" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd">
                                        <i class="cil-plus c-icon"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped datatable table-bordered no-footer " id="car_list_table" data-method="get" data-url="<?= base_url("Car") ?>" style="border-collapse: collapse !important">
                                                    <!-- <?= $table_carimage ?> -->
                                                    <thead>
                                                        <tr role="row">
                                                            <th>No.</th>

                                                            <th>Is Thumbnail</th>
                                                            <th>Type</th>
                                                            <th>Image</th>
                                                            <th data-sort="title" data-filter="title">Created Date</th>

                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $i = 1;
                                                            foreach($car_image as $row){
                                                        ?>
                                                            <tr>
                                                                
                                                                <td><a href="<?= base_url() ?>/CarImage/detail/<?= $row['car_image_id']?>"><?= $i ?></a></td>
                                                                <td><a href="<?= base_url() ?>/CarImage/set_thumbnail/<?= $row['car_image_id']?>" class="btn btn-<?= $row['is_thumbnail'] == 1 ? 'success' : 'danger' ?>"><?= $row['is_thumbnail'] == 1 ? "YES" : "NO" ?></a></td>
                                                                <td>
                                                                <form role="form" method="POST" enctype="multipart/form-data"
                                                                        action="<?= base_url()?>/CarImage/edit/<?=$row["car_image_id"]?>">     
                                                                        <div class="form-group">

                                                                            <select name="type_id" id="" class="form-control">
                                                                                <option value="0" <?= $row['type_id'] == 0 ? 'selected' : '' ?>>Exterior</option>
                                                                                <option value="1" <?= $row['type_id'] == 1 ? 'selected' : '' ?>> Interior</option>
                                                                                <option value="2" <?= $row['type_id'] == 2 ? 'selected' : '' ?>>Damage</option>
                                                                                <option value="3" <?= $row['type_id'] == 3 ? 'selected' : '' ?>>Document</option>
    
                                                                            </select>
                                                                        </div>
                                                                            
                                                                       <button class="btn btn-primary" type="submit"> Save</button>
                                                                        </form>    
                                                            
                                                                </td>

                                                                <td><a href="<?= base_url() ?>/CarImage/detail/<?= $row['car_image_id']?>"><img src="<?= base_url() . $row['image'] ?>" width="200px" alt=""></a></td>

                                                                <td><a href="<?= base_url() ?>/CarImage/detail/<?= $row['car_image_id']?>"><?= $row['created_date'] ?></a></td>
                                                                
                                                                <td><a href="<?= base_url() ?>/CarImage/delete/<?= $row['car_image_id']?>" class="btn btn-danger delete-button" ><i class="fa fa-trash"></i> Delete Image</a></td>
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
                        </div>

                        <div class="tab-pane fade" id="pills-inspectiontype" role="tabpanel" aria-labelledby="pills-inspectiontype-tab">

                        <div class="card">
                            <div class="card-header">
                                Cars Inspection 
                                <div class="card-header-actions">
                                    <a class="card-header-action">
                                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                    </a>
                                    <!-- <a class="card-header-action" class="btn btn-primary" data-toggle="modal" data-target="#modalcar_inspection_type">
                                        <i class="cil-plus c-icon"></i>
                                    </a> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped datatable table-bordered no-footer " id="car_list_table" data-method="get" data-url="<?= base_url("Car") ?>" style="border-collapse: collapse !important">

                                                    <thead>
                                                        <tr role="row">
                                                            <th>No.</th>

                                                            <th>Name</th>

                                                            <th data-sort="title" data-filter="title">Created Date</th>

                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $i = 1;
                                                            foreach($car_inspection_type as $row){
                                                        ?>
                                                            <tr>
                                                                
                                                                <td><a href="<?= base_url() ?>/InspectionType/detail/<?= $row['inspection_type_id']?>/<?= $car['car_id'] ?>"><?= $i ?></a></td>
                                                                <td><a href="<?= base_url() ?>/InspectionType/detail/<?= $row['inspection_type_id']?>/<?= $car['car_id'] ?>"><?= $row['name'] ?></a></td>
                                                                <td><a href="<?= base_url() ?>/InspectionType/detail/<?= $row['inspection_type_id']?>/<?= $car['car_id'] ?>"><?= $row['created_date'] ?></a></td>
                                                                
                                                                <td><a href="<?= base_url() ?>/InspectionType/detail/<?= $row['inspection_type_id']?>/<?= $car['car_id'] ?>" class="btn btn-success" ><i class="fa fa-link"></i> Click To Inspect</a></td>
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
                        </div>



                        <div class="tab-pane fade" id="pills-sticker" role="tabpanel" aria-labelledby="pills-sticker-tab">

                        <div class="card">
                            <div class="card-header">
                                Cars

                                <div class="card-header-actions">
                                    <a class="card-header-action">
                                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                    </a>
                                    <!-- <a class="card-header-action" class="btn btn-primary" data-toggle="modal" data-target="#modalcar_inspection_type">
                                        <i class="cil-plus c-icon"></i>
                                    </a> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped datatable table-bordered no-footer " id="car_list_table" data-method="get" data-url="<?= base_url("Car") ?>" style="border-collapse: collapse !important">

                                                    <thead>
                                                        
                                                        <tr role="row">
                                                            <th>No.</th>
                                                            <th>Description</th>

                                                            <th>Sticker</th>
                                                            <th>Status</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $i = 1;
                                                            foreach($car_sticker as $row){
                                                        ?>
                                                            <tr>
                                                                
                                                                <td><?= $i ?></td>
                                                                <td><?= $row['description'] ?></td>
                                                                <td>
                                                                <img src="<?= base_url()  . $row['image'] ?>" width="200px" alt=""></td>
                                                                <?php if($row['is_active'] == 1){ ?>

                                                                    <td><a href="<?= base_url() ?>/Car/set_sticker_active/<?= $row['car_sticker_id']?>/<?= $car['car_id'] ?>" class="btn btn-success"><?= $row['is_active'] == 1 ? "Active" : "Not Active" ?></a></td>
                                                                <?php }else{?>
                                                                    <td><a href="<?= base_url() ?>/Car/set_sticker_active/<?= $row['car_sticker_id']?>/<?= $car['car_id'] ?>" class="btn btn-danger"><?= $row['is_active']  == 1 ? "Active" : "Not Active" ?></a></td>

                                                                <?php } ?>
                                                                
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
                        </div>

                        <div class="tab-pane fade" id="pills-inspectionsusmmary" role="tabpanel" aria-labelledby="pills-inspectionsusmmary-tab">
                            <h2 class="text-center">Inspection Summary (Pass : <?= $car_inspection['total_pass'] ?> / Total  : <?= $car_inspection['total'] ?>)</h2>
                            <div class="progress">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= $car_inspection_percentage ?>%" aria-valuenow="<?= $car_inspection_percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
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
            <!-- car image form  -->
            <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Add Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data"  method="POST" action="<?=base_url('/CarImage/add');?>">
                        <div class="modal-body">

                            <div class="form-group">
                            <label for="">Image</label>

                            <input type="file" name="image[]" multiple class="form-control">
                            </div>

                            <div class="form-group">
                            <label for="">Type</label>
                            <select name="type_id" id="" class="form-control">
                                <option value="0">Exterior</option>
                                <option value="1">Interior</option>
                                <option value="2">Damage</option>
                                <option value="3">Document</option>

                            </select>
                            </div>
                            <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>


            <?= $modal_car_inspection ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

            <script>

$(function() {
        $('a[data-toggle="pill"]').on('click', function(e) {
            window.localStorage.setItem('activeTab', $(e.target).attr('href'));
            console.log( $(e.target).attr('href'))
        });
        // alert(window.localStorage.getItem('activeTab'))
        var activeTab = window.localStorage.getItem('activeTab');
        

        <?php if(isset($_GET['new_car'])){ ?>
            $('#pills-tab a[href="' + "#pills-inspectiontype" + '"]').tab('show');


        <?php }else{ ?>

        if (activeTab) {
            $('#pills-tab a[href="' + activeTab + '"]').tab('show');
            // window.localStorage.removeItem("activeTab");
        }

        <?php } ?>

        $('a[data-toggle="tab"]').on('click', function(e) {
            window.localStorage.setItem('activeTabChildren', $(e.target).attr('href'));
        });
        // alert(window.localStorage.getItem('activeTab'))
        var activeTabChildren = window.localStorage.getItem('activeTabChildren');
        if (activeTabChildren) {
            console.log(activeTabChildren)
            $('#pills-inspectionsusmmary a[href="' + activeTabChildren + '"]').tab('show');
            $('#pills-inspectiontype a[href="' + activeTabChildren + '"]').tab('show');
            $('#pills-carimage a[href="' + activeTabChildren + '"]').tab('show');
            // $('#pills-addonselection a[href="' + activeTabChildren + '"]').tab('show');
            // window.localStorage.removeItem("activeTab2");
        }
        

        console.log('tab1', activeTab)
        console.log('tab2', activeTabChildren)
    });
            </script>