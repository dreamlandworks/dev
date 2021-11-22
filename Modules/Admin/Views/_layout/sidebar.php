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
            <li class="nav-item active">
                <a class="nav-link" href="dashboard">
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
                            <a class="nav-link" href="createNewUser">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Create a New User </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="listUsers">
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
                            <a class="nav-link" href="activateProvider">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Activate Provider </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="list_providers">
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
                            <a class="nav-link" href="receipts">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Receipts </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="receiptsDue">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Receipts Due </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="paymentRequests">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Payment Requests </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="paymentDone">
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
                <div class="collapse" id="bookings">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="createNewBooking">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Create New Booking </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="listBooking">
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
                            <a class="nav-link" href="newJobs">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> New Jobs </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="postJob">
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
                            <a class="nav-link" href="createTickets">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Create Tickets </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="listAllTickets">
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
                            <a class="nav-link" href="categories">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Categories </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="subcategories">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Sub Categories </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="keywords">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Keywords </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="languages">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> Languages </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="professions">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal">Professions </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="qualifications">
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
                            <a class="nav-link" href="viewPosts">
                                <span class="sidebar-mini"> <i class="material-icons">
                                        <img src="../../assets/img/icons/add-white-24dp.svg" />
                                    </i> </span>
                                <span class="sidebar-normal"> View Posts </span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="createNewPost">
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
                            <a class="nav-link" href="cancellationCharges">
                                <span class="sidebar-mini"> <i class="material-icons"><img
                                            src="../../assets/img/icons/add-white-24dp.svg" /></i> </span>
                                <span class="sidebar-normal"> Cancellation Charges</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="userPlans">
                                <span class="sidebar-mini"> <i class="material-icons"><img
                                            src="../../assets/img/icons/add-white-24dp.svg" /></i> </span>
                                <span class="sidebar-normal">User Plans </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="providerPlans">
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