<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url(
            'Brand'
        ) ?>">Brand</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/Brand/detail/<?= $brand[
    'brand_id'
] ?>">Brand Details</a></li>
    </ol>
 
</div>

<main class="c-main">

    <div class="container-fluid">

        <div class="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            Brand Info
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                                <a class="card-header-action" href="<?php echo site_url(
                                    'Brand/edit'
                                ) .
                                    '/' .
                                    $brand['brand_id']; ?>">
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
                                                    
                                                    <?= $detail ?>
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
                        <div class="card-header">
                    Models
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
                                    <table class="table table-striped datatable table-bordered no-footer " id="model_list_table" data-method="get" data-url="<?= base_url("Model") ?>" style="border-collapse: collapse !important">
                                    <thead>
                                                    <tr role="row">
                                                        <th>No.</th>
                                                        <th data-filter="name">Name</th>
                                                        <th data-filter="contact">View Variant</th>
                                                        <th data-filter="email">Created Date</th>
                                                        <th></th>

                                                    </tr>
                                                </thead>  
                                            
                                                <tbody>
                                        <?php
                                            $i = 1;
                                            foreach($model as $row){
                                         ?>
                                            <tr>
                                                
                                                <td><?= $i ?></td>
                                                <td><?= $row['name'] ?></td>
                                                <td><a  class="btn btn-success text-white add_variant" id="<?= $row['model_id'] ?>"> Add</a>
                                                <br><br>
                                                <a  class="btn btn-primary text-white view_variant" href="<?= base_url() ?>/model/view_variant/<?= $row['model_id'] ?>" id="<?= $row['model_id'] ?>" target="_blank"> View （<?= $row['total_variant'] ?> ) </a></td>
                                                <td><?= $row['created_date'] ?></td>

                                                <td><a href="<?= base_url() ?>/model/delete/<?= $row['model_id']?>" class="btn btn-danger delete-button" ><i class="fa fa-trash"></i> Delete</a></td>

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
            </div>

            <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Add Model</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data"  method="POST" action="<?=base_url('/model/add');?>">
                        <div class="modal-body">
                    
                            <?=  $final_form_model ?>
                            <input type="hidden" name="brand_id" value="<?= $brand['brand_id'] ?>">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>



            
            <div class="modal fade" id="modal_add_variant" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Add Variant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data"  method="POST" action="<?=base_url('/Variant/add');?>">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Variant</label>
                                <input type="text" class="form-control" name="variant">
                            </div>
                            <input type="hidden" name="model_id" id="model_id">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            
            
            <div class="modal fade" id="model_view_variant" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">View Model</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data"  method="POST" action="<?=base_url('/model/add');?>">
                        <div class="modal-body">
                    
                            <?=  $final_form_model ?>
                            <input type="hidden" name="brand_id" value="<?= $brand['brand_id'] ?>">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>

            <script>
        $(".add_variant").on("click", function() {
            $('#modal_add_variant').modal('show');
            var model_id = $(this).attr('id');
            $('#model_id').val(model_id);
        });
         
            </script>