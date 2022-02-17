<!DOCTYPE html>

<html lang="en">
    <head>
        <!-- <base href="./"> -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=CarLinkice-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Car Link Admin Panel</title>
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

    </head>
    <body class="c-app">
        <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
            <div class="c-sidebar-brand d-md-down-none">
                <!-- <svg class="c-sidebar-brand-full" width="118" height="46" alt="CarLinkUI Logo">
                    <use xlink:href="assets/brand/coreui-pro.svg#full"></use>
                </svg>
                <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CarLinkUI Logo">
                    <use xlink:href="assets/brand/coreui-pro.svg#signet"></use>
				</svg> -->
				<span class="c-sidebar-brand-full" style="font-size:20px;">CarLink. </span>
				<span class="c-sidebar-brand-minimized" style="font-size:20px;">CarLink</span>
            </div>
            <?php $uri = service('uri');
// $session = session();
// $session = \Config\Services::session();
?>
            <ul class="c-sidebar-nav ps ps--active-y">
            <?php
            if (session()->get('login_data')['type_id'] == "0") {
            ?>
                
                 
                <li class="c-sidebar-nav-item ">
                    <!-- <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'About'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('About') ?>">
                    <i class="cil-drop c-sidebar-nav-icon"></i>
                    About
                    </a>
                    </li>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Variant'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Variant') ?>">
                    <i class="cil-star c-sidebar-nav-icon"></i>
                    Variant
                    </a>

                    </li>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Service'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Service') ?>">
                    <i class="cil-school c-sidebar-nav-icon"></i>
                    Service
                    </a>
                    </li>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'AuctionStatus'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('AuctionStatus') ?>">
                    <i class="cil-list-filter c-sidebar-nav-icon"></i>
                    AuctionStatus
                    </a>
                    </li> -->
                    <li class="c-sidebar-nav-title">Operation</li>


                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Auction'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Auction') ?>">
                    <i class="cil-elevator c-sidebar-nav-icon"></i>
                    Auction 
                    </a>
                    </li>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'AuctionSection'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('AuctionSection') ?>">
                    <i class="cil-euro c-sidebar-nav-icon"></i>
                    Auction Time
                    </a>
                    </li>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Car'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Car') ?>">
                    <i class="cil-scrubber c-sidebar-nav-icon"></i>
                    Car
                    </a>
                    </li>
                  
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Topup'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Topup') ?>">
                    <i class="cil-storage c-sidebar-nav-icon"></i>
                    WalletTopup
                    <span class="badge badge-pill badge-warning"><?= $undone_topup ?></span>
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
<li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'BestOffer'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('BestOffer') ?>">
                    <i class="cil-storage c-sidebar-nav-icon"></i>
                    Sell My Car Form
                    <span class="badge badge-pill badge-warning"><?= $undone_offer ?></span>

                    </a>
                    </li>
                      
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'GetInTouch'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('GetInTouch') ?>">
                    <i class="cil-storage c-sidebar-nav-icon"></i>
                    Contact Form
                    <span class="badge badge-pill badge-warning"><?= $undone_intouch ?></span>

                    </a>
                    </li>



                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'NotificationUpdate'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('NotificationUpdate') ?>">
                    <i class="cil-send c-sidebar-nav-icon"></i>
                    Maintenance Notification
                    </a>
                    </li>
                   
                

              
                    
                  
                 
               
<!--               
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Auction'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Auction/Ended') ?>">
                    <i class="cil-elevator c-sidebar-nav-icon"></i>
                    Auction Ended
                    <span class="badge badge-pill badge-warning"><?= $undone_auction ?></span>

                    </a>
                    </li> -->
                    <!-- 

                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Bid'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Bid') ?>">
                    <i class="cil-fax c-sidebar-nav-icon"></i>
                    Bid
                    </a>
                    </li>

                 
                

                    <!-- <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Notification'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Notification') ?>">

                    <i class="cil-send c-sidebar-nav-icon"></i>
                    Notification
                    </a>
                    </li> -->
                  
                 
                  

                    <li class="c-sidebar-nav-divider"></li>
                    <li class="c-sidebar-nav-title">Components</li>
                    <li class="c-sidebar-nav-dropdown">
                        <!-- <a class="c-sidebar-nav-dropdown-toggle" href="">
                            <i class="cil-settings c-sidebar-nav-icon"></i>
                            Settings
                        </a> -->
                        <!-- <ul class="c-sidebar-nav-dropdown-items"> -->

                        <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Banner'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Banner') ?>">
                    <i class="cil-drop c-sidebar-nav-icon"></i>
                    Banner
                    </a>
                    </li>
                    
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Brand'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Brand') ?>">
                    <i class="cil-pool c-sidebar-nav-icon"></i>
                    Brand & Model
                    </a>
                    </li>
                    
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'State'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('State') ?>">
                    <i class="cil-moon c-sidebar-nav-icon"></i>
                    State
                    </a>
                    </li>

                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Color'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Color') ?>">

                    <i class="cil-lightbulb c-sidebar-nav-icon"></i>
                    Car Color
                    </a>
                    </li>
                     
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Sticker'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Sticker') ?>">

                    <i class="cil-lightbulb c-sidebar-nav-icon"></i>
                    Car Sticker
                    </a>
                    </li>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'TransferFee'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('TransferFee') ?>">
                    <i class="cil-pool c-sidebar-nav-icon"></i>
                    Transfer Fee
                    </a>
                    </li>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Wallet'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Wallet') ?>">
                    <i class="cil-smile c-sidebar-nav-icon"></i>
                    Transaction

                    </a>
                    </li>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Qna'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Qna') ?>">
                    <i class="cil-star c-sidebar-nav-icon"></i>
                    QnA
                    </a>
                    </li>
                         
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'QnaType'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('QnaType') ?>">
                    <i class="cil-task c-sidebar-nav-icon"></i>
                    QnA Type                   
                 </a>
                    </li>

                        <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'NotificationType'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('NotificationType') ?>">
                    <i class="cil-tags c-sidebar-nav-icon"></i>
                    Notification Type
                    </a>
                    </li>
                  
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'InspectionDetail'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('InspectionDetail') ?>">
                    <i class="cil-loop c-sidebar-nav-icon"></i>
                    Inspection Detail
                    </a>
                    </li>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'InspectionPart'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('InspectionPart') ?>">
                    <i class="cil-locomotive c-sidebar-nav-icon"></i>
                    Inspection Part
                    </a>
                    </li>
               
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'InspectionType'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('InspectionType') ?>">
                    <i class="cil-lock-unlocked c-sidebar-nav-icon"></i>
                    Inspection Type
                    </a>
                    </li>

                  <!-- <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Toturial'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Toturial') ?>">
                    <i class="cil-menu c-sidebar-nav-icon"></i>
                    Tutorial
                    </a>
                    </li> -->
                   
                    
                
                  
                 

                    <li class="c-sidebar-nav-title">User</li>

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
<a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Admin'
? 'c-active'
: null ?>" href="<?= base_url('Admin') ?>">
<i class="cil-people c-sidebar-nav-icon"></i>
Admin & Inspector
</a>
</li>
                  
                        </ul>
                    </li>

            <?php } ?>




            <?php
            if (session()->get('login_data')['type_id'] == "1") {
            ?>

                <style>
                    .delete-button{
                        display: none;
                    }
                </style>
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Car'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Car') ?>">
                    <i class="cil-scrubber c-sidebar-nav-icon"></i>
                    Car
                    </a>
                    </li>
                  
                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'Brand'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('Brand') ?>">
                    <i class="cil-pool c-sidebar-nav-icon"></i>
                    Brand & Model
                    </a>
                    </li>

                    <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link <?= $uri->getSegment(1) == 'State'
                    ? 'c-active'
                    : null ?>" href="<?= base_url('State') ?>">
                    <i class="cil-moon c-sidebar-nav-icon"></i>
                    State
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
                </svg> -->CarLink
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
                        <div class="c-avatar"><img class="c-avatar-img" src="<?= base_url() ?>/public/Default-User-Image.jpg" alt=""></div>
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
			