<?php $this->extend('Modules\User\Views\home') ?>


<?php $this->section('title') ?>
Browse Categories
<?php $this->endsection() ?>

<?php $this->section('styles') ?>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap" rel="stylesheet">

<!-- CSS Stylesheets -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/nice-select.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/flaticon.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/custom.css" type="text/css">


<?php $this->endsection() ?>

<?php $this->section('menu') ?>

<li><a href="index.php">Home</a></li>
<li><a href="#">Listed Jobs</a></li>
<li class="active"><a href="categories">Categories</a></li>
<li><a href="#">Blog</a></li>

<?php $this->endsection() ?>

<?php $this->section('content') ?>

<div class="row">
    <ul class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home" style="margin-right:10px;"></i>Home</a></li>
        <li>Categories</li>
    </ul>
    <div class="container-fluid nav-container" style="padding-right:100px;">
        <h2>Browse Categories</h2>
        <div class="cat-menu">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#tab1">Single Move Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#tab2">Blue Collar Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#tab3">Multi Move Category</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content container-fluid" style="padding-top:40px;">

                <!-- Tab1 Content Starts -->
                <div class="tab-pane active" id="tab1">
                    <div class="row">
                        <?php if ($single != null) {
                            if (count($single) > 0) {
                                foreach ($single as $s) {
                        ?>
                                    <div class="col-lg-4 nav-content">
                                        <div class="card" style="border:0px solid">
                                            <div class="card-body">
                                                <span>
                                                    <img src="<?php echo base_url() . $s['image'] ?>" alt="<?php echo "single-move-" . $s['id'] ?>" class="mr-4 rounded-circle" style="width:30px;">
                                                </span>
                                                <span style="font-weight:bold;"><a href="#"><?php echo $s['sub_name'] ?></a></span>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        } ?>

                    </div>
                </div>



                <!-- Tab1 Content Ends -->

                <div class="tab-pane fade" id="tab2">
                    <div class="row">
                        <?php if ($blue != null) {
                            if (count($blue) > 0) {
                                foreach ($blue as $b) {
                        ?>
                                    <div class="col-lg-4 nav-content">
                                        <div class="card" style="border:0px solid">
                                            <div class="card-body">
                                                <span>
                                                    <img src="<?php echo base_url() . $b['image'] ?>" alt="<?php echo "blue-collar-" . $b['id'] ?>" class="mr-4 rounded-circle" style="width:30px;">
                                                </span>
                                                <span style="font-weight:bold;"><a href="#"><?php echo $b['sub_name'] ?></a></span>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        } ?>

                    </div>
                </div>

                <div class="tab-pane fade" id="tab3">
                <div class="row">
                        <?php if ($multi != null) {
                            if (count($multi) > 0) {
                                foreach ($multi as $m) {
                        ?>
                                    <div class="col-lg-4 nav-content">
                                        <div class="card" style="border:0px solid">
                                            <div class="card-body">
                                                <span>
                                                    <img src="<?php echo base_url() . $m['image'] ?>" alt="<?php echo "multi-move-" . $m['id'] ?>" class="mr-4 rounded-circle" style="width:30px;">
                                                </span>
                                                <span style="font-weight:bold;"><a href="#"><?php echo $m['sub_name'] ?></a></span>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        } ?>

                    </div>
                </div>
                </div>
            </div>

        </div>
    </div>

    <?php $this->endSection() ?>