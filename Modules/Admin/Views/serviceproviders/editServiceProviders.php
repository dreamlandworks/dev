<?php $this->extend("\Modules\Admin\Views\_layout\\template.php") ?>

<!-- Page Title Comes Here -->
<?php $title = "Edit SP Profile" ?>

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

<!--   My Code-->
<div class="row">
    <div class="col-md-12">
        <!-- <div>
                                    <a href="product.html">
                                        <button class="btn btn-primary" style="background-color:#8f6bf4">
                                            <b> <i class="material-icons">
                                                    <img src="../../assets/img/icons/keyboard_backspace-white-24dp.svg" />
                                                </i> Back </b>
                                        </button>
                                    </a>
                                </div> -->
        <div class="card ">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">
                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                    </i>
                </div>
                <h4 class="card-title"><?php echo $title ?></h4>
            </div>
            <div class="card-body ">
                <form method="POST" action="<?php echo ADMINBASEURL . 'updateSpDetails'; ?>">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleName" class="bmd-label-floating">
                                    First Name </label>
                                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $SpDetails->fname; ?>">
                                <input type="hidden" name="id" value="<?php echo $SpDetails->id; ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleName" class="bmd-label-floating">Last Name
                                </label>
                                <input type="text" class="form-control" id="name" name="lname" value="<?php echo $SpDetails->lname; ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleDesignation" class="bmd-label-floating">Mobile</label>
                                <input type="text" class="form-control" id="designation" name="mob" value="<?php echo $SpDetails->mobile; ?>">
                            </div>

                            <div class="form-group">
                                <label for="examplePass" class="bmd-label-floating">Email
                                    <span style="color:red">*</span></label>
                                <input type="email" class="form-control" id="examplePass" name="email" value="<?php echo $SpDetails->email; ?>">
                            </div>



                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">

                            <div class="">
                                <label for="exampleName" class="bmd-label-floating">Country
                                </label>
                                <select class="form-control" id="country" name="country">
                                    <option value="<?php echo $SpDetails->country_id; ?>"><?php echo $SpDetails->country; ?></option>
                                    <?php foreach ($countryList as $cntry) { ?>
                                        <option value="<?php echo $cntry->id; ?>"><?php echo $cntry->country; ?></option>
                                    <?php } ?>
                                </select>
                                <!-- <input type="text" class="form-control" id="country" name="country" value="<?php echo $SpDetails->country; ?>"> -->
                            </div>


                            <div class="">
                                <label for="exampleName" class="bmd-label-floating">State
                                </label>
                                <select class="form-control" id="state" name="state">
                                    <option value="<?php echo $SpDetails->state_id; ?>"><?php echo $SpDetails->state; ?></option>
                                </select>
                                <!-- <input type="text" class="form-control" id="state" name="state" value="<?php echo $SpDetails->state; ?>"> -->
                            </div>
                            <div class="">
                                <label for="exampleName">City
                                </label>
                                <br>
                                <select class="form-control" id="city" name="city">
                                    <option value="<?php echo $SpDetails->city_id; ?>"><?php echo $SpDetails->city; ?></option>
                                </select>
                                <!-- <input type="text" class="form-control" id="city" name="city" value="<?php echo $SpDetails->city; ?>"> -->
                            </div>
                        </div>
                    </div>

            </div>
            <div class="card-footer ">
                <button type="submit" class="btn btn-fill btn-teal">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MyCode ends here-->
<?php $this->endsection(); ?>



<!-- JS Script Comes Here -->
<?php $this->section("script") ?>

<script>
    $(document).ready(function() {
        var cntryId = <?php echo $SpDetails->country_id; ?>;
        var stateId = <?php echo $SpDetails->state_id; ?>;
        loadStateList(cntryId);
        loadCityList(stateId);

        function loadStateList(cntryId) {
            $.ajax({
                url: "<?php echo base_url('/ct/listOfStateAjax'); ?> ",
                method: "POST",
                data: {
                    countryId: cntryId,
                },
                dataType: "json",
                success: function(data) {

                    $.each(data, function(key, val) { //const [key, value] of Object.entries(test)
                        $('#state').append('<option value="' + val['id'] + '">' + val['state'] + '</option>');
                    });
                }

            })

        }

        function loadCityList(stateId) {
            $.ajax({
                url: "<?php echo base_url('/ct/listOfCity'); ?> ",
                type: "POST",
                data: {
                    stateId: stateId,
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(key, val) { //const [key, value] of Object.entries(test)
                        $('#city').append('<option value="' + val['id'] + '">' + val['city'] + '</option>');
                    });
                }

            })
        }

        $('#country').on('change', function() {
            cntryId = $(this).val();
            $('#state').html('');
            $('#state').append('<option value="">Please Select State</option>');
            $('#city').html('');
            $('#city').append('<option value="">Please Select State First</option>');
            loadStateList(cntryId);
        });
        $('#state').on('change', function() {
            stateId = $(this).val();
            $('#city').html('');
            $('#city').append('<option value="">Please Select City</option>');
            loadCityList(stateId);
        })
    });
</script>
<?php $this->endsection(); ?>