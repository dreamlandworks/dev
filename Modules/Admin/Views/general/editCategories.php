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
                        <a class="navbar-brand" href="#pablo">Edit Category</a>
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
                                        <h4 class="card-title">Edit Category</h4>
                                    </div>
                                    <div class="card-body ">
                                        <form enctype="multipart/form-data" method="POST" id="categoryDetails" role="form" action="<?php echo ADMINBASEURL; ?>edit_category_submit">
                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 col-sm-12">
                                                    <input type="hidden" class="form-control" name="category_id" id="category_id" value="<?php echo $category->id; ?>">
                                                    

                                                    <div class="form-group">
                                                        <label for="exampleName" class="bmd-label-floating">Category Name
                                                        </label>
                                                        <input type="text" class="form-control" name="category_name" id="category_name" value="<?php echo $category->category; ?>">
                                                    </div>

                                                
                                                    <select name="category_status" id="category_status" class="selectpicker" data-style="select-with-transition"
                                                    title="Select Status" data-size="7">
                                                    <option <?=($category->status=='Active')?'selected':''; ?> value="Active" >Active </option>
                                                    <option <?=($category->status=='Inactive')?'selected':''; ?> value="Inactive">Inactive </option>
                                                </select>

                                              

                                                </div>
                                                <div class="col-lg-5 col-md-6 col-sm-12" style="margin:0.4rem 2rem">
                                    
                                                    

                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            <img src="<?= ($category->image)? $category->image: '../../assets/img/image_placeholder.jpg'; ?>" alt="...">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                        <div>
                                                            <span class="btn btn-teal btn-round btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" id="category_image" name="category_image" />
                                                            </span>
                                                            <a href="#pablo"
                                                                class="btn btn-danger btn-round fileinput-exists"
                                                                data-dismiss="fileinput"><i class="fa fa-times"></i>
                                                                Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           <div class="card-footer ">
                                             <button type="submit" class="btn btn-fill btn-teal">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <!-- MyCode ends here-->

                    </div>
                </div>
            </div>
         </div>   
    <!--   Core JS Files   -->
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
    <script>
    $(document).ready(function(){
	var categoryDetailsForm = $("#categoryDetails");	
    	var validator = categoryDetailsForm.validate({		
    		
    		rules:{
    			category_name :{ required : true}
    		},
    		messages:{
    		    category_name :{ required : "Category Name  is Required"}
    			
    		}
    	});
    });
   
</script>
