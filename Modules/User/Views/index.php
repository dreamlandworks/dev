<?php $this->extend('Modules\User\Views\home') ?>


<?php $this->section('title') ?>
Services at your Door Steps
<?php $this->endsection() ?>

<?php $this->section('styles') ?>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap" rel="stylesheet">

<!-- CSS Stylesheets -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/nice-select.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/custom.css" type="text/css">

<?php $this->endsection() ?>

<?php $this->section('menu') ?>

<li class="active"><a href="index.php">Home</a></li>
<li><a href="#">Listed Jobs</a></li>
<li><a href="categories">Categories</a></li>
<li><a href="#">Blog</a></li>

<?php $this->endsection() ?>

<?php $this->section('content') ?>

<div class="row">
        <div class="col-lg-8">
            <div class="section-title">
                <h2>Discover The Best Services Near You</h2>
                <h4>Morethan 250+ services to choose from</h4>
            </div>
            <div class="search-bar-home">
                <form class="form-inline" action="#">
                    <div class="search_bar">
                        <input type="text" class="form-control" placeholder="Try:- Washing Machine Repair, AC Repair etc.," id="search">
                    </div>
                    <select class="form-control category" id="category">
                        <option>Single Move Category</option>
                        <option>Blue Collar Category</option>
                        <option>Multi Move Category</option>
                    </select>
                    <button class="btn button-home">Search</button>

                </form>

            </div>
            <div class="d-flex p-3 text-muted d-flex justify-content-center">
                <div class="p-2 text-center">
                    <img id="cat" src="<?php echo base_url() ?>/public/assets/img/icon/house.png" />
                    <p>House Repairs</p>
                </div>
                <div class="p-2 text-center">
                    <img id="cat" src="<?php echo base_url() ?>/public/assets/img/icon/mobile.png" />
                    <p>App Development</p>
                </div>
                <div class="p-2 text-center">
                    <img id="cat" src="<?php echo base_url() ?>/public/assets/img/icon/bike.png" />
                    <p>Bike Repairs</p>
                </div>
                <div class="p-2 text-center">
                    <img id="cat" src="<?php echo base_url() ?>/public/assets/img/icon/food.png" />
                    <p>Food Deliveries</p>
                </div>

                <div class="p-2 text-center" style="border-right:0px solid;">
                    <img id="cat" src="<?php echo base_url() ?>/public/assets/img/icon/ac.png" />
                    <p>AC Repairs</p>
                </div>


            </div>


        </div>
        <div class="col-lg-4">
            <div class="bg_image">
                <img src="<?php echo base_url() ?>/public/assets/img/hero/bg_image.png" />
            </div>
        </div>

    </div>

<?php $this->endSection() ?>

<?php $this->section('script') ?>

<script src="<?php echo base_url(); ?>/public/assets/js/jquery.nice-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select').niceSelect();
        });
    </script>

<?php $this->endSection() ?>