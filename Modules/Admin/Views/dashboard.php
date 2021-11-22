<body class="">
    <div class="wrapper">
       
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-minimize">
                            <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                                <i class="material-icons">
                                    <img src="../../assets/img/icons/more_vert-black-24dp.svg">
                                </i>
                                <!-- <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">
                                    <img src="../../assets/img/icons/view_list-black-24dp.svg" />
                                </i> -->
                            </button>
                        </div>
                        <a class="navbar-brand" href="#pablo">Dashboard</a>
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
                                        <img src="../../assets/img/faces/avatar.jpg" height="40px"
                                            style="border-radius: 30px;" />
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
                <div class="container-fluid">
                    <!-- small modal -->
                    <div class="modal fade modal-mini modal-primary" id="myModal10" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-small">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                            class="material-icons">
                                            <img src="../../assets/img/icons/clear-black-18dp.svg" />
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
                    <!-- Chat modal -->
                    <!-- notice modal -->
                    <div class="modal fade" id="myModalMessage" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-notice">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Contact us through <strong>CHAT</strong>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        <i class="material-icons">close</i>
                                    </button>
                                </div>
                                <br />
                                <div class="modal-body">
                                    <div class="instruction">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div>
                                                    <div class="form-group">
                                                        <label for="exampleFName" class="bmd-label-floating">Enter Your
                                                            Message </label>
                                                        <input type="text" class="form-control" id="fname"
                                                            list="Messages" autocomplete="off">
                                                        <datalist id="Messages">
                                                            <option>I ll call you later </option>
                                                            <option>We will get back to you</option>
                                                            <option>Thank you for your Update</option>
                                                            <option>Currently Unavailable</option>
                                                        </datalist>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row" style="justify-content: center;">
                                            <div class="col-md-8">
                                                <small>If you have more questions, We're here to help!</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-teal btn-round"
                                            data-dismiss="modal">Send..!!</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end notice modal -->
                    <!--    end Chat modal -->
                    <!-- Email modal -->
                    <div class="modal fade" id="myModalEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-notice">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Contact us through
                                        <strong>Message</strong>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        <i class="material-icons">close</i>
                                    </button>
                                </div>
                                <br />
                                <div class="modal-body">
                                    <div class="instruction">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <div class="form-group">
                                                        <label for="exampleFName" class="bmd-label-floating">Enter Your
                                                            Message </label>
                                                        <input type="text" class="form-control" id="fname"
                                                            list="Messages" autocomplete="off">
                                                        <datalist id="Messages">
                                                            <option>I ll call you later </option>
                                                            <option>We will get back to you</option>
                                                            <option>Thank you for your Update</option>
                                                            <option>Currently Unavailable</option>
                                                        </datalist>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row" style="justify-content: center;">
                                            <div class="col-md-8">
                                                <small>If you have more questions, We're here to help!</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-teal btn-round"
                                            data-dismiss="modal">Send..!!</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--    end Email modal -->
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h3 class="font-weight-bold">Welcome Admin</h3>
                                    <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span
                                            class="text-primary">3 unread alerts!</span></h6>
                                </div>
                                <div class="col-12 col-xl-4">
                                    <div class="justify-content-end d-flex">
                                        <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                            <button class="btn btn-sm btn-light bg-white dropdown-toggle"
                                                style="color: black;" type="button" id="dropdownMenuDate2"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenuDate2">
                                                <a class="dropdown-item" href="#">January - March</a>
                                                <a class="dropdown-item" href="#">March - June</a>
                                                <a class="dropdown-item" href="#">June - August</a>
                                                <a class="dropdown-item" href="#">August - November</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card tale-bg">
                                <div class="card-people mt-auto">
                                    <img src="https://bootstrapdash.com/demo/skydash-free/template/images/dashboard/people.svg"
                                        alt="people">
                                    <!-- <div class="weather-info">
                                <div class="d-flex">
                                  <div>
                                    <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                                  </div>
                                  <div class="ml-2">
                                    <h4 class="location font-weight-normal">Chicago</h4>
                                    <h6 class="font-weight-normal">Illinois</h6>
                                  </div>
                                </div>
                              </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin transparent">
                            <div class="row">
                                <div class="col-md-6 stretch-card transparent">
                                    <div class="card card-tale">
                                        <div class="card-body">
                                            <p class="mb-4">Today’s Bookings</p>
                                            <p class="fs-30 mb-2">4006</p>
                                            <p>10.00% (30 days)</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 stretch-card transparent">
                                    <div class="card card-dark-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Total Bookings</p>
                                            <p class="fs-30 mb-2">61344</p>
                                            <p>22.00% (30 days)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                                    <div class="card card-light-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Number of Meetings</p>
                                            <p class="fs-30 mb-2">34040</p>
                                            <p>2.00% (30 days)</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 stretch-card transparent">
                                    <div class="card card-light-danger">
                                        <div class="card-body">
                                            <p class="mb-4">Number of Service Providers</p>
                                            <p class="fs-30 mb-2">47033</p>
                                            <p>0.22% (30 days)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-tabs card-header-info">
                                    <div class="nav-tabs-navigation">
                                        <div class="nav-tabs-wrapper">
                                            <span class="nav-tabs-title"></span>
                                            <ul class="nav nav-tabs" data-tabs="tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#userss" data-toggle="tab">
                                                        <i class="material-icons">groups</i> Users
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#providers" data-toggle="tab">
                                                        <i class="material-icons">person_add</i> Service Providers
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>
                                                <!-- <li class="nav-item">
                                      <a class="nav-link" href="#settings" data-toggle="tab">
                                        <i class="material-icons">cloud</i> Server
                                        <div class="ripple-container"></div>
                                      </a>
                                    </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="userss">
                                            <div class="card-body table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-teal">
                                                        <tr>
                                                            <th> <b>Total Users</b></th>
                                                            <th><b>1089</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Today Users</td>
                                                            <td> 400</td>
                                                        </tr>
                                                        <tr>
                                                            <td>This Month Users</td>
                                                            <td>200</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Last Month Users</td>
                                                            <td>200</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="providers">
                                            <div class="card-body table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="text-teal">
                                                        <tr>
                                                            <th> <b>Total Service Providers</b></th>
                                                            <th><b>1209</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Today Service Providers</td>
                                                            <td> 340</td>
                                                        </tr>
                                                        <tr>
                                                            <td>This Month Service Providers</td>
                                                            <td>240</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Last Month Service Providers</td>
                                                            <td>239</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-warning">
                                    <h4 class="card-title">Notifications</h4>
                                    <a ref="#">
                                        <p class="card-category">View All</p>
                                    </a>
                                </div>
                                <ul class="icon-data-list">
                                    <li style="margin:2rem 2rem;">
                                        <div class="d-flex">
                                            <img src="../../assets/img/faces/avatar.jpg" alt="user"
                                                style="border-radius: 30px; margin:0rem 1rem;" height="40px">
                                            <div>
                                                <p class="text-info mb-1">Isabella Becker</p>
                                                <p class="mb-0">Sales dashboard have been created</p>
                                                <small>9:30 am</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li style="margin:2rem 2rem;">
                                        <div class="d-flex">
                                            <img src="../../assets/img/faces/avatar.jpg" alt="user"
                                                style="border-radius: 30px; margin:0rem 1rem;" height="40px">
                                            <div>
                                                <p class="text-info mb-1">Adam Warren</p>
                                                <p class="mb-0">You have done a great job #TW111</p>
                                                <small>10:30 am</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li style="margin:2rem 2rem;">
                                        <div class="d-flex">
                                            <img src="../../assets/img/faces/avatar.jpg" alt="user"
                                                style="border-radius: 30px; margin:0rem 1rem;" height="40px">
                                            <div>
                                                <p class="text-info mb-1">Leonard Thornton</p>
                                                <p class="mb-0">Sales dashboard have been created</p>
                                                <small>11:30 am</small>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-header card-header-tabs card-header-primary">
                                <div class="nav-tabs-navigation">
                                    <div class="nav-tabs-wrapper">
                                        <span class="nav-tabs-title"></span>
                                        <ul class="nav nav-tabs" data-tabs="tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#singleMove" data-toggle="tab">
                                                    <i class="material-icons">construction</i> Single Move Bookings
                                                    <div class="ripple-container"></div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#multiMove" data-toggle="tab">
                                                    <i class="material-icons"><span class="material-icons-outlined">
                                                        local_shipping
                                                        </span></i> Multi Move Bookings
                                                    <div class="ripple-container"></div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#blueCollor" data-toggle="tab">
                                                    <i class="material-icons">laptop_mac</i> Blue Collor Bookings
                                                    <div class="ripple-container"></div>
                                                </a>
                                            </li>
         
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="singleMove">
                                        <div class="card-body table-responsive">
                                            <table class="table table-hover">
                                                <thead class="text-teal">
                                                    <tr>
                                                        <th><b>Total SingleMove Bookings</b></th>
                                                        <th><b>1089</b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Today SingleMove Bookings</td>
                                                        <td> 400</td>
                                                    </tr>
                                                    <tr>
                                                        <td>This Month SingleMove Bookings</td>
                                                        <td>200</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last Month SingleMove Bookings</td>
                                                        <td>200</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="multiMove">
                                        <div class="card-body table-responsive">
                                            <table class="table table-hover">
                                                <thead class="text-teal">
                                                    <tr>
                                                        <th>  <b>Total MultiMove Bookings</b></th>
                                                        <th><b>1209</b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Today MultiMove Bookings</td>
                                                        <td> 340</td>
                                                    </tr>
                                                    <tr>
                                                        <td>This Month MultiMove Bookings</td>
                                                        <td>240</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last Month MultiMove Bookings</td>
                                                        <td>239</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="blueCollor">
                                        <div class="card-body table-responsive">
                                            <table class="table table-hover">
                                                <thead class="text-teal">
                                                    <tr> 
                                                        <th> <b>Total BlurCollor Bookings</b></th>
                                                        <th><b>1209</b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Today BlurCollor Bookings</td>
                                                        <td> 340</td>
                                                    </tr>
                                                    <tr>
                                                        <td>This Month BlurCollor Bookings</td>
                                                        <td>240</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last Month BlurCollor Bookings</td>
                                                        <td>239</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-info">
                                    <h4 class="card-title">Revenue</h4>
                                    <a ref="#">
                                        <p class="card-category">Last Year Vs This Year</p>
                                    </a>
                                </div>
                                <div class="col-md-10" style="margin:1rem;">
                                    <canvas id="myChartline"> </canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">Revenue</h4>
                                    <a ref="#">
                                        <p class="card-category">Last Month Vs This Month</p>
                                    </a>
                                </div>
                                <div class="col-md-12" style="margin:1rem;">
                                  <div style="margin:1rem 0rem;"> <b>The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</b></div>
                                    <canvas id="myChart1"> </canvas>
                                </div>
                            </div>
                        </div>
                    
                    </div>

                    <div class="row">

                        <div class="col-lg-4 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">Payments</h4>
                                    <a ref="#">
                                        <p class="card-category">Last Month Vs This Month</p>
                                    </a>
                                </div>
                                <div class="col-md-12" style="margin:1rem;">
                                  <div style="margin:1rem 0rem;"> <b>The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</b></div>
                                    <canvas id="myChartPay1" style="margin:2rem 0rem"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-info">
                                    <h4 class="card-title">Payments</h4>
                                    <a ref="#">
                                        <p class="card-category">Last Year Vs This Year</p>
                                    </a>
                                </div>
                                <div class="col-md-10" style="margin:1rem;">
                                    <canvas id="myChartlinePay"> </canvas>
                                </div>
                            </div>
                        </div>
                       
                    
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
