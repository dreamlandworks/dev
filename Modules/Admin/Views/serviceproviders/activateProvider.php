<?php $this->extend("\Modules\Admin\Views\_layout\\template.php") ?>

<!-- Page Title Comes Here -->
<?php $title = "Activate Service Providers" ?>

<?php $this->section("site_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>

<?php $this->section("nav_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>

<?php $this->section("section_title") ?>
<?php echo $title ?>
<?php $this->endsection(); ?>


<!-- Body Comes Here -->
<?php $this->section("body") ?>

<!-- My code starts-->

<div class="row">
    <div class="col-md-12 mr-auto ml-auto">
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">how_to_reg</i>
                </div>
                <h4 class="card-title">Service Providers Activation</h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>User Id</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Approve / Reject</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>User Id</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Approve / Reject</th>
                            </tr>
                        </tfoot>
                        <?php 
                         if ($spdata != 'failure') {
                            foreach ($spdata as $key => $sp) {
                        ?>

                        <tbody id="table_container">
                            <tr id='<?php echo "data".$sp['id']; ?>'>
                                <td class='text-center'><?php echo $sp['id']; ?></td>
                                <td><?php echo $sp['fname']; ?></td>
                                <td><?php echo $sp['lname']; ?></td>
                                <td><?php echo $sp['mobile']; ?></td>
                                <td><?php echo $sp['email']; ?></td>
                                <td><?php echo $sp['city']; ?></td>
                                <td><?php echo $sp['state']; ?></td>
                                <td><?php echo $sp['country']; ?></td>
                                <td>
                                    <div class='form-group'>
                                        <button id='approve' type='submit' class='btn btn-fill btn-success btn-sm' onclick="accept('<?php echo $sp['id'] ?>')">Approve</button>
                                        <button id='reject' type='submit' class='btn btn-fill btn-danger btn-sm' onclick="reject('<?php echo $sp['id'] ?>')">Reject</button>
                                    </div>
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
<?php $this->endsection(); ?>

<!-- CSS Styles Comes Here -->
<?php $this->section("styles") ?>

<?php $this->endsection(); ?>



<!-- JS Script Comes Here -->
<?php $this->section("script") ?>

<script>
    // $(document).ready(function() {
    //     $.ajax({
    //         type: "GET",
    //         url: "<?php echo base_url() . '/ct/providerdata' ?>",
    //         dataType: "html",
    //         success: function(data) {
    //             $("#table_container").html(data);
    //             console.log(data);
    //         }
    //     });
    // });


    function accept(id) {

        var dat = {
            id: id,
            status: 3
        };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/ct/approve'; ?>",
            data: dat,
            dataType: "json",
            encode: true,
        }).done(function(data) {
            console.log(data);
        });

        event.preventDefault();

        var text1 = "#data";
        var id = id;
        var result = text1.concat(id);

        $(result).attr('style', 'display:none');

    }

    function reject(id) {
        var dat = {
            id: id,
            status: 4
        };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/ct/approve'; ?>",
            data: dat,
            dataType: "json",
            encode: true,
        }).done(function(data) {
            console.log(data);
        });

        event.preventDefault();

        var text1 = "#data";
        var id = id;
        var result = text1.concat(id);

        $(result).attr('style', 'display:none');

    }

    //Data Tables Script
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
</script>

<?php $this->endsection(); ?>