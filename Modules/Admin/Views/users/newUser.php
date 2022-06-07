<?php $this->extend("\Modules\Admin\Views\_layout\\template.php") ?>

<!-- Page Title Comes Here -->
<?php $this->section("title") ?>
Create New User
<?php $this->endsection(); ?>

<?php $this->section("page_title") ?>
New User Registration
<?php $this->endsection(); ?>

<!-- StyleSheets Comes Here -->
<?php $this->section("styles") ?>

<?php $this->endsection(); ?>


<!-- Body Comes Here -->
<?php $this->section("body") ?>

<div class="row">
    <div class="col-md-12 ml-auto mr-auto">

        <form enctype="multipart/form-data" method="POST" id="userDetails" role="form" action="<?php echo ADMINBASEURL; ?>create_user_submit">
            <div class="card ">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">person</i>
                    </div>
                    <h4 class="card-title">New User</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleName" class="bmd-label-floating">
                                    First Name </label>
                                <input type="text" class="form-control" name="fname" id="fname">
                            </div>

                            <div class="form-group">
                                <label for="exampleName" class="bmd-label-floating">Last Name
                                </label>
                                <input type="text" class="form-control" name="lname" id="lname">
                            </div>

                            <div class="form-group">
                                <label for="exampleDesignation" class="bmd-label-floating">Mobile</label>
                                <input type="text" class="form-control" name="mobile" id="mobile">
                            </div>

                            <div class="form-group">
                                <label for="examplePass" class="bmd-label-floating">Email
                                    <span style="color:red">*</span></label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>

                            <select class="selectpicker" data-style="select-with-transition" title="Select Gender" data-size="7" name="gender" id="gender">
                                <option value="">Select</option>
                                <option value="male">Male </option>
                                <option value="female">Female </option>
                            </select>

                            <div class="form-group">
                                <label for="examplePass" class="bmd-label-floating">Password
                                </label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <div class="form-group">
                                <label for="exampleName" class="bmd-label-floating">Confirm Password
                                </label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>

                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12" style="margin:0.4rem 2rem">
                            <div class="form-group">
                                <label for="exampleName" class="bmd-label-floating">Referred By
                                </label>
                                <input type="text" class="form-control" id="referral_id" name="referral_id">
                            </div>
                            <br />

                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    <img src="<?php echo base_url(); ?>/assets/img/image_placeholder.jpg" alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                    <span class="btn btn-teal btn-round btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" id="profile_pic" name="profile_pic" />
                                    </span>
                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>
                                        Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <button type="submit" class="btn btn-fill btn-teal">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php $this->endsection(); ?>


<!-- JS Script Comes Here -->
<?php $this->section("script") ?>

<?php $this->endsection(); ?>