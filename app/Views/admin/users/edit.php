<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>/users">User</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>/users/edit/<?= $users['users_id']?>">Edit User Details</a></li>
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
        <div class="card">
            <div class="card-header">
                Edit User Details
                <div class="card-header-actions">
                    <a class="card-header-action">
                        <i class="cil-arrow-circle-top c-icon minimize-card"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form role="form" method="POST" enctype="multipart/form-data" action="<?= base_url()?>/users/edit/<?=$users["users_id"]?>">
                    <!-- <div class="form-group">
                        <label for="">Profile Picture</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail">
                            <label class="custom-file-label" for="" aria-describedby="">Choose file</label>
                        </div>
                    </div> -->
                             <?php if (isset($error)) { ?>
                                <div class="alert-message" role="alert">
                                        <?= $error; ?>
                                    </div>
                                <?php } ?>

                                <div class="form-group">
                                    <label for="">User Name</label>
                                    <input type="text" class="form-control" value="<?= $users['username'] ?>" name="username"  placeholder="User Name"  >
                                </div>

                    <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" value="<?=  $users['name'] ?>" name="name" placeholder="Name" required>
                                </div>
                               
                                <div class="form-group">
                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control" name="contact" value="<?=  $users['contact'] ?>" placeholder="Contact Number" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?=  $users['email'] ?>" placeholder="Email" required>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="">Nric</label>
                                    <input type="text" name="nric" class="form-control" value="<?=  $users['nric'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Nric Name</label>
                                    <input type="text" name="nric_name" class="form-control" value="<?=  $users['nric_name'] ?>">
                                </div>

                            
                                <div class="form-group">
                                    <label for="">Nric Front</label>
                                    <input type="file" name="nric_front" class="form-control" accept="image/png, image/jpeg" >
                                </div>
                                <div class="form-group">
                                    <label for="">Nric Back</label>
                                    <input type="file" name="nric_back" class="form-control" accept="image/png, image/jpeg" >
                                </div> -->
                    

                                <div class="form-group">
                                    <label for="">Password (leave this field blank if not changing password)</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" >
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password (leave this field blank if not changing password)</label>
                                    <input type="password" class="form-control" name="password2" placeholder="Confirm Password" >
                                </div>
                
                    
                    <div class="form-group">
                        <button class="btn btn-primary float-right" type="submit"> Submit</button>
                    </div>
                </form>
            </div>
            
        </div>