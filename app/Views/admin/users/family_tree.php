<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        /* font-family: Verdana, Geneva, Tahoma, sans-serif; */
    }

    html,
    body {
        width: 100%;
        height: 100%;
    }

    .container {
        width: 100%;
        margin: 0 auto;
        position: relative;
        text-align: center;
    }

    .container::before {
        position: absolute;
        left: 50%;
        content: '';
        width: 5px;
        height: 100%;
        background-color: rgb(231, 230, 230);
        border-radius: 5px;
    }

    .entry {
        margin: 50px 10px;
        position: relative;
    }

    .indicator {
        position: absolute;
        top: -5px;
        left: calc(50% - 5px);
        width: 15px;
        height: 15px;
        background: linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998) !important;
        border-radius: 50%;
    }

    .indicator span {
        position: relative;
        top: -5px;
        width: 7px;
        height: 7px;
        display: inline-block;
        background: linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998) !important;
        border-radius: 50%;
    }

    .content {
        width: 150px;
        margin: 0 auto;
        transform: translate(-58%, -9px);
        font-size: 14px;
        text-align: right;
    }

    .entry:nth-child(odd) .content {
        text-align: left;
        transform: translate(60%, -9px);
    }

    .content span {
        font-weight: 500;
        font-size: 16px;
        display: block;
        color: black;
    }

    .time {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translate(-130%, -48%);
        font-size: 14px;
        /* padding: 5px 10px; */
        border-radius: 25px;
        /* background: linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important; */

        /* box-shadow: 0 3px 6px 0 rgba(250, 113, 49, 0.658); */
        color: white;
        display: inline-block;
    }

    .entry:nth-child(even) .time {
        transform: translate(40%, -48%);
    }

    @media only screen and (max-width: 600px) {
        .container {
            margin: 0;
        }

        .entry:nth-child(even) .content,
        .entry:nth-child(odd) .content {
            text-align: left;
            transform: translate(60%, -9px);
        }

        .entry:nth-child(even) .time,
        .entry:nth-child(odd) .time {
            transform: translate(-130%, -48%);
        }
    }

    .c-body {
        position: relative;
        max-width: 500px;
        min-height: 787px;
        margin: 0 auto;
        background-color: #fff;
        justify-content: center;
        overflow: hidden;
        background: rgb(49, 27, 110);
        background: linear-gradient(180deg, rgba(49, 27, 110, 1) 0%, rgba(46, 195, 201, 1) 100%);


}


/* Absolute Center CSS Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>


<?php


?>

<div class="loading" style="display:none">Loading&#8230;</div>

<div class="col-sm-12 d-flex" style="width: 100vw;justify-content: space-between;margin-bottom:20px;margin-top:20px;">
    <!-- <a href="">+</a> -->
    <div class="icon_top">
        <a href="<?= base_url() ?>/users/dashboard/1">
            <i class="fa fa-arrow-left fa-2x text-white" aria-hidden="true"></i>
        </a>
    </div>
    <div>
        <h5 class="text-white font-weight-bold">Family Tree</h5>
    </div>
    <div>

    </div>
    <!-- <div class="icon_top" data-toggle="modal" data-target="#status_modal">
                    <a href="<?= base_url() ?>/users/tree/1" class="text-white">View Tree</a>
            </div> -->

</div>

<div class="container">
    <?php foreach ($level_arr as $row) { ?>
        <div class="entry">
            <div class="indicator">
                <span></span>
            </div>
            <p class="content text-white">
                Level (<?= $row['level'] ?>)
                <br>
                <span class="<?= $row['status'] == 'Success' ? 'text-success' : 'text-danger' ?>">
                <?= $row['status'] ?></span>
            </p>
            <div class="time">
                <a class="view_level" id="<?= $row['level'] ?>">
                    <img src="<?= base_url() ?>/assets/img/Group 83.png" alt="">

                    <!-- Level <?= $row['level'] ?> -->

                </a>
            </div>
        </div>
    <?php } ?>

</div>


<div class="modal fade" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="users_list">

            </div>
        </div>
    </div>
</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script src="<?= base_url() ?>/assets/js/bootstrap.min"></script>
<script src="<?= base_url() ?>/assets/js/bjs.js"></script>



<script>
    $('.view_level').on('click', function() {
        var level = $(this).attr('id');

        $(".loading").css("display", "block");
        // alert('')
        $.post("<?= base_url('users/get_user_level') ?>", {
            level: level
        }, function(html) {
            //pass the user html here
            $('#users_list').html(html);
            $(".loading").css("display", "none");

            $('#status_modal').modal('show');
        });

    });
</script>