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
                        <a class="navbar-brand" href="#pablo"> List Tickets</a>
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
                        <?php //print_r($arr_pending);?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <a href="#">
                                <div class="card card-stats">
                                    <div class="card-header card-header-warning card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons"><img
                                                    src="../../assets/img/icons/groups-white-24dp.svg" /></i>
                                        </div>
                                        <!-- <p class="card-category">Single Move</p> -->
                                        <h3 class="card-title">Pending - <?php echo $arr_pending[0]['Pending'];?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            Pending - <?php echo $arr_pending[0]['Pending'];?> 
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
    
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <a href="#">
                                <div class="card card-stats">
                                    <div class="card-header card-header-success card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons"><img
                                                    src="../../assets/img/icons/groups-white-24dp.svg" /></i>
                                        </div>
                                        <!-- <p class="card-category">Last Month Users</p> -->
                                        <h3 class="card-title">In Progress - <?php echo $arr_pending[0]['InProgress'];?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            In Progress - <?php echo $arr_pending[0]['InProgress'];?>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <a href="#">
                                <div class="card card-stats">
                                    <div class="card-header card-header-rose card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons"><img
                                                    src="../../assets/img/icons/person_add_alt_1-white-24dp.svg" /></i>
                                        </div>
                                        <!-- <p class="card-category">This Month Users </p> -->
                                        <h3 class="card-title"> Resolved - <?php echo $arr_pending[0]['Resolved'];?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            Resolved - <?php echo $arr_pending[0]['Resolved'];?>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                     
                        </div>
                        <div class="row" style="justify-content: center;">

                            <div class="col-md-2" style="justify-content: center;">
                                <button type="button" rel="tooltip" class="btn btn-info btn-round">
                                    Pending
                                </button>
                            </div>
                            <div class="col-md-2" style="justify-content: center;">
                                <button type="button" rel="tooltip" class="btn btn-warning btn-round">
                                    InProgress
                                </button>
                            </div>
                            <div class="col-md-2" style="justify-content: center;">
                                <button type="button" rel="tooltip" class="btn btn-teal btn-round">
                                    Resloved
                                </button>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <div>
                          <a href="createNewUser.html">
                            <button class="btn btn-primary" style="background-color:#8f6bf4">
                              <b> <i class="material-icons"><img src="../../assets/img/icons/add-white-24dp.svg" /></i> Add User
                              </b>
                            </button>
                          </a>
                        </div> -->
                                <div class="card">
                                    <div class="card-header card-header-rose card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons"><img
                                                    src="../../assets/img/list-white-24dp.svg" /></i>
                                        </div>
                                        <h4 class="card-title">List Tickets</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="toolbar">
                                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                                        </div>
                                        <div class="material-datatables">
                                            <table id="datatables"
                                                class="table table-striped table-no-bordered table-hover"
                                                cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <!--<th>Complaint Id</th>-->
                                                        <th>Booking ID</th>
                                                        <!--<th>Created By</th>-->
                                                        <th>Created On</th>
                                                        <th>Module</th>
                                                        <th>Description</th>
                                                        <th>Priority</th>
                                                        <th>Assigned to</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <!--<th>Complaint Id</th>-->
                                                        <th>Booking ID</th>
                                                        <!--<th>Created By</th>-->
                                                        <th>Created On</th>
                                                        <th>Module</th>
                                                        <th>Description</th>
                                                        <th>Priority</th>
                                                        <th>Assigned to</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                <?php
                                  if($arr_supports != 'failure') {
                                      foreach($arr_supports as $key => $supports) {
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo ($key+1); ?></td>
                                        <!--<td><?php echo  $supports['complaints_id']; ?> </td>-->
                                        <!--<td> <?php //echo $supports['fname'] . " " .$supports['lname']; ?></td>-->
                                        <td> 
                                        <?php echo $booking_ref_id = str_pad($supports['booking_id'], 6, "0", STR_PAD_LEFT);?></td>
                                        <td> <?php echo $supports['created_on']; ?></td>
                                        <td> <?php echo $supports['module_name']; ?></td>
                                        <td> <?php echo $supports['description']; ?></td>
                                        <td> <?php echo $supports['priority']; ?></td>
                                        <td> <?php echo $supports['staff_name']; ?></td>
                                        <td> <?php echo $supports['status']; ?></td>
                                    <!--    <td>-->
                                    <!--  <div class="togglebutton">-->
                                    <!--    <label>-->
                                    <!--      <input class ="chkstatus" data-id="<?php //echo $userplans['id']; ?>"  type="checkbox"  >-->
                                    <!--      <span class="toggle"></span>-->
                                    <!--    </label>-->
                                    <!--  </div>-->
                                    <!--</td>-->
                                    <td class="td-actions">
                                      <a href="<?php echo ADMINBASEURL;?>editTickets/<?php echo $supports['id'];?>">
									  <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
									  </a>
                                      <button type="button" rel="tooltip" data-id="<?php echo $supports['id']; ?>" class="btn btn-danger btn-round btndelete">
                                    <!--<button class="btn btn-danger" onclick="delete_book(<?php //echo $userplans['id']; ?>)">Delete</button>-->

                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                    </tr>
                                      <?php
                                      }
                                  }
                                  ?>
                        
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
            <!--footer section starts-->
            
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
    
    <script>
  $(document).ready(function(){
     $('.btndelete').on('click', function() {
       var compliant_id = $(this).data('id');
       
      $.ajax({
            type: "POST",
            url: '<?php echo "deleteTicket";?>',
            data: {compliant_id : compliant_id },
            success: function(data){
            console.log(data);
            //$(this).closest('tr').remove();
            location.reload();
            },
            error: function(xhr, status, error){
            console.error(xhr);
            }
            });
   
     });
    });

  </script>

