           <!--footer section starts-->
           <footer class="footer">
            <div style="width:99%;">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="footerimg">
                            <img src="../../assets/img/footerimg.png" alt="footerimg" class="img-fluid" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="copyright">
                            &copy;
                            <a href="https://www.satrango.com/" target="_blank">www.satrango.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--footer section ends-->
    </div>
</div>

<div></div>
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

    // var ctxHor = document.getElementById('myHorizontal').getContext('2d');
    // var ctxbar = document.getElementById('myChartBar').getContext('2d');
    // var ctx2 = document.getElementById('myChart2').getContext('2d');
    var ctx1 = document.getElementById('myChart1').getContext('2d');
    var ctxline = document.getElementById('myChartline').getContext('2d');
    // var ctxpay2 = document.getElementById('myChartPay2').getContext('2d');
    var ctxpay1 = document.getElementById('myChartPay1').getContext('2d');
    var ctxlinepay = document.getElementById('myChartlinePay').getContext('2d');


    var myChartlinePay = new Chart(ctxlinepay, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                data: [86, 114, 106, 106, 107, 111, 133, 86, 114, 106, 106, 107, 111, 133],
                label: "This Year",
                borderColor: "#2bbddd",
                backgroundColor: "#2bbddd",
                fill: false,
            }, {
                data: [70, 90, 44, 60, 83, 90, 100, 70, 90, 44, 60, 83, 90, 100],
                label: "Last Year",
                borderColor: "#2c66bf",
                backgroundColor: "#2c66bf",
                fill: false,
            }
            ]
        },
    });

    // var myChartPay2 = new Chart(ctxpay2, {
    //     type: 'pie',
    //     data: {
    //         labels: ['Payments Today', 'Payments yesterday'],
    //         datasets: [{
    //             label: '# of Votes',
    //             data: [19, 15],
    //             backgroundColor: [
    //                 '#2cbfbf',
    //                 '#8f6bf4'
    //             ],

    //         }]
    //     },
    //     options: {
    //         legend: {
    //             display: true,
    //             position: 'bottom',
    //             align: 'start'
    //         },
    //     },
    // });

    var myChartPay1 = new Chart(ctxpay1, {
        type: 'pie',
        data: {
            labels: ['Payments This Month', 'Payments Last Month'],
            datasets: [{
                label: '# of Votes',
                data: [1000, 800],
                backgroundColor: [
                    '#2cbfbf',
                    '#8f6bf4'
                ],

            }]
        },
        options: {
            legend: {
                display: true,
                position: 'bottom',
                align: 'start'
            },
        },
    });




    var myChartline = new Chart(ctxline, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                data: [86, 114, 106, 106, 107, 111, 133, 86, 114, 106, 106, 107, 111, 133],
                label: "This Year",
                borderColor: "#2bbddd",
                backgroundColor: "#2bbddd",
                fill: false,
            }, {
                data: [70, 90, 44, 60, 83, 90, 100, 70, 90, 44, 60, 83, 90, 100],
                label: "Last Year",
                borderColor: "#2c66bf",
                backgroundColor: "#2c66bf",
                fill: false,
            }
            ]
        },
    });

    // var myChart2 = new Chart(ctx2, {
    //     type: 'pie',
    //     data: {
    //         labels: ['Income Today', 'Income yesterday'],
    //         datasets: [{
    //             label: '# of Votes',
    //             data: [19, 15],
    //             backgroundColor: [
    //                 '#2cbfbf',
    //                 '#8f6bf4'
    //             ],

    //         }]
    //     },
    //     options: {
    //         legend: {
    //             display: true,
    //             position: 'bottom',
    //             align: 'start'
    //         },
    //     },
    // });

    var myChart1 = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: ['Income This Month', 'Income Last Month'],
            datasets: [{
                label: '# of Votes',
                data: [1000, 800],
                backgroundColor: [
                    '#2cbfbf',
                    '#8f6bf4'
                ],

            }]
        },
        options: {
            legend: {
                display: true,
                position: 'bottom',
                align: 'start'
            },
        },
    });


    // var myHorizontal = new Chart(ctxHor, {
    //     // The type of chart we want to create
    //     type: 'horizontalBar',

    //     // The data for our dataset
    //     data: {
    //         labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    //         datasets: [{
    //             label: 'Topper Performace',
    //             backgroundColor: 'rgb(255, 99, 132)',
    //             borderColor: 'rgb(255, 99, 132)',
    //             data: [0, 10, 5, 2, 20, 30, 45],
    //             fill: false
    //         }, {
    //             label: 'Your Performance',
    //             backgroundColor: 'rgba(75, 192, 192)',
    //             borderColor: 'rgba(75, 192, 192)',
    //             data: [0, 30, 15, 20, 0, 10, 40],
    //             fill: false
    //         },
    //         ]
    //     },

    //     options: {

    //     }
    // });

    // var myChartBar = new Chart(ctxbar, {
    //         type: 'bar',
    //         data: {
    //             labels: ["Today", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
    //             datasets: [{
    //                 data: [86, 114, 106, 106, 107, 111, 133],
    //                 label: "Subject 1",
    //                 borderColor: "#2bbddd",
    //                 backgroundColor: "#2bbddd",
    //                 borderWidth: 2
    //             }, {
    //                 data: [70, 90, 74, 68, 83, 90, 100],
    //                 label: "Subject 2",
    //                 borderColor: "#2c66bf",
    //                 backgroundColor: "#2c66bf",
    //                 borderWidth: 2
    //             }, {
    //                 data: [86, 70, 68, 74, 70, 90, 74],
    //                 label: "Subject 3",
    //                 borderColor: "#2cbfbf",
    //                 backgroundColor: "#2cbfbf",
    //                 borderWidth: 2
    //             }
    //             ]
    //         },
    //     });
</script>
 

</body>




</html>