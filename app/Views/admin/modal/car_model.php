<div class="modal fade" id="<?= $modal_id ?>" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalAddLabel">Add Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data"  method="POST" action="<?=base_url($url);?>">
                <div class="modal-body">
                    <?php foreach($form_arr as $row){ ?>
                        <?= $form[$row] ?>
                    <?php } ?>
                    <input type="hidden" name="<?= $key ?>" value="<?= $id ?>">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>
