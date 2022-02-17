<?php foreach($car_inspection_detail as $row_detail){
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
        <?php if($row_detail['status_id'] != 2 && $row_detail['status_id'] != 3){ ?>
            <a class="btn btn-danger text-white change_status" inspection_part_id = '<?= $row['inspection_part_id'] ?>' car_inspection_id = "<?= $row_detail['car_inspection_id'] ?>" status_id = '2'>Fail</a>
        <?php } ?>
        <?php if($row_detail['status_id'] != 3){ ?>
            <a class="btn btn-primary text-white change_status" inspection_part_id = '<?= $row['inspection_part_id'] ?>' car_inspection_id = "<?= $row_detail['car_inspection_id'] ?>" status_id = '3'>NA</a>
        <?php } ?>
        <a class="btn btn-danger text-white delete_btn" inspection_part_id = '<?= $row['inspection_part_id'] ?>' inspection_detail_id = '<?= $row_detail['inspection_detail_id'] ?>' car_inspection_id = "<?= $row_detail['car_inspection_id'] ?>">Delete</a>

    </span>

    </div>
<?php } ?>


<script>
       
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
    data = JSON.parse(data);
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
                        get_percentage_and_pass_fail(inspection_part_id)
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

                $(".icon_add").on("click", function(e) {
                    var inspection_part_id = $(this).attr('id');
                    $('.inspection_part_id').val(inspection_part_id);
                    $('#car_detail_modal').modal('show');
                });



                $(".icon_add_image").on("click", function(e) {
                    var car_inspection_id = $(this).attr('id');
                    $('.car_inspection_id').val(car_inspection_id);
                    $('#car_inspection_image_modal').modal('show');
                });
                
</script>