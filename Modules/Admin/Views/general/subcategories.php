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
                        <a class="navbar-brand" href="#pablo">Sub Categories</a>
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
                    <!-- My code starts-->
        
                    <div class="row">
                      <div class="col-md-12">
                        <div>
                          <a href="addSubCategory">
                            <button class="btn btn-primary" style="background-color:#8f6bf4">
                              <b> <i class="material-icons"><img src="../../assets/img/icons/add-white-24dp.svg" /></i> Add SubCategory
                              </b>
                            </button>
                          </a>
        
                        </div>
                        <div class="card">
                          <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                              <i class="material-icons"><img src="../../assets/img/list-white-24dp.svg" /></i>
                            </div>
                            <h4 class="card-title">Sub Categories</h4>
                          </div>
                          <div class="card-body">
                            <div class="toolbar">
                              <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="material-datatables">
                              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0"
                                width="100%" style="width:100%">
                                <thead>
                                  <tr>
                                    <th class="text-center">SubCatgory Id</th>
                                    <th>Category Name</th>
                                    <th>Sub Category Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <tr>
                                    <th class="text-center">SubCatgory Id</th>
                                    <th>Category Name</th>
                                    <th>Sub Category Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                  </tr>
                                </tfoot>
                                <tbody>
        
                                  <tr>
                                    <td class="text-center">1</td>
                                    <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <a href="editSubCategory">
									  <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
									  </a>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="text-center">2</td>
        
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="text-center">3</td>
        
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
        
                                  <tr>
                                    <td class="text-center">4</td>
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
        
                                  <tr>
                                    <td class="text-center">5</td>
        
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
        
        
        
                                  <tr>
                                    <td class="text-center">6</td>
        
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
        
        
        
                                  <tr>
                                    <td class="text-center">7</td>
        
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
        
        
                                  <tr>
                                    <td class="text-center">8</td>
        
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
        
        
                                  <tr>
                                    <td class="text-center">9</td>
        
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <a href="editSubCategory">
										  <button type="button" rel="tooltip" class="btn btn-success btn-round">
											<i class="material-icons">
											  <img src="../../assets/img/create-white-18dp (1).svg" />
											</i>
										  </button>
									  </a>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
        
        
                                  <tr>
                                    <td class="text-center">10</td>
        
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
        
        
                                  <tr>
                                    <td class="text-center">11</td>
        
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
        
        
                                  <tr>
                                    <td class="text-center">12</td>
        
                              <td>Single Move </td>
                                    <td> Blue Collor</td>
                                    <td><img src="../../assets/img/card-3.jpg" height="30px"/></td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" checked="">
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
                                      <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <!-- end content-->
                        </div>
                        <!--  end card  -->
                      </div>
                      <!-- end col-md-12 -->
                    </div>
        
                    <!-- My code ends-->
        
                  </div>
                </div>
              </div>
            
    <!--   Core JS Files   -->
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
    $(document).ready(function () {
      $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }
      });

      var table = $('#datatable').DataTable();

      // Edit record
      table.on('click', '.edit', function () {
        $tr = $(this).closest('tr');
        var data = table.row($tr).data();
        alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
      });

      // Delete a record
      table.on('click', '.remove', function (e) {
        $tr = $(this).closest('tr');
        table.row($tr).remove().draw();
        e.preventDefault();
      });

      //Like record
      table.on('click', '.like', function () {
        alert('You clicked on Like button');
      });
    });
  </script>

</body>




</html>