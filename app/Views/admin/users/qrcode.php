<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
    </ol>
    <!-- <div class="c-subheader-nav d-md-down-none mfe-2">
		<a class="c-subheader-nav-link" href="#">
			<i class="cil-settings c-icon"></i>
			&nbsp;Settings
		</a>
	</div> -->
</div>
<main class="c-main">

    <div class="container-fluid">

        <div class="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="c-card-header">
                            Referal Code
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>

                            </div>
                        </div>
                        <div class="c-card-body">
                            <div class="view-info">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <div class="row">

                                                    <div class="col-lg-12 col-xl-12">
                                                    <div class="c-cardbody">
                <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?= base_url() ?>/main/add/<?= $users['family_id'] ?>&choe=UTF-8" 
                style="margin: auto; border: 3px solid green; padding: 10px;display: block; margin-left: auto; margin-right: auto;">
                </div>
                                                        <!-- <a href="<?= base_url() ?>/Users/verify_user/<?= $users['users_id'] ?>" class="btn btn-<?= $users['is_verified'] == 1 ? "success" : "danger" ?>"><?= $users['is_verified'] == 1 ? "Verified" : "Not verified" ?></a> -->
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
