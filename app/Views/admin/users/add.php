<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>/users">User</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>users/add">Create New User</a></li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Create New User
                            <div class="card-header-actions">
                                <a class="card-header-action">
                                    <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url('/users/add'); ?>">
                                <!-- <div class="form-group">
                                <label for="">Profile Picture</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                </div>
                            </div> -->
                                <?php if (isset($error)) { ?>
                                    <div class="alert-message" role="alert">
                                        <?= $error; ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Refer By Which User</label>
                                    <select name="family_id" id="" class="form-control">
                                            <option value="0">None</option>
                                            <?php foreach($users as $row){ ?>
                                                <option value="<?= $row['family_id'] ?>"><?= $row['family_id'] ?> <?= $row['name'] ?></option>


                                            <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">User Name</label>
                                    <input type="text" class="form-control" name="username" placeholder="User Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" class="form-control" name="password2" placeholder="Confirm Password" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control" name="contact" placeholder="Contact Number" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>

                                
                                <div class="form-group">
                                <label for="">Receipt</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile02" name="receipt">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                </div>
                            </div>

                                <!-- <div class="form-group">
                                    <label for="">Nric</label>
                                    <input type="text" name="nric" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="">Nric Name</label>
                                    <input type="text" name="nric_name" class="form-control" >
                                </div>
 
                                <div class="form-group">
                                    <label for="">Nric Front</label>
                                    <input type="file" name="nric_front" class="form-control" accept="image/png, image/jpeg" >
                                </div>
                                <div class="form-group">
                                    <label for="">Nric Back</label>
                                    <input type="file" name="nric_back" class="form-control" accept="image/png, image/jpeg" >
                                </div>
                              -->
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="submit"> Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
