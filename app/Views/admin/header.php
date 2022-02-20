<!DOCTYPE html>




<html lang="en">
    <head>
        <!-- <base href="./"> -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=Gplanice-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Gplan Admin Panel</title>
        <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@1.0.0/css/all.min.css">
        <!-- Main styles for this application-->
        <link href="<?= base_url(
            'assets/css/core/style.css'
        ) ?>" rel="stylesheet">
		<link href="<?= base_url('assets/css/core/custom.css') ?>" rel="stylesheet">
        <link href="<?= base_url(
            'assets/plugins/chartjs/css/chartjs.css'
        ) ?>" rel="stylesheet">
		<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable/css/dataTables.bootstrap4.css"> -->
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <script src="https://kit.fontawesome.com/3d15aa1b08.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="<?= base_url(
            'assets/plugins/select2/select2.css'
        ) ?>">

            <link href="<?= base_url() ?>/assets/plugins/chartjs/css/chartjs.css" rel="stylesheet">





<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script> -->


    </head>
    <body class="c-app">
        <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
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
<a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Users'
    ? 'c-active'
    : null ?>" href="<?= base_url('Users') ?>">
<i class="cil-people c-sidebar-nav-icon"></i>
Users
<span class="badge badge-pill badge-warning"><?= $undone_user ?></span>

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
                    <i class="cil-smile c-sidebar-nav-icon"></i>
                    Transaction

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
                    .delete-button{
                        display: none;
                    }
                </style>
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

                    <li class="c-sidebar-nav-title">User</li>

<li class="c-sidebar-nav-item ">
<a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Users/detail/1'
    ? 'c-active'
    : null ?>" href="<?= base_url('Users/detail/1') ?>">
<i class="cil-people c-sidebar-nav-icon"></i>
Personal Detail

<span class="badge badge-pill badge-warning"></span>

</a>

</li>

<li class="c-sidebar-nav-item ">
<a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Users/qrcode/1'
    ? 'c-active'
    : null ?>" href="<?= base_url('Users/qrcode/1') ?>">
<i class="cil-people c-sidebar-nav-icon"></i>
QR Code

<span class="badge badge-pill badge-warning"></span>

</a>

</li>

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
        <div class="c-wrapper c-fixed-components">
        <header class="c-header c-header-light c-header-fixed">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show" style="line-height: 1;">
            <i class="cil-menu c-icon c-icon-lg"></i>
            </button>
            <a class="c-header-brand d-lg-none c-header-brand-sm-up-center" href="<?= base_url() ?>/dashboard">
                <!-- <svg width="118" height="46" alt="CoreUI Logo">
                    <use xlink:href="assets/brand/coreui-pro.svg#full"></use>
                </svg> -->Gplan
            </a>
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true" style="line-height: 1;">
            <i class="cil-menu c-icon c-icon-lg"></i>
            </button>
            <ul class="c-header-nav d-md-down-none">
                <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="<?= base_url() ?>/dashboard">Dashboard</a></li>
            </ul>

            <ul class="c-header-nav mfs-auto">
                <li class="c-header-nav-item px-3 c-d-legacy-none">
                    <button class="c-class-toggler c-header-nav-btn" type="button" id="headertooltip" data-target="body" data-class="c-dark-theme" data-toggle="c-tooltip" data-placement="bottom" title="" data-original-title="Toggle Light/Dark Mode" aria-describedby="">
                    <i class="cil-moon c-icon c-d-dark-none"></i>
                    <i class="cil-sun c-icon c-d-default-none"></i>
                    </button>

                </li>
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
                
                <li class="c-header-nav-item dropdown">
                    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="c-avatar"><img class="c-avatar-img" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/2048px-User_icon_2.svg.png" alt=""></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0">
                        <div class="dropdown-header bg-light py-2">
                            <strong> <?= session()->get('login_data')[
                                'name'
                            ] ?></strong>
                        </div>
                        <!-- <a class="dropdown-item" href="#">
                            <i class="cil-user c-icon mfe-2"></i>
                            Profile
                        </a> -->
                        <!-- <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item" href="<?= base_url() ?>/access/logout">
                            <i class="cil-account-logout c-icon mfe-2"></i>
                            Logout
                        </a>
                    </div>
                </li>
                <li class="c-header-nav-item px-2 c-d-legacy-none"></li>
            </ul>
            
        </header>
        <div class="c-body">
			