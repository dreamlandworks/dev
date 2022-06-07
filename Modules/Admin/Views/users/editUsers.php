<?php $this->extend("\Modules\Admin\Views\_layout\\template.php") ?>

<!-- Page Title Comes Here -->
<?php $title = "Edit User Details" ?>

<?php $this->section("site_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>

<?php $this->section("nav_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>

<?php $this->section("section_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>

<!-- CSS Styles Comes Here -->
<?php $this->section("styles") ?>
<style>
    .form-control {
        padding-left: 3px;
    }
</style>

<?php $this->endsection(); ?>



<!-- Body Comes Here -->
<?php $this->section("body") ?>

<!--   My Code-->
<div class="row">
    <div class="col-md-6 ml-auto mr-auto">
        <div>
            <a href="/ct/listUsers">
                <button class="btn btn-rose pull-right" style="margin-bottom:10px">
                    <i class="material-icons" style="padding-right:3px;">arrow_back_ios_new</i><span>Back to List Users</span>
                </button>
            </a>
        </div>

        <div class="card ">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">edit</i>
                </div>
                <h4 class="card-title">Edit User</h4>
            </div>
            <div class="card-body ">

                <form enctype="multipart/form-data" method="POST" id="userDetails" role="form" action="<?php echo ADMINBASEURL; ?>edit_user_submit">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">

                            <div class="form-group">
                                <input type="text" class="form-control" name="id" id="id" value="<?php echo $users['id']; ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="exampleName" class="bmd-label-floating">
                                    First Name </label>
                                <input type="text" class="form-control" name="fname" id="fname" value="<?php echo $users['fname']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleName" class="bmd-label-floating">Last Name
                                </label>
                                <input type="text" class="form-control" name="lname" id="lname" value="<?php echo $users['lname']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleDesignation" class="bmd-label-floating">Mobile</label>
                                <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo $users['mobile']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="examplePass" class="bmd-label-floating">Email
                                    <span style="color:red">*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo $users['email']; ?>">
                            </div>

                            <div class="form-group">
                                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $users['dob']; ?>">
                            </div>

                            <!-- <div class="form-group">
                                <input type="text" class="form-control datepicker" id="dob" name="dob" value="<?php echo $users['dob']; ?>">
                            </div> -->

                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12" style="margin:0.5rem 2rem">

                            <select class="selectpicker" data-size="7" data-style="btn btn-outline-danger">
                                <option <?= ($users['gender'] == 'male') ? 'selected' : ''; ?> value="male" selected>Male </option>
                                <option <?= ($users['gender'] == 'female') ? 'selected' : ''; ?> value="female">Female </option>
                                <option <?= ($users['gender'] == 'na') ? 'selected' : ''; ?> value="na">Prefer Not to Say</option>
                            </select>
                            <br>

                            <select class="selectpicker" data-style="select-with-transition" title="active" data-size="7" name="active" id="active" onchange="change()">
                                <option <?= ($users['active'] == 1) ? 'selected' : ''; ?> value="1" selected>Active </option>
                                <option <?= ($users['active'] == 2) ? 'selected' : ''; ?> value="2">Banned </option>
                            </select>

                            <div class="form-group" id="reason" <?php echo ($users['active'] == 2 ? "style='display:block'" : "style='display:none'"); ?>>
                                <label for="exampleName" class="bmd-label-floating">
                                    Reason for Ban </label>
                                <input type="text" class="form-control" name="reason" id="reason" value="<?php echo $users['reason_for_ban']; ?>"><br><br>
                            </div>


                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    <img src="<?= ($users['profile_pic']) ? base_url() . "/" . $users['profile_pic'] : base_url() . "/assets/img/image_placeholder.jpg" ?>" alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                    <span class="btn btn-rose btn-round btn-file">
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

                    <div class="card-footer ">
                        <button type="submit" class="btn btn-fill btn-rose">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- MyCode ends here-->
<?php $this->endsection(); ?>


<!-- JS Script Comes Here -->
<?php $this->section("script") ?>
<script>
    function change() {
        if ($('#active').val() == 2) {
            $("#reason").attr("style", "display:block");
        } else {
            $("#reason").attr("style", "display:none");
        }
    }
</script>
<?php $this->endsection(); ?>