<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Dashboard
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="../../assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../../assets/demo/demo.css" rel="stylesheet" />
</head>
<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 370px;
}
</style>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="rose" data-background-color="black">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo" style="text-align:center">
                <a href="#" class="simple-text logo-normal">
                    <img src="https://dev.satrango.com/public/assets/img/logo-black.png" height="50px" />
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <img src="../../assets/img/faces/avatar.jpg" />
                    </div>
                    <div class="user-info">
                        <a data-toggle="collapse" href="#collapseExample" class="username">
                            <span>
                                Admin
                                <b class="caret"></b>
                            </span>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">

                                <li class="nav-item">
                                    <a class="nav-link" href="editProfile.html">
                                        <span class="sidebar-mini"> P </span>
                                        <span class="sidebar-normal">Profile </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.html">
                            <i class="material-icons">
                                <img src="../../assets/img/icons/dashboard-white-18dp.svg" />
                            </i>
                            <p> Dashboard </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#userDashboard">
                            <i class="material-icons">
                                <img src="../../assets/img/icons/person_add_alt_1-white-24dp.svg" />
                            </i>
                            <p> User
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="userDashboard">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="createNewUser.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Create a New User </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="listUsers.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> List Users </span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#serviceProviders">
                            <i class="material-icons">
                                <img src="../../assets/img/icons/groups-white-24dp.svg" />
                            </i>
                            <p> Service Providers
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="serviceProviders">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="activateProvider.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Activate Provider </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="listServiceProviders.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> List Service Providers </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#accounts">
                            <i class="material-icons">
                                <img src="../../assets/img/icons/attach_money-white-24dp.svg" />
                            </i>
                            <p> Accounts
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="accounts">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="receipts.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Receipts </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="receiptsDue.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Receipts Due </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="paymentRequests.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Payment Requests </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="paymentDone.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Payments Done </span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#bookings">
                            <i class="material-icons">
                                <img src="../../assets/img/icons/credit_score-white-24dp.svg" />
                            </i>
                            <p> Bookings
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse show" id="bookings">
                            <ul class="nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="createNewBooking.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                             <span class="sidebar-normal"> Create New Booking </span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="listBooking.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> List Booking </span>
                                    </a>
                                </li>

                            

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#postJob">
                            <i class="material-icons">
                                <img src="../../assets/img/drive_file_move-white-24dp.svg" />
                            </i>
                            <p> Post Job
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="postJob">
                            <ul class="nav">
                             

                                <li class="nav-item ">
                                    <a class="nav-link" href="newJobs.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> New Jobs  </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="postJob.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Post a Job </span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#support">
                            <i class="material-icons">
                                <img src="../../assets/img/icons/support_agent_white_24dp.svg" />
                            </i>
                            <p> Support
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="support">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="createTickets.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Create Tickets </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="listAllTickets.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> List all Tickets </span>
                                    </a>
                                </li>
 

                            </ul>
                        </div>
                    </li>


                    <li class="nav-item ">
                        <a class="nav-link" data-toggle="collapse" href="#general">
                            <i class="material-icons">
                                <img src="../../assets/img/icons/info_white_24dp.svg" />
                            </i>
                            <p> General
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="general">
                            <ul class="nav">
                                <li class="nav-item ">
                                    <a class="nav-link" href="categories.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Categories </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="subcategories.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Sub Categories </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="keywords.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Keywords </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="languages.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Languages </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="professions.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal">Professions </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="qualifications.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Qualifications </span>
                                    </a>
                                </li>

                                  
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#blogs">
                            <i class="material-icons">
                                <img src="../../assets/img/icons/post_add_white_24dp.svg" />
                            </i>
                            <p> Blogs
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="blogs">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="receipts.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> View Posts </span>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="receiptsDue.html">
                                        <span class="sidebar-mini"> <i class="material-icons">
                                                <img src="../../assets/img/icons/add-white-24dp.svg" />
                                            </i> </span>
                                        <span class="sidebar-normal"> Create New Post </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#chargesPacks"> <i class="material-icons">
                                <img src="../../assets/img/icons/backpack_white_24dp.svg" />
                            </i>
                            <p> Charges & Packs
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="chargesPacks">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="cancellationCharges.html">
                                        <span class="sidebar-mini"> <i class="material-icons"><img
                                                    src="../../assets/img/icons/add-white-24dp.svg" /></i> </span>
                                        <span class="sidebar-normal"> Cancellation Charges</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="userPlans.html">
                                        <span class="sidebar-mini"> <i class="material-icons"><img
                                                    src="../../assets/img/icons/add-white-24dp.svg" /></i> </span>
                                        <span class="sidebar-normal">User Plans </span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="providerPlans.html">
                                        <span class="sidebar-mini"> <i class="material-icons"><img
                                                    src="../../assets/img/icons/add-white-24dp.svg" /></i> </span>
                                        <span class="sidebar-normal">Provider Plans </span>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#settings"> <i class="material-icons">
                                <img src="../../assets/img/icons/settings_suggest-white-24dp.svg" />
                            </i>
                            <p> Settings
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="settings">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.html">
                                        <span class="sidebar-mini"> <i class="material-icons"><img
                                                    src="../../assets/img/icons/add-white-24dp.svg" /></i> </span>
                                        <span class="sidebar-normal">Logout</span>
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
                                <i class="material-icons text_align-center visible-on-sidebar-regular">
                                    <img src="../../assets/img/icons/more_vert-black-24dp.svg">
                                </i>
                                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">
                                    <img src="../../assets/img/icons/view_list-black-24dp.svg" />
                                </i>
                            </button>
                        </div>
                        <a class="navbar-brand" href="#pablo">Create New Booking</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">

                        <ul class="navbar-nav">

                            <li class="nav-item dropdown">
                                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">
                                        <img src="../../assets/img/icons/notifications_active-black-24dp.svg" />
                                    </i>
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
                                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">
                                        <img src="../../assets/img/icons/person-black-24dp.svg" />
                                    </i>
                                    <p class="d-lg-none d-md-block">
                                        Account
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                    <a class="dropdown-item" href="#">Profile</a>
                                    <a class="dropdown-item" href="settings.html">Settings</a>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" data-toggle="modal" data-target="#myModal10">
                                        Log out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


            <!-- End Navbar -->
                 <div class="content">
                <div class="content">
                    <div class="container-fluid">
                        <!-- small modal -->
                        <div class="modal fade modal-mini modal-primary" id="myModal10" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-small">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                                class="material-icons">
                                                <img src="../assets/img/icons/clear-black-18dp.svg" />
                                            </i></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to LOGOUT?</p>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-link" data-dismiss="modal">Back</button>
                                        <a href="../examples/pages/login.html">

                                            <button type="button" class="btn btn-success btn-link">
                                                Yes
                                                <div class="ripple-container"></div>
                                            </button>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--    end small modal -->

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
                                        <h4 class="card-title">New Booking</h4>
                                    </div>
                                    <div class="card-body ">
                                        <form method="#" action="#">
                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="exampleName" class="bmd-label-floating">
                                                            Date Time </label>
                                                        <input type="text" class="form-control" id="name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleName" class="bmd-label-floating">Work Description
                                                        </label>
                                                        <input type="text" class="form-control" id="name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleDesignation"
                                                            class="bmd-label-floating">Flat no, locality, street name</label>
                                                        <input type="text" class="form-control" id="designation">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="examplePass" class="bmd-label-floating">zip code
                                                            <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="examplePass">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="examplePass" class="bmd-label-floating"> City
                                                            <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="examplePass">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="examplePass" class="bmd-label-floating">State
                                                            <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="examplePass">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="examplePass" class="bmd-label-floating">Country
                                                            <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="examplePass">
                                                    </div>

                                                </div>
                                                <div class="col-lg-5 col-md-6 col-sm-12" style="margin:0.4rem 2rem">
                                    
                                                    <div class="form-group">
                                                        <label for="exampleName" class="bmd-label-floating">User Id
                                                        </label>
                                                        <input type="text" class="form-control" id="name">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer ">
                                        <button type="submit" class="btn btn-fill btn-teal">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MyCode ends here-->

                    </div>
                </div>
            </div>
            <!--footer section starts-->
            <footer class="footer">
                <div style="width:99%;"> 
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="footerimg">
                                <img src="../../assets/img/footerimg.png" alt="footerimg" class="img-fluid" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="copyright">
                                &copy;
                                <a href="https://www.satrango.com/" target="_blank">www.satrango.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!--footer section ends-->
        </div>
    </div>

    <div></div>
    </div>
    <!--   Core JS Files   -->
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../../assets/js/core/jquery.min.js"></script>
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="../../assets/js/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="../../assets/js/plugins/sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="../../assets/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="../../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="../../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="../../assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="../../assets/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="../../assets/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="../../assets/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="../../assets/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="../../assets/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="../../assets/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="../../assets/js/plugins/arrive.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chartist JS -->
    <script src="../../assets/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../../assets/js/material-dashboard.js?v=2.1.0" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="../../assets/demo/demo.js"></script>
    <script>
        $(document).ready(function () {
            $().ready(function () {
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

                $('.fixed-plugin a').click(function (event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $('.fixed-plugin .active-color span').click(function () {
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

                $('.fixed-plugin .background-color .badge').click(function () {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('background-color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                    }
                });

                $('.fixed-plugin .img-holder').click(function () {
                    $full_page_background = $('.full-page-background');

                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');


                    var new_image = $(this).find("img").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function () {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function () {
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

                $('.switch-sidebar-image input').change(function () {
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

                $('.switch-sidebar-mini input').change(function () {
                    $body = $('body');

                    $input = $(this);

                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                    } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function () {
                            $('body').addClass('sidebar-mini');

                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function () {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function () {
                        clearInterval(simulateWindowResize);
                    }, 1000);

                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
            demo.initCharts();
        });
    </script>

    <script>

        var ctxHor = document.getElementById('myHorizontal').getContext('2d');


        var myHorizontal = new Chart(ctxHor, {
            // The type of chart we want to create
            type: 'horizontalBar',

            // The data for our dataset
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Topper Performace',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [0, 10, 5, 2, 20, 30, 45],
                    fill: false
                }, {
                    label: 'Your Performance',
                    backgroundColor: 'rgba(75, 192, 192)',
                    borderColor: 'rgba(75, 192, 192)',
                    data: [0, 30, 15, 20, 0, 10, 40],
                    fill: false
                },
                ]
            },

            options: {

            }
        });
    </script>
        <script>

            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
    
        </script>

</body>




</html>