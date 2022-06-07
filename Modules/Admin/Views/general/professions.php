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
                        <a class="navbar-brand" href="#pablo">Professions</a>
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
                        <!-- small modal -->
                        <div class="modal fade modal-mini modal-primary" id="myModal11" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-small">
                                <div class="modal-content">
                                    <form method="POST" id="addprofessionDetails" role="form" action="<?php echo ADMINBASEURL; ?>create_profession_submit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                                class="material-icons">
                                                <img src="../../assets/img/icons/clear-black-18dp.svg" />
                                            </i></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4 style="text-align: center;
                               font-size: x-large;">Add Profession</h4>
                                        <br />
                                        <div class="form-group">
                                            <label for="exampleName" class="bmd-label-floating">Profession
                                            </label>
                                            <input type="text" class="form-control" name="profession_name" id="profession_name">
                                        </div>
                                        <select name="category_id" id="category_id" class="selectpicker" data-style="select-with-transition"
                                        title="Select Category" data-size="7">
                                        <?php foreach($categories as $category){ ?>
                                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
                                                        <?php } ?>
                                        
                                    </select>
                                    <select name="subcategory_id" id="subcategory_id" class="selectpicker" data-style="select-with-transition"
                                    title="Select SubCategory" data-size="7">
                                    <?php foreach($subcategories as $subcategory){ ?>
                                                        <option data-categoryid="<?php echo $subcategory['category_id']; ?>" value="<?php echo $subcategory['id']; ?>"><?php echo $subcategory['sub_name']; ?></option>
                                                        <?php } ?>
                                </select>
                                    </div>
                                    <div class="modal-footer justify-content-center">


                                        <button type="submit" class="btn btn-fill btn-teal"
                                           >Submit</button>


                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--    end small modal -->
                        
                        <!-- small modal -->
                        <div class="modal fade modal-mini modal-primary" id="myModal12" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-small">
                                <div class="modal-content">
                                    <form method="POST" id="editprofessionDetails" role="form" action="<?php echo ADMINBASEURL; ?>edit_profession_submit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                                class="material-icons">
                                                <img src="../../assets/img/icons/clear-black-18dp.svg" />
                                            </i></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4 style="text-align: center;
                               font-size: x-large;">Edit Profession</h4>
                                        <br />
                                        <input type="hidden" class="form-control" name="editprofession_id" id="editprofession_id">
                                        <div class="form-group">
                                            <label for="exampleName" class="bmd-label-floating">Profession
                                            </label>
                                            <input type="text" class="form-control" name="editprofession_name" id="editprofession_name">
                                        </div>
                                        <select name="editcategory_id" id="editcategory_id" class="selectpicker" data-style="select-with-transition"
                                        title="Select Category" data-size="7">
                                        <?php foreach($categories as $category){ ?>
                                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
                                                        <?php } ?>
                                        
                                    </select>
                                    <select name="editsubcategory_id" id="editsubcategory_id" class="selectpicker" data-style="select-with-transition"
                                    title="Select SubCategory" data-size="7">
                                    <?php foreach($subcategories as $subcategory){ ?>
                                                        <option data-categoryid="<?php echo $subcategory['category_id']; ?>" value="<?php echo $subcategory['id']; ?>"><?php echo $subcategory['sub_name']; ?></option>
                                                        <?php } ?>
                                </select>
                                    </div>
                                    <div class="modal-footer justify-content-center">


                                        <button type="submit" class="btn btn-fill btn-teal"
                                           >Submit</button>


                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--    end small modal -->
                        
                        <!-- My code starts-->

                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <a data-toggle="modal" data-target="#myModal11">
                                        <button class="btn btn-primary" style="background-color:#8f6bf4">

                                            <b> <i class="material-icons"><img
                                                        src="../../assets/img/icons/add-white-24dp.svg" /></i> Add
                                                Profession
                                            </b>
                                        </button>
                                    </a>

                                </div>
                                <div class="card">
                                    <div class="card-header card-header-rose card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons"><img
                                                    src="../../assets/img/list-white-24dp.svg" /></i>
                                        </div>
                                        <h4 class="card-title">Professions</h4>
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
                                                        <th class="text-center">S.No</th>
                                                        <th>Profession</th>
                                                        <th>Category</th>
                                                        <th>Sub Category</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-center">S.No</th>
                                                        <th>Profession</th>
                                                        <th>Category</th>
                                                        <th>Sub Category</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php   
                                                        if($professions != 'failure') {
                                                        foreach($professions as $key => $prof){ ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo ($key+1); ?></td>
                                                        <td><?php echo $prof['name']; ?></td>
                                                        <td><?php echo $prof['category']; ?></td>
                                                        <td><?php echo $prof['sub_name']; ?></td>
                                                        
                                                        <td class="td-actions">
                                                            <a data-toggle="modal" data-target="#myModal12">
                                                            <button data-name="<?php echo $prof['name']; ?>" data-id="<?php echo $prof['id']; ?>" data-category_id="<?php echo $prof['category_id']; ?>" 
                                                            data-subcategory_id="<?php echo $prof['subcategory_id']; ?>" type="button" rel="tooltip"
                                                                class="btn btn-success btn-round btnedit">
                                                                <i class="material-icons">
                                                                    <img
                                                                        src="../../assets/img/create-white-18dp (1).svg" />
                                                                </i>
                                                            </button>
                                                            </a>
                                                            <button data-id="<?php echo $prof['id']; ?>" type="button" rel="tooltip"
                                                                class="btn btn-danger btn-round btndelete">
                                                                <i class="material-icons">
                                                                    <img src="../../assets/img/close-white-18dp.svg" />
                                                                </i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                    
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
            
            $("#category_id").change(function () {
                category_id = $(this).val();
                $("#subcategory_id option").prop("selected", false);
                $("#subcategory_id option").each(function () {
                if (category_id != $(this).data('categoryid')) {
                   // alert("hide");
                    $(this).hide();
                }
                else {
                  //  alert("show");
                    $(this).show();
                }
                $('.selectpicker').selectpicker('refresh');
            });
            
            });
        });
        
        
        $(document).ready(function () {
        $('.btnedit').on('click', function() {
    	//alert($(this).data('category_id'));
        $("#editprofession_id").val($(this).data('id'));
        $("#editprofession_name").val($(this).data('name'));
        $("#editcategory_id").val($(this).data('category_id'));
        //$('#element option[value="no"]').attr("selected", "selected");
        $("#editsubcategory_id").val($(this).data('subcategory_id'));
        $("#editprofession_name").focus();
        $('.selectpicker').selectpicker('refresh');
       //return false;
   });
   
   $('.btndelete').on('click', function() {
       var profession_id = $(this).data('id');
       //alert(language_id);
       var result = confirm(" Want to delete?");
        if (result) {
         $.ajax({
            type: "POST",
            url: '<?php echo "deleteProfession";?>',
            data: {profession_id : profession_id },
            success: function(data){
            console.log(data);
            location.reload(true);
            },
            error: function(xhr, status, error){
            console.error(xhr);
            }
            });
        }
   });
        });
    </script>

</body>




</html>