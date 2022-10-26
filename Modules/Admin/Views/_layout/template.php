<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>/assets/img/favicon.jpeg">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        <?php $this->renderSection('title'); ?>
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="<?php echo base_url(); ?>/assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />

    <?php $this->renderSection('styles'); ?>

</head>

<body class="">
    <div class="overlay noneGroup">
        <div class="overlay__inner">
            <div class="overlay__content"><span class="spinner"></span></div>
        </div>
    </div>
    <div class="wrapper ">
        <div class="sidebar" data-color="rose" data-background-color="black" data-image="<?php echo base_url(); ?>/assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo"><a href="#" class="simple-text logo-mini">
                    S
                </a>
                <a href="dashboard" class="simple-text logo-normal">
                    SQUILL
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <img src="<?php echo base_url(); ?>/assets/img/faces/avatar.jpg" />
                    </div>
                    <div class="user-info">
                        <a data-toggle="collapse" href="#collapseExample" class="username">
                            <span>
                                Phaneendra Kumar P
                                <b class="caret"></b>
                            </span>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <span class="sidebar-mini"> MP </span>
                                        <span class="sidebar-normal"> My Profile </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <span class="sidebar-mini"> EP </span>
                                        <span class="sidebar-normal"> Edit Profile </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <span class="sidebar-mini"> S </span>
                                        <span class="sidebar-normal"> Settings </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav">

                    <!-- Dashboard Side Menu Nav   -->
                    <li class="nav-item active ">
                        <a class="nav-link" href="dashboard">
                            <i class="material-icons">dashboard</i>
                            <p> Dashboard </p>
                        </a>
                    </li>

                    <!-- Users Side Menu Nav  -->
                    <li class="nav-item ">
                        <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
                            <i class="material-icons">person</i>
                            <p> Users
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="pagesExamples">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="/ct/createNewUser">
                                        <span class="sidebar-mini"> <i class="material-icons">add</i> </span>
                                        <span class="sidebar-normal"> New User </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/ct/listUsers">
                                        <span class="sidebar-mini"> <i class="material-icons">list</i> </span>
                                        <span class="sidebar-normal"> List Users </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Service Provider Menu Nav  -->
                    <li class="nav-item ">
                        <a class="nav-link" data-toggle="collapse" href="#providers">
                            <i class="material-icons">people</i>
                            <p> Providers
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="providers">
                            <ul class="nav">
                                <li class="nav-item ">
                                    <a class="nav-link" href="/ct/activateProvider">
                                        <span class="sidebar-mini"> <i class="material-icons">done</i> </span>
                                        <span class="sidebar-normal"> Approve </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/ct/list_providers">
                                        <span class="sidebar-mini"> <i class="material-icons">list</i> </span>
                                        <span class="sidebar-normal"> List Providers </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Accounts Menu Nav  -->
                    <li class="nav-item ">
                        <a class="nav-link" data-toggle="collapse" href="#accounts">
                            <i class="material-icons">currency_rupee</i>
                            <p> Accounts
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="accounts">
                            <ul class="nav">
                                <li class="nav-item ">
                                    <a class="nav-link" href="receipts">
                                        <span class="sidebar-mini"> <i class="material-icons">receipt</i> </span>
                                        <span class="sidebar-normal"> Receipts </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="receiptsDue">
                                        <span class="sidebar-mini"> <i class="material-icons">receipt</i> </span>
                                        <span class="sidebar-normal"> Receipts Due</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="paymentRequests">
                                        <span class="sidebar-mini"> <i class="material-icons">payments</i> </span>
                                        <span class="sidebar-normal"> Payments </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="paymentDone">
                                        <span class="sidebar-mini"> <i class="material-icons">request_quote</i> </span>
                                        <span class="sidebar-normal"> Pending Payments </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Bookings Menu Nav  -->
                    <li class="nav-item ">
                        <a class="nav-link" data-toggle="collapse" href="#bookings">
                            <i class="material-icons">event_note</i>
                            <p> Bookings
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="bookings">
                            <ul class="nav">
                                <li class="nav-item ">
                                    <a class="nav-link" href="createNewBooking">
                                        <span class="sidebar-mini"> <i class="material-icons">add</i> </span>
                                        <span class="sidebar-normal"> New Booking </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="listBooking">
                                        <span class="sidebar-mini"> <i class="material-icons">list</i> </span>
                                        <span class="sidebar-normal"> List Bookings </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="booking_inprogress">
                                        <span class="sidebar-mini"> <i class="material-icons">watch_later</i> </span>
                                        <span class="sidebar-normal"> Bookings Delayed </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Post Job Menu Nav  -->
                    <li class="nav-item ">
                        <a class="nav-link" data-toggle="collapse" href="#postjob">
                            <i class="material-icons">work</i>
                            <p> Post Job
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="postjob">
                            <ul class="nav">
                                <li class="nav-item ">
                                    <a class="nav-link" href="newJobs">
                                        <span class="sidebar-mini"> <i class="material-icons">add</i> </span>
                                        <span class="sidebar-normal"> New Job </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="viewNewjobs">
                                        <span class="sidebar-mini"> <i class="material-icons">list</i> </span>
                                        <span class="sidebar-normal"> List Jobs </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Plans & Charges Job Menu Nav  -->
                    <li class="nav-item ">
                        <a class="nav-link" data-toggle="collapse" href="#plans">
                            <i class="material-icons">payment</i>
                            <p> Charges & Plans
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="plans">
                            <ul class="nav">
                                <li class="nav-item ">
                                    <a class="nav-link" href="cancellationCharges">
                                        <span class="sidebar-mini"> <i class="material-icons">list</i> </span>
                                        <span class="sidebar-normal"> Cancellation Charges </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="userPlans">
                                        <span class="sidebar-mini"> <i class="material-icons">format_list_bulleted</i> </span>
                                        <span class="sidebar-normal"> User Plans </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="providerPlans">
                                        <span class="sidebar-mini"> <i class="material-icons">format_list_numbered</i> </span>
                                        <span class="sidebar-normal"> Provider Plans </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Support Menu Nav  -->
                    <li class="nav-item ">
                        <a class="nav-link" data-toggle="collapse" href="#support">
                            <i class="material-icons">support_agent</i>
                            <p> Support
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="support">
                            <ul class="nav">
                                <li class="nav-item ">
                                    <a class="nav-link" href="createTickets">
                                        <span class="sidebar-mini"> <i class="material-icons">add</i> </span>
                                        <span class="sidebar-normal"> New Ticket </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="listAllTickets">
                                        <span class="sidebar-mini"> <i class="material-icons">list</i> </span>
                                        <span class="sidebar-normal"> List Tickets </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- General Menu Nav  -->
                    <li class="nav-item ">
                        <a class="nav-link" data-toggle="collapse" href="#general">
                            <i class="material-icons">info</i>
                            <p> General
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="general">
                            <ul class="nav">
                                <li class="nav-item ">
                                    <a class="nav-link" href="categories">
                                        <span class="sidebar-mini"> <i class="material-icons">category</i> </span>
                                        <span class="sidebar-normal"> Categories </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="subcategories">
                                        <span class="sidebar-mini"> <i class="material-icons">subject</i> </span>
                                        <span class="sidebar-normal"> Sub Catgegories </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="keywords">
                                        <span class="sidebar-mini"> <i class="material-icons">key</i> </span>
                                        <span class="sidebar-normal"> Keywords </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="languages">
                                        <span class="sidebar-mini"> <i class="material-icons">translate</i> </span>
                                        <span class="sidebar-normal"> Languages </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="professions">
                                        <span class="sidebar-mini"> <i class="material-icons">work</i> </span>
                                        <span class="sidebar-normal"> professions </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="qualifications">
                                        <span class="sidebar-mini"> <i class="material-icons">school</i> </span>
                                        <span class="sidebar-normal"> Qualifications </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Settings Menu Nav  -->
                    <li class="nav-item ">
                        <a class="nav-link" data-toggle="collapse" href="#settings">
                            <i class="material-icons">settings</i>
                            <p> Settings
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="settings">
                            <ul class="nav">
                                <li class="nav-item ">
                                    <a class="nav-link" href="#">
                                        <span class="sidebar-mini"> <i class="material-icons">logout</i> </span>
                                        <span class="sidebar-normal"> Logout </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-minimize">
                            <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                            </button>
                        </div>
                        <a class="navbar-brand" href="javascript:;"><?php $this->renderSection('nav_title'); ?></a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <form class="navbar-form">
                            <div class="input-group no-border">
                                <input type="text" value="" class="form-control" placeholder="Search...">
                                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                    <i class="material-icons">search</i>
                                    <div class="ripple-container"></div>
                                </button>
                            </div>
                        </form>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:;">
                                    <i class="material-icons">dashboard</i>
                                    <p class="d-lg-none d-md-block">
                                        Stats
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">5</span>
                                    <p class="d-lg-none d-md-block">
                                        Some Actions
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">Mike John responded to your email</a>
                                    <a class="dropdown-item" href="#">You have 5 new tasks</a>
                                    <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                                    <a class="dropdown-item" href="#">Another Notification</a>
                                    <a class="dropdown-item" href="#">Another One</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">person</i>
                                    <p class="d-lg-none d-md-block">
                                        Account
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                    <a class="dropdown-item" href="#">Profile</a>
                                    <a class="dropdown-item" href="#">Settings</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Log out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->

            <!-- Content Starts Here -->
            <div class="content">
                <div class="content">
                    <div class="container-fluid">
                        <?php $this->renderSection('body'); ?>
                    </div>
                </div>
            </div>
            <!-- Content Ends Here -->

            <!-- Footer start -->
            <footer class="footer">
                <!-- <div class="container-fluid">
                    <nav class="float-left">
                        <ul>
                            <li>
                                <a href="https://www.creative-tim.com/">
                                    Creative Tim
                                </a>
                            </li>
                            <li>
                                <a href="https://www.creative-tim.com/presentation">
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="https://www.creative-tim.com/blog">
                                    Blog
                                </a>
                            </li>
                            <li>
                                <a href="https://www.creative-tim.com/license">
                                    Licenses
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright float-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>, made with <i class="material-icons">favorite</i> by
                        <a href="https://www.creative-tim.com/" target="_blank">Creative Tim</a> for a better web.
                    </div>
                </div> -->
            </footer>
        </div>
    </div>
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title"> Sidebar Filters</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger active-color">
                        <div class="badge-colors ml-auto mr-auto">
                            <span class="badge filter badge-purple" data-color="purple"></span>
                            <span class="badge filter badge-azure" data-color="azure"></span>
                            <span class="badge filter badge-green" data-color="green"></span>
                            <span class="badge filter badge-warning" data-color="orange"></span>
                            <span class="badge filter badge-danger" data-color="danger"></span>
                            <span class="badge filter badge-rose active" data-color="rose"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="header-title">Sidebar Background</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                        <div class="ml-auto mr-auto">
                            <span class="badge filter badge-black active" data-background-color="black"></span>
                            <span class="badge filter badge-white" data-background-color="white"></span>
                            <span class="badge filter badge-red" data-background-color="red"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>Sidebar Mini</p>
                        <label class="ml-auto">
                            <div class="togglebutton switch-sidebar-mini">
                                <label>
                                    <input type="checkbox">
                                    <span class="toggle"></span>
                                </label>
                            </div>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>Sidebar Images</p>
                        <label class="switch-mini ml-auto">
                            <div class="togglebutton switch-sidebar-image">
                                <label>
                                    <input type="checkbox" checked="">
                                    <span class="toggle"></span>
                                </label>
                            </div>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="header-title">Images</li>
                <li class="active">
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="<?php echo base_url(); ?>/assets/img/sidebar-1.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="<?php echo base_url(); ?>/assets/img/sidebar-2.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="<?php echo base_url(); ?>/assets/img/sidebar-3.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="<?php echo base_url(); ?>/assets/img/sidebar-4.jpg" alt="">
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="<?php echo base_url(); ?>/assets/js/core/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/arrive.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chartist JS -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php echo base_url(); ?>/assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?php echo base_url(); ?>/assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <!-- <script src="<?php echo base_url(); ?>/assets/demo/demo.js"></script> -->
    <?php $this->renderSection('script'); ?>
    <script>
        $(document).ready(function() {
            $().ready(function() {
                $sidebar = $('.sidebar');

                $sidebar_img_container = $sidebar.find('.sidebar-background');

                $full_page = $('.full-page');

                $sidebar_responsive = $('body > .navbar-collapse');

                window_width = $(window).width();

                fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                    if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                        $('.fixed-plugin .dropdown').addClass('open');
                    }

                }

                $('.fixed-plugin a').click(function(event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $('.fixed-plugin .active-color span').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-color', new_color);
                    }

                    if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data-color', new_color);
                    }
                });

                $('.fixed-plugin .background-color .badge').click(function() {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('background-color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                    }
                });

                $('.fixed-plugin .img-holder').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');


                    var new_image = $(this).find("img").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function() {
                            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                            $full_page_background.fadeIn('fast');
                        });
                    }

                    if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                    }
                });

                $('.switch-sidebar-image input').change(function() {
                    $full_page_background = $('.full-page-background');

                    $input = $(this);

                    if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar_img_container.fadeIn('fast');
                            $sidebar.attr('data-image', '#');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page_background.fadeIn('fast');
                            $full_page.attr('data-image', '#');
                        }

                        background_image = true;
                    } else {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar.removeAttr('data-image');
                            $sidebar_img_container.fadeOut('fast');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page.removeAttr('data-image', '#');
                            $full_page_background.fadeOut('fast');
                        }

                        background_image = false;
                    }
                });

                $('.switch-sidebar-mini input').change(function() {
                    $body = $('body');

                    $input = $(this);

                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                    } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function() {
                            $('body').addClass('sidebar-mini');

                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function() {
                        clearInterval(simulateWindowResize);
                    }, 1000);

                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            md.initDashboardPageCharts();

            md.initVectorMap();

        });
    </script>

</body>

</html>