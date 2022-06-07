<?php $this->extend("\Modules\Admin\Views\_layout\\template.php") ?>

<!-- Page Title Comes Here -->
<?php $title = "List Users" ?>

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

<?php $this->endsection(); ?>


<!-- Body Comes Here -->
<?php $this->section("body") ?>

<!-- My code starts-->

<div class="row">
    <div class="col-md-12">
        <?php $session = \Config\Services::session();
        $success = $session->getFlashdata('success');
        ?>
        <div>
            <a href="createNewUser">
                <button class="btn btn-rose pull-right" style="margin-bottom:10px">
                    <i class="material-icons" style="padding-right:10%">add</i><span>Add User</span>
                </button>
            </a>

        </div>
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">list</i>
                </div>
                <h4 class="card-title"><?php echo $title ?></h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-sm">User Id</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>User since (days)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>User Id</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>User since (days)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if ($arr_users != 'failure') {
                                foreach ($arr_users as $key => $users) {
                            ?>
                                    <tr>
                                        <td class="text-center"><?php echo $users['id']; ?></td>
                                        <td><?php echo $users['fname']; ?> </td>
                                        <td><?php echo $users['lname']; ?> </td>
                                        <td><?php echo $users['mobile']; ?> </td>
                                        <td><?php echo $users['email']; ?></td>
                                        <td><?php echo $users['days']; ?></td>
                                        <?php echo ($users['status'] == 1 ? "<td><span class='badge badge-success'>Active</span></td>" : "<td><span class='badge badge-danger'>Banned</span></td>"); ?></td>


                                        <!-- Script to change user active/ ban by toggle -->

                                        <!-- <div class="togglebutton">
                                                <label>
                                                 <input id="toggle-demo" class="my_switch" type="checkbox" checked data-toggle="toggle" data-on="Ready" data-off="Not Ready" data-onstyle="success" data-offstyle="danger"> -->
                                        <!-- <input id="statusx-<?php echo $users['id'] ?>" class="checkbox" type="checkbox" <?php echo ($users['status'] == 5 ? "unchecked" : "checked"); ?> onchange="change(<?php echo $users['id'] . ',' . $users['status']; ?>)">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div> -->

                                        <!-- <form id="frm-user-status-<?php echo $users['id'] ?>" action="<?php echo base_url("/ct/changeStatus"); ?>" method="post">
                                                <input type="hidden" name="user_id" id="user_id" value=<?php echo $users['id']; ?>>
                                                <input type="hidden" name="status" id="user_status" value=<?php echo $users['status']; ?>>
                                            </form> -->

                                        <!-- Script to change user active/ ban by toggle Ends Here -->


                                        <td class="td-actions">
                                            <a href="<?php echo "editUsers/" . $users['id']; ?>">
                                                <!-- <button type="button" rel="tooltip" class="btn btn-success btn-round"> -->
                                                <i class="material-icons text-secondary">edit
                                                    <!-- <img src="../../assets/img/create-white-18dp (1).svg" /> -->
                                                </i>
                                                <!-- </button> -->
                                            </a>
                                            <a href="#" onclick="if(confirm('Are you sure to delete?')){$('#frm-delete-user-<?php echo $users['id'] ?>').submit()}">
                                                <i class="material-icons lg text-danger">cancel
                                                    <!-- <img src="../../assets/img/close-white-18dp.svg" /> -->
                                                </i></a>
                                            <form id="frm-delete-user-<?php echo $users['id'] ?>" action="<?php echo base_url("/ct/deleteUser/" . $users['id']) ?>" method="post">
                                                <input type="hidden" name="_method" value="delete">
                                            </form>

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
<div id="snackbar"><?php echo $success; ?></div>
<!-- My code ends-->

<?php $this->endsection(); ?>


<!-- JS Script Comes Here -->
<?php $this->section("script") ?>

<script>
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
        // M.toast({
        //     html: "Hey! I am a toast."
        // })
        var flash = '';

        flash = '<?php echo $success; ?>';
        if (flash != '') {
            // Swal.fire({
            //     position: 'top-end',
            //     // icon: 'success',
            //     background: 'green',
            //     color: '#fffff',
            //     title: flash,
            //     showConfirmButton: false,
            //     timer: 1500
            // });
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function() {
                x.className = x.className.replace("show", "");
            }, 3000);
        }
    });
</script>

<?php $this->endsection(); ?>