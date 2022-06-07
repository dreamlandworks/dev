<?php $this->extend("\Modules\Admin\Views\_layout\\template.php") ?>

<!-- Page Title Comes Here -->
<?php $title = "List Service Providers" ?>

<?php $this->section("site_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>

<?php $this->section("nav_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>

<?php $this->section("section_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>

<!-- StyleSheets Comes Here -->
<?php $this->section("styles") ?>
<style>
    .noneGroup {
        display: none;
    }

    .overlay {
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        position: fixed;
        background: #44485730;
        z-index: 1051;
    }

    .overlay__inner {
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        position: absolute;
    }

    .overlay__content {
        left: 50%;
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .spinner {
        width: 75px;
        height: 75px;
        display: inline-block;
        border-width: 2px;
        border-color: rgba(255, 255, 255, 0.05);
        border-top-color: #fff;
        animation: spin 1s infinite linear;
        border-radius: 100%;
        border-style: solid;
    }

    .tr-center td,
    th {
        text-align: center;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }
</style>
<?php $this->endsection(); ?>


<!-- Body Comes Here -->
<?php $this->section("body") ?>
<!-- My code starts-->

<div class="row">
    <div class="col-md-12 mr-auto ml-auto">
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
                    <i class="material-icons">list</i>
                </div>
                <h4 class="card-title">Service Providers</h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="display nowrap table table-striped table-no-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th>User Id</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Points</th>
                                <th>Rating</th>
                                <th>More</th>

                                <!-- <th>Bookings Completed</th>
                                <th>Bookings Rejected</th>
                                <th>Bids Submitted</th>
                                <th>Bids Awarded</th>
                                <th>Status</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th>User Id</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Points</th>
                                <th>Rating</th>
                                <th>More</th>
                                <!-- <th>Bookings Completed</th>
                                <th>Bookings Rejected</th>
                                <th>Bids Submitted</th>
                                <th>Bids Awarded</th>
                                <th>Status</th> -->
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>

                            <?php
                            if ($data != 'failure') {
                                foreach ($data as $key => $sp) {
                            ?>
                                    <tr class="text-center">
                                        <td><?php echo $sp->id; ?></td>
                                        <td><?php echo $sp->fname; ?></td>
                                        <td><?php echo $sp->lname; ?></td>
                                        <td><?php echo $sp->mobile; ?></td>
                                        <td><?php echo $sp->email; ?></td>
                                        <td><?php echo $sp->city; ?></td>
                                        <td><?php echo $sp->state; ?></td>
                                        <td><?php echo $sp->country; ?></td>
                                        <td><?php echo $sp->points_count; ?></td>
                                        <td><?php echo $sp->review; ?></td>
                                        <td><a href="#" data-toggle="modal" data-target="#myModal" onclick="get_data(<?php echo $sp->id; ?>)"><i class="material-icons lg text-primary">more_vert</i></a></td>

                                        <td class="td-actions">
                                            <a href="editServiceProviders/<?php echo $sp->id; ?>">
                                                <!-- <button type="button" rel="tooltip" class="btn btn-success btn-round"> -->
                                                <i class="material-icons text-primary">edit</i>
                                                <!-- </button> -->
                                            </a>
                                            <a href="javascript:" data-id="<?php echo $sp->id; ?>" class="deactivate">
                                                <!-- <button type="button" rel="tooltip" class="btn btn-danger btn-round"> -->
                                                <i class="material-icons text-danger">cancel</i>
                                                <!-- </button> -->
                                            </a>
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

    <!-- To Display More SP Data -->
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Extra Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="extra_data">

                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Ends Here -->

</div>

<!-- My code ends-->

<?php $this->endsection(); ?>


<!-- JS Script Comes Here -->
<?php $this->section("script") ?>

<script>
    function get_data(id) {

        var id = id;
        var m_id = "#extra_data";
        console.log(m_id);
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>" + "/ct/providerdata/" + id,
            dataType: "html",
            success: function(data) {
                $("#extra_data").html(data);
                console.log(data);
            }
        });
    }


    $(document).ready(function() {
        $('#datatables').DataTable({
            "scrollX": true,
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });

    });

    $(document).on('click', '.deactivate',function(){
        var userId = $(this).attr('data-id');
        alert(userId);
    })

    $(document)
        .ajaxStart(function() {
            $('.overlay').removeClass('noneGroup');
        })
        .ajaxStop(function() {
            $('.overlay').addClass("noneGroup");
        })
        .ajaxError(function() {
            alert("Opps! Somthing Went Wrong! Try Again");
        });
</script>

<?php $this->endsection(); ?>