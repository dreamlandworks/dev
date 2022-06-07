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
                        <a class="navbar-brand" href="#pablo">Create User Plan</a>
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
                                        <h4 class="card-title">New User Plan</h4>
                                    </div>
                                    <div class="card-body ">
                                        <form enctype="multipart/form-data" method="POST" id="userplans" role="form" action="<?php echo ADMINBASEURL; ?>create_userplan_submit">
                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="exampleName" class="bmd-label-floating">
                                                            Name</label>
                                                        <input type="text" class="form-control" id="name" name="name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleName" class="bmd-label-floating">
                                                            Amount </label>
                                                        <input type="text" class="form-control" id="amount" name="amount" >
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleName" class="bmd-label-floating">Period in
                                                            Days
                                                        </label>
                                                        <input type="text" class="form-control" id="period" name="period">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleName" class="bmd-label-floating"> No. Posts
                                                            per month
                                                        </label>
                                                        <input type="text" class="form-control" id="posts_per_month" name="posts_per_month">
                                                    </div>


                                                </div>
                                                <div class="col-lg-5 col-md-6 col-sm-12" style="margin:0.4rem 2rem">
                                                    <div class="form-group">
                                                        <label for="exampleName" class="bmd-label-floating"> No.
                                                            Proposals per post
                                                        </label>
                                                        <input type="text" class="form-control" id="proposals_per_post" name="proposals_per_post">
                                                    </div>
                                                    <select class="selectpicker" data-style="select-with-transition"
                                                        title="Premium Tag" data-size="7" name="premium_tag" id="premium_tag">
                                                        <option value="Yes">Yes </option>
                                                        <option value="No">No </option>
                                                    </select>

                                                    <select class="selectpicker" data-style="select-with-transition"
                                                        title="Customer Support" data-size="7" id="customer_support" name="customer_support">
                                                        <option value="Yes">Yes </option>
                                                        <option value="No">No </option>
                                                    </select>

                                                    <!--<select class="selectpicker" data-style="select-with-transition"-->
                                                    <!--    title="Select Status" data-size="7">-->
                                                    <!--    <option value="2">Yes </option>-->
                                                    <!--    <option value="3">No </option>-->
                                                    <!--</select>-->

                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-md-2 col-form-label"> Description : </label>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <div id="editor" >
                                                            <p id="description" name="description">This is some sample content.</p>
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
            
    
    <script>

        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });

    </script>
    <script>
    $(document).ready(function(){
	var userplansForm = $("#userplans");	
    	var validator = userplansForm.validate({		
    		
    		rules:{
    			name :{ required : true},
    			description :{ required : true},
    			amount :{ required : true},
    			period :{ required : true},
    			posts_per_month :{ required : true},
    			proposals_per_post :{ required : true},
    			premium_tag:{required : true},
    			customer_support:{required : true}
    			
    		},
    		messages:{
    		    name :{ required : "Name  is Required"},
    		    description : {required : "Description is required"},
    		    amount : {required : "Amount is required"},
    		    period : {required : "Period is required"},
    		    posts_per_month : {required : "Post per month is required"},
    		    proposals_per_post : {required : "Proposal per month is required"},
    		    premium_tag:{required : "Select Any one option"},
    		    customer_support:{required : "Select Any one option"}
    			
    		}
    	});
    });
   
</script>

</body>
</html>