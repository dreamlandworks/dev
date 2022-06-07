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
                        <a class="navbar-brand" href="#pablo">Keywords</a>
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
                          <a href="addKeywords">
                            <button class="btn btn-primary" style="background-color:#8f6bf4">
                              <b> <i class="material-icons"><img src="../../assets/img/icons/add-white-24dp.svg" /></i> Add Keywords
                              </b>
                            </button>
                          </a>
        
                        </div>
                        <div class="card">
                          <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                              <i class="material-icons"><img src="../../assets/img/list-white-24dp.svg" /></i>
                            </div>
                            <h4 class="card-title">Keywords</h4>
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
                                      <th>S.No</th>
                                    <th>Keyword</th>
                                    <th>Profession</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <tr>
                                    <th>S.No</th>
                                    <th>Keyword</th>
                                    <th>Profession</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                  </tr>
                                </tfoot>
                                <tbody>
                                <?php   
                                    if($keywords != 'failure') {
                                    foreach($keywords as $key => $keyword){ ?>
                                  <tr>
                                    <td class="text-center"><?php echo ($key+1); ?></td>
                                    <td><?php echo $keyword['keyword']; ?> </td>
                                    <td><?php echo $keyword['name']; ?></td>
                                    <td>Admin</td>
                                    <td>
                                      <div class="togglebutton">
                                        <label>
                                          <input type="checkbox" class ="chkstatus" data-id="<?php echo $keyword['id']; ?>"  type="checkbox" <?php echo ($keyword['status'] == 'Active') ? 'checked' : ''; ?>>
                                          <span class="toggle"></span>
                                        </label>
                                      </div>
                                    </td>
                                    <td class="td-actions">
                                      <a href="<?php echo 'editKeywords/'.$keyword['id'];?>">
									  <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                        <i class="material-icons">
                                          <img src="../../assets/img/create-white-18dp (1).svg" />
                                        </i>
                                      </button>
									  </a>
                                      <button data-id="<?php echo $keyword['id']; ?>" type="button" rel="tooltip" class="btn btn-danger btn-round btndelete">
                                        <i class="material-icons">
                                          <img src="../../assets/img/close-white-18dp.svg" />
                                        </i>
                                      </button>
                                    </td>
                                  </tr>
                                  <?php } }?>
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
    $(document).ready(function() {  
   $('.chkstatus').on('change', function() {
       //alert("here")
     if(this.checked)
        {
            var status='Active';
        }else{
            var status='Inactive';
        }
      //alert($(this).data('id'))
      var keyword_id = $(this).data('id');
      $.ajax({
            type: "POST",
            url: '<?php echo "editKeywordStatus";?>',
            data: {keyword_id : keyword_id, status: status},
            success: function(data){
            console.log(data);
            },
            error: function(xhr, status, error){
            console.error(xhr);
            }
            });
    
   });
   
   $('.btndelete').on('click', function() {
       var keyword_id = $(this).data('id');
      $.ajax({
            type: "POST",
            url: '<?php echo "deleteKeyword";?>',
            data: {keyword_id : keyword_id },
            success: function(data){
            console.log(data);
            //$(this).closest('tr').remove();
            
            },
            error: function(xhr, status, error){
            console.error(xhr);
            }
            });
   });
    });
  </script>

</body>




</html>