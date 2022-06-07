<?php $this->extend("\Modules\Admin\Views\_layout\\template.php") ?>

<!-- Page Title Comes Here -->
<?php $title = "Create New User" ?>

<?php $this->section("site_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>

<?php $this->section("nav_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>

<?php $this->section("section_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>


<!-- StyleSheets Comes Here -->
<?php $this->section("styles") ?>

<?php $this->endsection(); ?>


<!-- Body Comes Here -->
<?php $this->section("body") ?>
<div class="col-md-6 ml-auto mr-auto">
    <?php $session = \Config\Services::session();
    $error = $session->getFlashdata('error');
    if ($error) { ?>
        <div class="alert card-alert card red alert-dismissable" style="background-color:red;text-align: center;">
            <div class="card-content white-text">
                <p><?php echo $error; ?></p>
            </div>
            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>

        </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-md-6 ml-auto mr-auto">

        <form enctype="multipart/form-data" method="POST" id="userDetails" role="form" action="<?php echo ADMINBASEURL; ?>create_user_submit">
            <div class="card">

                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">person</i>
                    </div>
                    <h4 class="card-title"><?php echo $title ?></h4>
                </div>
                <div class="card-body" style="padding-left:5%;padding-right:5%;">
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
                                <label for="exampleDesignation" class="bmd-label-floating">Mobile
                                    <span style="color:red">*</span></label>
                                <input type="text" class="form-control" name="mobile" id="mobile">
                            </div>

                            <div class="form-group">
                                <label for="examplePass" class="bmd-label-floating">Email
                                    <span style="color:red">*</span></label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control datepicker" placeholder="Date of Birth" name="dob" value="">
                            </div>

                            <div class="form-group">
                                <label for="lname" class="bmd-label-floating">Referred by ID</label>
                                <input type="text" class="form-control" id="lname">
                            </div>

                            <div class="category form-category">* Required fields</div>

                        </div>

                        <div class="col-lg-5 col-md-6 col-sm-12" style="padding-left:5%; margin-left:5%">

                            <select class="selectpicker" data-size="7" data-style="btn btn-outline-danger">
                                <option value="1" selected>Male</option>
                                <option value="2">Female</option>
                                <option value="3">Prefer Not to Say</option>
                            </select>
                            <br>

                            <h4 class="title">Profile Pic</h4>
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    <img src="<?php echo base_url(); ?>/assets/img/image_placeholder.jpg" alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                    <span class="btn btn-rose btn-round btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="profile_pic" />
                                    </span>
                                    <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                </div>
                            </div>

                            <!-- <div class="fileinput fileinput-new text-center" data-provides="fileinput">
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
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <button type="submit" class="btn btn-fill btn-rose">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php $this->endsection(); ?>


<!-- JS Script Comes Here -->
<?php $this->section("script") ?>
<script>
    $(document).ready(function() {
        // initialise Datetimepicker and Sliders
        md.initFormExtendedDatetimepickers();
        if ($('.slider').length != 0) {
            md.initSliders();
        }
    });
</script>
<?php $this->endsection(); ?>