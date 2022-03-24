<!DOCTYPE html>


<html lang="en">

<head>
    <!-- <base href="./"> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=Gplanice-width, initial-scale=1.0, shrink-to-fit=no">
    <?php if(isset($users[0]['username'])){ ?>
        <title>
  <?= $users[0]['username'] ?>
</title>
    <?php }else{ ?>
        <title>Gplan Admin Panel</title>

    <?php } ?>
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@1.0.0/css/all.min.css">
    <!-- Main styles for this application-->
    <link href="<?= base_url(
                    'assets/css/core/style.css'
                ) ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/core/custom.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/css/new.css') ?>" rel="stylesheet">
    <link href="<?= base_url(
                    'assets/plugins/chartjs/css/chartjs.css'
                ) ?>" rel="stylesheet">
    <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable/css/dataTables.bootstrap4.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <!-- <script src="https://kit.fontawesome.com/3d15aa1b08.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

    <link rel="stylesheet" href="<?= base_url(
                                        'assets/plugins/select2/select2.css'

                                    ) ?>">


    <link href="<?= base_url() ?>/assets/plugins/chartjs/css/chartjs.css" rel="stylesheet">

    <!-- Slick-Silder-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>




    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script> -->


</head>


<?php if (session()->get('login_data')['type_id'] == '1') { ?>

<body class="c-maxContainter">
<?php }else{ ?>
    <body >

<?php } ?>
    <div class="c-app">
        <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show <?= (session()->get('login_data')['type_id'] == '1') ? 'd-none' : '' ?>" id="sidebar">
            <div class="c-sidebar-brand d-md-down-none">
                <!-- <svg class="c-sidebar-brand-full" width="118" height="46" alt="GplanUI Logo">
                    <use xlink:href="assets/brand/coreui-pro.svg#full"></use>
                </svg>
                <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="GplanUI Logo">
                    <use xlink:href="assets/brand/coreui-pro.svg#signet"></use>
				</svg> -->
                <span class="c-sidebar-brand-full" style="font-size:20px;">Gplan. </span>
                <span class="c-sidebar-brand-minimized" style="font-size:20px;">Gplan</span>
            </div>
            <?php $uri = service('uri');
            // $session = session();
            // $session = \Config\Services::session();
            ?>
            <ul class="c-sidebar-nav ps ps--active-y">
                <?php if (session()->get('login_data')['type_id'] == '0') { ?>





                    <li class="c-sidebar-nav-title">Operation</li>
                    <li class="c-sidebar-nav-item ">
                        <a class="c-sidebar-nav-link <?= $uri->getSegment(1) ==
                                                            'Banner'

                                                            ? 'c-active'
                                                            : null ?>" href="<?= base_url('Banner') ?>">
                            <i class="cil-money c-sidebar-nav-icon"></i>
                            Advertisement

                        </a>
                    </li>

                    <li class="c-sidebar-nav-item ">
                        <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Qrcode'
                                                            ? 'c-active'
                                                            : null ?>" href="<?= base_url('Banner/qrcode') ?>">
                            <i class="cil-people c-sidebar-nav-icon"></i>
                            Tng QrCode
                            <span class="badge badge-pill badge-warning"></span>

                        </a>

                    </li>

                    <li class="c-sidebar-nav-item ">
                        <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Users'
                                                            ? 'c-active'
                                                            : null ?>" href="<?= base_url('Users') ?>">
                            <i class="cil-people c-sidebar-nav-icon"></i>
                            Registration
                            <span class="badge badge-pill badge-warning"><?= $undone_user ?></span>

                    </a>
                </li>
                <li class="c-sidebar-nav-item ">
                        <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Users'
                                                            ? 'c-active'
                                                            : null ?>" href="<?= base_url('Users/verified_member') ?>">
                            <i class="cil-people c-sidebar-nav-icon"></i>
                            Verified Member
                            <span class="badge badge-pill badge-warning"></span>

                    </a>
                </li>
                
                <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(2) == 'paid_user'
                                                        ? 'c-active'
                                                        : null ?>" href="<?= base_url('Users') ?>/paid_user">
                        <i class="cil-people c-sidebar-nav-icon"></i>
                        Paid User
                        <span class="badge badge-pill badge-warning"></span>

                        </a>

                    </li>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(2) == 'unpaid_user'
                                                        ? 'c-active'
                                                        : null ?>" href="<?= base_url('Users') ?>/unpaid_user">
                        <i class="cil-people c-sidebar-nav-icon"></i>
                        Unpaid User
                        <span class="badge badge-pill badge-warning"></span>

                        </a>

                    </li>




                    <li class="c-sidebar-nav-item ">

                        <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Withdraw'
                                                            ? 'c-active'
                                                            : null ?>" href="<?= base_url('Withdraw') ?>">
                            <i class="cil-storage c-sidebar-nav-icon"></i>
                            Withdrawal
                            <span class="badge badge-pill badge-warning"><?= $undone_withdraw ?></span>

                        </a>
                    </li>






                    <li class="c-sidebar-nav-divider"></li>
                    <li class="c-sidebar-nav-title">Components</li>

                    <li class="c-sidebar-nav-item ">
                        <a class="c-sidebar-nav-link <?= $uri->getSegment(1) ==
                                                            'Wallet'

                                                            ? 'c-active'
                                                            : null ?>" href="<?= base_url('Wallet') ?>">
                            <i class="cil-money  c-sidebar-nav-icon"></i>
                            Transaction

                        </a>
                    </li>



                    <li class="c-sidebar-nav-item ">
                        <a class="c-sidebar-nav-link <?= $uri->getSegment(1) ==
                                                            'Users/user_with_no_downline/1'

                                                            ? 'c-active'
                                                            : null ?>" href="<?= base_url('Users/user_with_no_downline/1') ?>">
                            <i class="cil-money c-sidebar-nav-icon"></i>
                            User With No Downline

                        </a>
                    </li>




                    <!--                    
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) ==
                                                        'CompanyProfit'
                                                        ? 'c-active'
                                                        : null ?>" href="<?= base_url('CompanyProfit') ?>">
                    <i class="cil-smile c-sidebar-nav-icon"></i>
                    Company Profit

                    </a>
                    </li> -->



                    <!-- <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) ==
                                                        'Toturial'
                                                        ? 'c-active'
                                                        : null ?>" href="<?= base_url('Toturial') ?>">
                    <i class="cil-menu c-sidebar-nav-icon"></i>
                    Tutorial
                    </a>
                    </li> -->






                    <li class="c-sidebar-nav-title">Admin</li>

                    <li class="c-sidebar-nav-item ">
                        <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Admin'
                                                            ? 'c-active'
                                                            : null ?>" href="<?= base_url('Admin') ?>">
                            <i class="cil-people c-sidebar-nav-icon"></i>
                            Admin
                        </a>
                    </li>

            </ul>
            </li>

        <?php } ?>




        <?php if (session()->get('login_data')['type_id'] == '1') { ?>

            <style>
                .delete-button {
                    display: none;
                }
            </style>
            <?php if (session()->get('login_data')['is_verified'] == '1') { ?>
                <!-- <li class="c-sidebar-nav-item ">

                <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Withdraw'
                                                    ? 'c-active'
                                                    : null ?>" href="<?= base_url('Withdraw') ?>">
                    <i class="cil-storage c-sidebar-nav-icon"></i>
                    Withdrawal
                    <span class="badge badge-pill badge-warning"></span>

                </a>
            </li> -->


            <?php } ?>








            <li class="c-sidebar-nav-divider"></li>
            <!-- <li class="c-sidebar-nav-title">Components</li> -->
            <!--                    
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) ==
                                                        'Wallet'
                                                        ? 'c-active'
                                                        : null ?>" href="<?= base_url('Wallet') ?>">
                    <i class="cil-smile c-sidebar-nav-icon"></i>
                    Transaction

                    </a>
                    </li>
                    -->

            <!-- <li class="c-sidebar-nav-title">User</li>

        <li class="c-sidebar-nav-item ">
            <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Users/dashboard/1'
                                                ? 'c-active'
                                                : null ?>" href="<?= base_url('Users/dashboard/1') ?>">
                <i class="cil-people c-sidebar-nav-icon"></i>
                Dashboard

                <span class="badge badge-pill badge-warning"></span>

            </a>

        </li> -->

            <!-- <li class="c-sidebar-nav-item ">
<a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Users/qrcode/1'
                                    ? 'c-active'
                                    : null ?>" href="<?= base_url('Users/qrcode/1') ?>">
<i class="cil-qr-code c-sidebar-nav-icon"></i>
QR Code

<span class="badge badge-pill badge-warning"></span>

</a>

</li> -->
            <?php if (session()->get('login_data')['is_verified'] == '1') { ?>


                <!-- <li class="c-sidebar-nav-item ">
                <a class="c-sidebar-nav-link <?= $uri->getSegment(1) ==
                                                    'Users/downline/1'

                                                    ? 'c-active'
                                                    : null ?>" href="<?= base_url('Users/downline/1') ?>">
                    <i class="cil-money c-sidebar-nav-icon"></i>
                    Downline

                </a>
            </li>





            <li class="c-sidebar-nav-item ">
                <a class="c-sidebar-nav-link <?= $uri->getSegment(1) ==
                                                    'Wallet'

                                                    ? 'c-active'
                                                    : null ?>" href="<?= base_url('Wallet') ?>">
                    <i class="cil-money c-sidebar-nav-icon"></i>
                    Transaction

                </a>
            </li>


            <li class="c-sidebar-nav-item ">
                <a class="c-sidebar-nav-link <?= $uri->getSegment(1) ==
                                                    'User/Tree/1'

                                                    ? 'c-active'
                                                    : null ?>" href="<?= base_url('Users/Tree/1') ?>">
                    <i class="cil-smile c-sidebar-nav-icon"></i>
                    Family Tree

                </a>
            </li> -->
            <?php } ?>


        <?php } ?>

        <li class="c-sidebar-nav-divider"></li>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 577px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 256px;"></div>
        </div>
        </ul>
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-unfoldable"></button>
        </div>
        <?php if (session()->get('login_data')['type_id'] == '0') { ?>

            <div class="c-wrapper c-fixed-components">
                
            <?php } else { ?>
                <div class="c-wrapper c-fixed-components" style="margin:0px;">
                <?php } ?>
                <?php if (session()->get('login_data')['type_id'] == '0') { ?>

                    <header class="c-header c-header-light c-header-fixed">

                        <?php if (session()->get('login_data')['type_id'] == '0') { ?>
                            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show" style="line-height: 1;">
                                <i class="cil-menu c-icon c-icon-lg"></i>
                            </button>
                            <a class="c-header-brand d-lg-none c-header-brand-sm-up-center" href="<?= base_url() ?>/dashboard">
                                <!-- <svg width="118" height="46" alt="CoreUI Logo">
                    <use xlink:href="assets/brand/coreui-pro.svg#full"></use>
                </svg> -->Gplan
                            </a>
                        <?php } ?>
                        <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true" style="line-height: 1;">
                            <i class="cil-menu c-icon c-icon-lg"></i>
                        </button>
                        <ul class="c-header-nav d-md-down-none">
                            <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="<?= base_url() ?>/dashboard">Dashboard</a></li>
                        </ul>

                        <ul class="c-header-nav mfs-auto">
                            <?php if (session()->get('login_data')['type_id'] == '0') { ?>
                                <li class="c-header-nav-item px-3 c-d-legacy-none">
                                    <button class="c-class-toggler c-header-nav-btn" type="button" id="headertooltip" data-target="body" data-class="c-dark-theme" data-toggle="c-tooltip" data-placement="bottom" title="" data-original-title="Toggle Light/Dark Mode" aria-describedby="">
                                        <i class="cil-moon c-icon c-d-dark-none"></i>
                                        <i class="cil-sun c-icon c-d-default-none"></i>
                                    </button>

                                </li>
                            <?php  } ?>
                        </ul>
                        <ul class="c-header-nav">
                            <!-- <li class="c-header-nav-item dropdown d-md-down-none mx-2">
                    <a class="c-header-nav-link">
                        <i class="cil-bell c-icon"></i>
                        <span class="badge badge-pill badge-danger">5</span>
                    </a>
                </li>
                <li class="c-header-nav-item dropdown d-md-down-none mx-2">
                    <a class="c-header-nav-link" >
                    <i class="cil-list-rich c-icon"></i>
                    <span class="badge badge-pill badge-warning">15</span>
                    </a>

                </li>

                <li class="c-header-nav-item dropdown d-md-down-none mx-2">
                    <a class="c-header-nav-link">
                        <i class="cil-envelope-open c-icon"></i>
                        <span class="badge badge-pill badge-info">7</span>
                    </a>
                </li> -->
                            <?php if (session()->get('login_data')['type_id'] == '1') { ?>

                                <li class="c-header-nav-item dropdown">
                                    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                        <div class="c-avatar"><img class="c-avatar-img" src="https://media.istockphoto.com/vectors/choose-or-change-language-icon-vector-illustration-on-isolated-vector-id957046406" alt=""></div>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right pt-0">
                                        <div class="dropdown-header bg-light py-2">
                                        </div>

                                        <a class="dropdown-item" href="<?= base_url() ?>/admin/set_lang/1">
                                            <i class="cil-cog c-icon mfe-2"></i>
                                            English
                                        </a>
                                        <a class="dropdown-item" href="<?= base_url() ?>/admin/set_lang/2">
                                            <i class="cil-cog c-icon mfe-2"></i>
                                            Chinese
                                        </a>
                                    </div>
                                </li>
                            <?php } ?>
                            <li class="c-header-nav-item dropdown">
                                <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <div class="c-avatar"><img class="c-avatar-img" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/2048px-User_icon_2.svg.png" alt=""></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right pt-0">
                                    <div class="dropdown-header bg-light py-2">
                                        <strong> <?= session()->get('login_data')['name'] ?></strong>
                                    </div>
                                    <!-- <a class="dropdown-item" href="<?= base_url() ?>/users/user_detail/1">
                                        <i class="cil-user c-icon mfe-2"></i>
                                        Profile
                                    </a> -->
                                    <!-- <a class="dropdown-item" href="#">
                            <i class="cil-user c-icon mfe-2"></i>
                            Profile

                        </a> -->
                                  <!-- <div class="dropdown-divider">
                                      
                                </div> -->
                                <a class="dropdown-item" href="<?= base_url() ?>/access/logout_admin">

                                    <i class="cil-account-logout c-icon mfe-2"></i>
                                    Logout
                                </a>
                </div>
                </li>
                <li class="c-header-nav-item px-2 c-d-legacy-none"></li>

                </ul>

                </header>

            <?php } ?>
            <?php if (session()->get('login_data')['type_id'] == '1') { ?>
                <!-- <div class="dropdown-divider"></div> -->
                <a class="dropdown-item" href="<?= base_url() ?>/access/logout">
                    <i class="cil-account-logout c-icon mfe-2"></i>
                    Logout
                </a>
            </div>
            </li>
            <!-- <li class="c-header-nav-item px-2 c-d-legacy-none"></li> -->
            </ul>

        </header>
        <?php } ?>
        

        <?php if (session()->get('login_data')['type_id'] == '1') { ?>

                    <div class="c-body">
                    <?php } else { ?>
                        <div class="c-body">

                        <?php } ?>